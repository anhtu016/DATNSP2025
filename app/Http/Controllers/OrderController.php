<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\Coupon;
use App\Events\OrderStatusUpdated;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;
use App\Models\Variant;
use App\Services\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::with('customer')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($orderId)
    {
        $order = Order::with('orderDetail.variant.attributeValues.attribute')->find($orderId);
        if (!$order) {
            abort(404, 'Đơn hàng không tồn tại');
        }
        return view('admin.orders.show', compact('order'));
    }


    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|string'
        ]);

        $newStatus = $request->order_status;
        $currentStatus = $order->order_status;

        // Danh sách chuyển trạng thái hợp lệ theo thứ tự
        $allowedTransitions = [
            'pending' => ['processing', 'cancelled'],
            'processing' => ['delivering'],
            'delivering' => ['shipped'],
            'shipped' => ['delivered'],
        ];

        // Kiểm tra nếu không có chuyển tiếp hợp lệ
        if (!isset($allowedTransitions[$currentStatus]) || !in_array($newStatus, $allowedTransitions[$currentStatus])) {
            return back()->with('error', 'Không thể chuyển trạng thái từ "' . $currentStatus . '" sang "' . $newStatus . '".');
        }

        // Nếu là hủy đơn hàng
        if ($newStatus === 'cancelled') {
            // Chỉ cho phép hủy nếu đang ở trạng thái 'pending'
            if ($currentStatus !== 'pending') {
                return back()->with('error', 'Chỉ có thể hủy đơn hàng khi đang ở trạng thái chờ xử lý.');
            }

            DB::beginTransaction();
            try {
                foreach ($order->orderDetails as $detail) {
                    $variant = Variant::find($detail->variant_id);
                    if ($variant) {
                        $variant->quantity_variant += $detail->quantity;
                        $variant->save();
                    }
                }

                $order->order_status = 'cancelled';
                $order->cancelled_at = now(); // Ghi nhận thời gian hủy đơn hàng

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Đã xảy ra lỗi khi hủy đơn: ' . $e->getMessage());
            }
        } else {
            // Cập nhật thời gian tương ứng theo trạng thái mới
            switch ($newStatus) {
                case 'processing':
                    $order->processing_at = now();
                    break;
                case 'delivering':
                    $order->delivering_at = now();
                    break;
                case 'shipped':
                    $order->shipped_at = now();
                    break;
                case 'delivered':
                    $order->delivered_at = now();
                    break;
            }

            $order->order_status = $newStatus;
        }

        $order->save();

        event(new OrderStatusUpdated($order));

        return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }



    public function rejectCancel($orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->order_status === 'cancel_requested') {
            $order->update(['order_status' => 'pending']);
        }

        return redirect()->back()->with('success', 'Yêu cầu hủy đã bị từ chối.');
    }
    public function requestCancel($id)
    {
        $order = Order::where('id', $id)
            ->where('customer_id', auth()->id())
            ->where('order_status', 'pending')
            ->firstOrFail();


        $order->order_status = 'cancel_requested';
        $order->save();

        return redirect()->route('user.orders.show', $order->id)
            ->with('success', 'Yêu cầu hủy đơn hàng đã được gửi. Vui lòng chờ xác nhận từ quản trị viên.');
    }

    public function create(Request $request)
    {
        $cart = session()->get('cart', []);

        // Tính tổng giá trị giỏ hàng
        $cartTotal = 0;
         
        $now = now();
        foreach ($cart as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
        }

        $coupons = Coupon::where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->where(function ($query) use ($cartTotal) {
                $query->where('min_order_value', '<=', $cartTotal)
                    ->orWhereNull('min_order_value');
            })
            ->where(function ($query) {
                $query->whereColumn('usage_count', '<', 'usage_limit')
                    ->orWhereNull('usage_limit');
            })
            ->orderBy('value', 'desc') // Coupon giá trị giảm cao hơn ưu tiên trước
            ->take(3)
            ->get();
        $selectedIds = $request->input('selected_items', []); // Mảng ID sản phẩm được chọn
        $sessionCart = session()->get('cart', []);
        $cart = [];

        // Lọc sản phẩm đã chọn
        foreach ($selectedIds as $id) {
            if (isset($sessionCart[$id])) {
                $cart[$id] = $sessionCart[$id];
            }
        }

        $total = 0;
        foreach ($cart as &$item) {
            $item['total'] = $item['price'] * $item['quantity'];
            $item['discount_amount'] = 0;
            $item['total_after_discount'] = $item['total'];
            $total += $item['total'];
        }
        // $coupon = session('coupon');
// dd($coupon);

        // Tính giảm giá theo mã
        $discountAmount = 0;
        if (session('coupon')) {
            $coupon = session('coupon');
            if ($coupon['type'] === 'fixed') {
                $discountAmount = $coupon['value'];
            } elseif ($coupon['type'] === 'percentage') {
                $discountAmount = $total * $coupon['value'] / 100;
            }
        }

        $totalAfterDiscount = $total - $discountAmount;

        $shippingMethods = [
            1 => 'Giao hàng nhanh',
            2 => 'Giao hàng tiêu chuẩn',
        ];

        $paymentMethods = [
            1 => 'Thanh toán khi nhận hàng',
            2 => 'PayPal',
        ];

        $userName = Auth::user()?->name ?? 'Khách';

        return view('client.order', compact(
            'cart',
            'total',
            'discountAmount',
            'totalAfterDiscount',
            'shippingMethods',
            'paymentMethods',
            'userName',
            'coupons'
            
        ));
    }




    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string|max:255',
            'phone_number' => 'required|regex:/^([0-9]{10})$/',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Giỏ hàng của bạn không có sản phẩm.');
        }




        $orderDate = now();
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        $discountAmount = session('coupon')['discount_amount'] ?? 0;
        $totalAfterDiscount = max($total - $discountAmount, 0);
        $customerId = Auth::id();

        DB::beginTransaction();

        try {
            // Tạo đơn hàng mới
            $order = Order::create([
                'total_amount' => $totalAfterDiscount,
                'shipping_address' => $request->shipping_address,
                'order_date' => $orderDate,
                'shipping_method_id' => $request->shipping_method_id,
                'payment_methods_id' => $request->payment_methods_id,
                'phone_number' => $request->phone_number,
                'customer_id' => $customerId,
                'order_status' => 'pending',
                'coupon_code' => session('coupon')['code'] ?? null,
                'discount_amount' => $discountAmount,
            ]);

            // Lưu chi tiết đơn hàng
            foreach ($cart as $item) {
                $variant = Variant::where('id', $item['variant_id'])->lockForUpdate()->first();

                if (!$variant) {
                    DB::rollBack();
                    return back()->with('error', 'Không tìm thấy biến thể cho sản phẩm: ' . $item['name']);
                }

                if ($variant->quantity_variant < $item['quantity']) {
                    DB::rollBack();
                    return back()->with('error', 'Số lượng trong kho không đủ cho sản phẩm: ' . $item['name']);
                }

                $variant->quantity_variant -= $item['quantity'];
                $variant->save();

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'variant_id' => $item['variant_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['price'] * $item['quantity'],
                ]);
            }

            // Cập nhật coupon nếu có
            if ($couponCode = session('coupon')['code'] ?? null) {
                $coupon = Coupon::where('code', $couponCode)->first();
                if ($coupon) {
                    $coupon->increment('usage_count');
                }
            }

            // Nếu chọn PayPal
            if ($request->payment_methods_id == 2) {
                // Lưu thông tin tạm vào session
                session([
                    'checkout_data' => [
                        'shipping_address' => $request->shipping_address,
                        'phone_number' => $request->phone_number,
                        'shipping_method_id' => $request->shipping_method_id,
                        'payment_methods_id' => $request->payment_methods_id,
                        'cart' => $cart,
                        'coupon' => session('coupon'),
                        'total_after_discount' => $totalAfterDiscount,
                        'total' => $total,
                    ]
                ]);

                $client = PayPalClient::client();
                $paypalRequest = new OrdersCreateRequest();
                $paypalRequest->prefer('return=representation');
                $paypalRequest->body = [
                    "intent" => "CAPTURE",
                    "purchase_units" => [
                        [
                            "amount" => [
                                "currency_code" => "USD",
                                "value" => number_format($totalAfterDiscount / 24000, 2, '.', '')
                            ]
                        ]
                    ],
                    "application_context" => [
                        "cancel_url" => route('paypal.cancel'),
                        "return_url" => route('paypal.success')
                    ]
                ];

                $response = $client->execute($paypalRequest);
                foreach ($response->result->links as $link) {
                    if ($link->rel === 'approve') {
                        return redirect($link->href);
                    }
                }

                return back()->with('error', 'Không thể chuyển đến PayPal.');
            }


            // Nếu không phải PayPal thì hoàn tất luôn
            session()->forget('cart');
            session()->forget('coupon');

            DB::commit();
            return redirect()->route('home')->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Đặt hàng thất bại: ' . $e->getMessage());
        }
    }










    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        if (in_array($order->order_status, ['cancelled'])) {
            $order = Order::find($id);
            $order->orderDetails()->delete();
            $order->delete();

            return redirect()->back()->with('success', 'Đã xoá đơn hàng thành công.');
        }

        return redirect()->back()->with('error', 'Chỉ được xoá đơn hàng đã hủy.');
    }



    public function confirmCancel($id)
    {
        $order = Order::with('orderDetail.Variant.Product')->findOrFail($id);

        if ($order->order_status !== 'cancel_requested') {
            return redirect()->route('admin.orders.index')->with('error', 'Đơn hàng không yêu cầu hủy hoặc đã hủy trước đó.');
        }

        // ✅ Cộng lại số lượng cho từng biến thể
        foreach ($order->orderDetail as $item) {
            $variant = $item->variant;

            if ($variant) {
                // Cộng lại số lượng tồn kho cho biến thể
                $variant->quantity_variant += $item->quantity;
                $variant->save();

                // Nếu bạn lưu tổng số lượng ở bảng product thì cộng lại
                $product = $variant->product;
                if ($product) {
                    $product->quantity += $item->quantity;
                    $product->save();
                }
            }
        }

        // ✅ Cập nhật trạng thái đơn hàng
        $order->order_status = 'cancelled';
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được xác nhận hủy và tồn kho đã được cập nhật.');
    }

    public function approveCancel($orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->order_status === 'cancel_requested') {
            $order->update(['order_status' => 'cancelled']);
        }

        return redirect()->back()->with('success', 'Đơn hàng đã được hủy.');
    }

    // áp dụng mã giảm giá
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string'
        ]);

        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon) {
            return back()->with('coupon_error', 'Mã giảm giá không hợp lệ.');
        }

        // Lưu mã giảm giá vào session
        session([
            'coupon' => [
                'code' => $coupon->code,
                'type' => $coupon->type,
                'value' => $coupon->value,
            ]
        ]);

        return back()->with('success', 'Áp dụng mã giảm giá thành công!');
    }




    public function removeCoupon()
    {
        session()->forget('coupon');

        return redirect()->back()->with('success', 'Đã hủy mã giảm giá.');
    }

}