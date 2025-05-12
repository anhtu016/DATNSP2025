<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderDetail;
use App\Models\Coupon;
use App\Models\Variant;
class PaypalController extends Controller
{



public function success(Request $request)
{
    $orderId = $request->query('token');
    if (!$orderId) {
        return redirect()->route('home')->with('error', 'Không tìm thấy mã đơn PayPal.');
    }

    $checkoutData = session('checkout_data');
    if (!$checkoutData || empty($checkoutData['cart'])) {
        return redirect()->route('home')->with('error', 'Không tìm thấy dữ liệu giỏ hàng.');
    }

    try {
        $client = PayPalClient::client();
        $captureRequest = new OrdersCaptureRequest($orderId);
        $captureRequest->prefer('return=representation');
        $response = $client->execute($captureRequest);

        // Kiểm tra trạng thái thanh toán
        if ($response->result->status !== 'COMPLETED') {
            return redirect()->route('home')->with('error', 'Thanh toán chưa được hoàn tất.');
        }

        DB::beginTransaction();

        $cart = $checkoutData['cart'];
        $order = Order::create([
            'total_amount' => $checkoutData['total_after_discount'],
            'shipping_address' => $checkoutData['shipping_address'],
            'order_date' => now(),
            'shipping_method_id' => $checkoutData['shipping_method_id'],
            'payment_methods_id' => $checkoutData['payment_methods_id'],
            'phone_number' => $checkoutData['phone_number'],
            'customer_id' => Auth::id(),
            'order_status' => 'pending',
            'coupon_code' => $checkoutData['coupon']['code'] ?? null,
            'discount_amount' => $checkoutData['coupon']['discount_amount'] ?? 0,
        ]);

        foreach ($cart as $item) {
            $variant = Variant::where('id', $item['variant_id'])->lockForUpdate()->first();

            if (!$variant || $variant->quantity_variant < $item['quantity']) {
                DB::rollBack();
                return redirect()->route('home')->with('error', 'Lỗi với sản phẩm: ' . $item['name']);
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

        // Tăng lượt dùng coupon nếu có
        if (!empty($checkoutData['coupon']['code'])) {
            Coupon::where('code', $checkoutData['coupon']['code'])->increment('usage_count');
        }

        DB::commit();

        // Dọn session
        session()->forget(['cart', 'coupon', 'checkout_data']);

        return redirect()->route('home')->with('success', 'Thanh toán và đặt hàng thành công!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('home')->with('error', 'Có lỗi xảy ra khi xử lý đơn hàng: ' . $e->getMessage());
    }
}


    public function cancel()
    {
        return redirect()->route('home')->with('error', 'Bạn đã hủy thanh toán qua PayPal.');
    }


}
?>