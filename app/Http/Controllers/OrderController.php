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

        // Trạng thái đã hủy - Hoàn lại sản phẩm vào kho
        if ($newStatus === 'cancelled' && $order->order_status !== 'cancelled') {
            DB::beginTransaction(); // Bắt đầu giao dịch

            try {
                // Duyệt qua các chi tiết của đơn hàng để hoàn lại số lượng sản phẩm vào kho
                foreach ($order->orderDetails as $detail) {
                    $variant = Variant::find($detail->variant_id);
                    if ($variant) {
                        // Cộng số lượng vào kho
                        $variant->quantity_variant += $detail->quantity;
                        $variant->save();
                    }
                }

                // Cập nhật trạng thái đơn hàng thành "Đã hủy"
                $order->order_status = $newStatus;

                DB::commit(); // Cam kết giao dịch
            } catch (\Exception $e) {
                DB::rollBack(); // Rollback giao dịch nếu có lỗi
                return back()->with('error', 'Cập nhật trạng thái thất bại: ' . $e->getMessage());
            }
        } else {
            // Chỉ cập nhật các trạng thái khác không liên quan đến việc hoàn kho
            $order->order_status = $newStatus;
        }

        // Cập nhật thời gian tương ứng với trạng thái (nếu có)
        if ($newStatus === 'delivered') {
            $order->delivered_at = now();
        }

        if ($newStatus === 'delivering') {
            $order->delivering_at = now();
        }

        if ($newStatus === 'processing') {
            $order->processing_at = now();
        }

        $order->save(); // Lưu thông tin đơn hàng

        event(new OrderStatusUpdated($order)); // Gửi event khi cập nhật trạng thái

        return back()->with('success', 'Cập nhật trạng thái thành công.');
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
    // xử lý đơn hàng trong thanh toán
    public function create(Request $request)
    {
        $cart = session()->get('cart', []);
        $total = 0;


        // Tính tổng tiền các sản phẩm đã chọn
        foreach ($cart as &$item) {
            $item['total'] = $item['price'] * $item['quantity'];
            $total += $item['total'];
        }

        // Áp dụng mã giảm giá nếu có
        $discountAmount = 0;
        $couponSession = session('coupon');

        if ($couponSession) {
            if ($total < ($couponSession['min_order_value'] ?? 0)) {
                return back()->with('error', 'Không đủ điều kiện áp dụng mã giảm giá.');
            }

            if ($couponSession['type'] === 'fixed') {
                $discountAmount = $couponSession['value'];
            } elseif ($couponSession['type'] === 'percentage') {
                $discountAmount = ($total * $couponSession['value']) / 100;
                if (!empty($couponSession['max_discount_value']) && $discountAmount > $couponSession['max_discount_value']) {
                    $discountAmount = $couponSession['max_discount_value'];
                }
            }

            // Giới hạn số tiền giảm giá để không vượt quá tổng giỏ hàng
            if ($discountAmount > $total) {
                $discountAmount = $total;  // Không thể giảm nhiều hơn tổng giỏ hàng
            }

            // Cập nhật lại vào session (giữ nguyên các giá trị khác)
            $couponSession['discount_amount'] = $discountAmount;
            session(['coupon' => $couponSession]);
        }

        // Phân bổ giảm giá cho từng sản phẩm
        foreach ($cart as &$item) {
            $ratio = $item['total'] / $total;
            $item['discount_amount'] = round($ratio * $discountAmount);
            $item['total_after_discount'] = $item['total'] - $item['discount_amount'];
        }

        $shippingMethods = [
            1 => 'Giao hàng nhanh',
            2 => 'Giao hàng tiêu chuẩn',
        ];

        $paymentMethods = [
            1 => 'Thanh toán khi nhận hàng',
            2 => 'PayPal',
        ];

        $userName = Auth::user()?->name ?? 'Khách';

        return view('client.order', compact('cart', 'total', 'discountAmount', 'shippingMethods', 'paymentMethods', 'userName'));
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
                        "return_url" => route('paypal.success', ['order_id' => $order->id])
                    ]
                ];

                $response = $client->execute($paypalRequest);
                DB::commit();

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


    public function storecoupon(Request $request)
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if (!$product) {
                return back()->with('error', 'Sản phẩm không tồn tại.');
            }

            if ($product->quantity < $item['quantity']) {
                return redirect()->back()
                    ->with('error', 'Sản phẩm "' . $product->name . '" không đủ số lượng trong kho. Vui lòng điều chỉnh số lượng.');
            }

            $total += $item['price'] * $item['quantity'];
        }

        $discount = 0;
        $couponCode = $request->input('coupon_code');
        $coupon = null;

        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->first();

            if (!$coupon) {
                return back()->with('error', 'Mã giảm giá không hợp lệ hoặc đã hết hạn.');
            }

            if ($coupon->min_order_value && $total < $coupon->min_order_value) {
                return back()->with('error', 'Đơn hàng không đủ điều kiện áp dụng mã giảm giá.');
            }

            if ($coupon->type === 'percentage') {
                $discount = $total * ($coupon->value / 100);
            } else {
                $discount = $coupon->value;
            }
        }

        $customerId = Auth::id();

        try {
            $order = Order::create([
                'total_amount' => $total,
                'discount_amount' => $discount,
                'coupon_code' => $couponCode,
                'shipping_address' => $request->shipping_address,
                'order_date' => now(),
                'shipping_method_id' => $request->shipping_method_id,
                'payment_methods_id' => $request->payment_methods_id,
                'phone_number' => $request->phone_number,
                'customer_id' => $customerId,
                'order_status' => 'pending',
            ]);

            foreach ($cart as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'variant_id' => $item['variant_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['price'] * $item['quantity'],
                ]);
            }

            session()->forget('cart');

        } catch (\Exception $e) {
            return back()->with('error', 'Đặt hàng thất bại: ' . $e->getMessage());
        }

        return redirect()->route('home')->with('success', 'Đặt hàng thành công!');
    }


}