<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
class PaymentController extends Controller{
    public function momoCallback(Request $request)
{
    // Lấy các tham số từ MoMo callback
    $partnerCode = $request->partnerCode;
    $orderId = $request->orderId;
    $requestId = $request->requestId;
    $amount = $request->amount;
    $transId = $request->transId;
    $errorCode = $request->errorCode;
    $signature = $request->signature;

    // Lấy thông tin đơn hàng từ DB (dựa trên orderId)
    $order = Order::where('order_id', $orderId)->first();

    if (!$order) {
        return response()->json(['error' => 'Order not found']);
    }

    // Kiểm tra chữ ký (signature) để đảm bảo tính hợp lệ
    $accessKey = config('services.momo.access_key');
    $secretKey = config('services.momo.secret_key');
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&errorCode=" . $errorCode . "&orderId=" . $orderId . "&partnerCode=" . $partnerCode . "&requestId=" . $requestId . "&transId=" . $transId;
    $expectedSignature = hash_hmac("sha256", $rawHash, $secretKey);

    if ($signature != $expectedSignature) {
        return response()->json(['error' => 'Invalid signature']);
    }

    // Kiểm tra kết quả thanh toán
    if ($errorCode == 0) {
        // Thanh toán thành công
        $order->update([
            'order_status' => 'paid',
            'payment_transaction_id' => $transId,
        ]);
        return response()->json(['message' => 'Payment success']);
    } else {
        // Thanh toán thất bại
        $order->update(['order_status' => 'failed']);
        return response()->json(['message' => 'Payment failed']);
    }
}
}
