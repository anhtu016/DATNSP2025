<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
class PaypalController extends Controller
{



    public function success(Request $request)
    {
        $client = PayPalClient::client();
        $orderId = $request->query('token');
        $captureRequest = new OrdersCaptureRequest($orderId);
        $captureRequest->prefer('return=representation');
        $response = $client->execute($captureRequest);

        session()->forget('cart');
        session()->forget('coupon');

        return redirect()->route('home')->with('success', 'Thanh toán PayPal thành công!');
    }

    public function cancel()
    {
        return redirect()->route('home')->with('error', 'Bạn đã hủy thanh toán qua PayPal.');
    }


}
?>