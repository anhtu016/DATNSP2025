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

    $order->order_status = $request->order_status;

    // trạng thái
    if ($request->order_status === 'delivered') {
        $order->delivered_at = now();
    }

    if ($request->order_status === 'delivering') {
        $order->delivering_at = now();
    }

    if ($request->order_status === 'processing') {
        $order->processing_at = now();
    }
    $order->save();
    event(new OrderStatusUpdated($order));


    
    return back()->with('success', 'Cập nhật trạng thái thành công.');
}



public function approveCancel($orderId)
{
    $order = Order::findOrFail($orderId);

    if ($order->order_status === 'cancel_requested') {
        $order->update(['order_status' => 'cancelled']);
    }

    return redirect()->back()->with('success', 'Đơn hàng đã được hủy.');
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
public function create()
{
    $cart = session()->get('cart', []);
    $total = 0;

    // Tính tổng từng sản phẩm
    foreach ($cart as &$item) {
        $item['total'] = $item['price'] * $item['quantity'];
        $total += $item['total'];
    }

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
        2 => 'Chuyển khoản ngân hàng',
        3 => 'Momo',
    ];

    $userName = Auth::user()?->name ?? 'Khách'; 
    
    return view('client.order', compact('cart', 'total', 'discountAmount', 'shippingMethods', 'paymentMethods', 'userName'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'shipping_address' => 'required|string|max:255',
        'phone_number' => 'required|regex:/^([0-9]{10})$/',
        // 'payment_methods_id' => 'required|exists:payment_methods,id',
        // 'shipping_method_id' => 'required|exists:shipping_methods,id',
    ], [
        'shipping_address.required' => 'Địa chỉ giao hàng là bắt buộc.',
        'shipping_address.max' => 'Địa chỉ giao hàng không quá 255 ký tự.',
        'phone_number.required' => 'Số điện thoại là bắt buộc.',
        'phone_number.regex' => 'Số điện thoại không hợp lệ.',
        // 'payment_methods_id.required' => 'Phương thức thanh toán là bắt buộc.',
        // 'payment_methods_id.exists' => 'Phương thức thanh toán không hợp lệ.',
        // 'shipping_method_id.required' => 'Phương thức giao hàng là bắt buộc.',
        // 'shipping_method_id.exists' => 'Phương thức giao hàng không hợp lệ.',
    ]);

    $cart = session()->get('cart', []);
    if (empty($cart)) {
        return back()->with('error', 'Giỏ hàng của bạn không có sản phẩm.');
    }

    $orderDate = now(); // Lấy ngày giờ hiện tại

    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    $discountAmount = session('coupon')['discount_amount'] ?? 0;
    $totalAfterDiscount = max($total - $discountAmount, 0);
    $customerId = Auth::id();

    try {
        if ($request->payment_methods_id == 3) {
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

            session([
                'pending_order' => [
                    'order_id' => $order->id,
                    'shipping_address' => $request->shipping_address,
                    'shipping_method_id' => $request->shipping_method_id,
                    'payment_methods_id' => $request->payment_methods_id,
                    'phone_number' => $request->phone_number,
                    'total_amount' => $totalAfterDiscount,
                    'discount_amount' => $discountAmount,
                    'cart' => $cart,
                    'coupon_code' => session('coupon')['code'] ?? null,
                ]
            ]);

            $endpoint = config('services.momo.endpoint');
            $partnerCode = config('services.momo.partner_code');
            $accessKey = config('services.momo.access_key');
            $secretKey = config('services.momo.secret_key');
            $redirectUrl = config('services.momo.redirect_url');
            $ipnUrl = config('services.momo.ipn_url');

            $orderInfo = "Thanh toán đơn hàng qua MoMo";
            $amount = $totalAfterDiscount;
            $orderId = time() . "";
            $extraData = '';
            $requestId = time() . "";
            $requestType = "captureWallet";

            $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData .
                "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
                "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl .
                "&requestId=" . $requestId . "&requestType=" . $requestType;

            $signature = hash_hmac("sha256", $rawHash, $secretKey);

            $data = [
                'partnerCode' => $partnerCode,
                'partnerName' => "MoMo Payment",
                'storeId' => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature
            ];

            $ch = curl_init($endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $result = curl_exec($ch);
            $result = json_decode($result, true);

            if (isset($result['payUrl'])) {
                return redirect($result['payUrl']);
            } else {
                return back()->with('error', 'Không kết nối được tới cổng thanh toán MoMo.');
            }
        }

        // Xử lý nếu không phải thanh toán qua MoMo
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

        if ($couponCode = session('coupon')['code'] ?? null) {
            $coupon = Coupon::where('code', $couponCode)->first();
            if ($coupon) {
                $coupon->increment('usage_count');
            }
        }

        session()->forget('cart');
        session()->forget('coupon');

        return redirect()->route('home')->with('success', 'Đặt hàng thành công!');
    } catch (\Exception $e) {
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

    $order = Order::findOrFail($id);

    if ($order->order_status !== 'cancel_requested') {
        return redirect()->route('admin.orders.index')->with('error', 'Đơn hàng không yêu cầu hủy hoặc đã hủy trước đó.');
    }


    $order->order_status = 'cancelled';
    $order->save();

    return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được xác nhận hủy.');
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