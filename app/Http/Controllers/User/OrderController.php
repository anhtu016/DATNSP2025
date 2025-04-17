<?php 
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('customer_id', Auth::id())
            ->orderByDesc('order_date')
            ->paginate(10);

        return view('client.orders.index', compact('orders'));
    }
    public function show($id)
{
    $order = Order::where('id', $id)
        ->where('customer_id', Auth::id())
        ->with(['orderDetails.product', 'paymentMethod', 'shippingMethod'])
        ->firstOrFail();

    return view('client.orders.show', compact('order'));
}


public function cancel(Order $order)
{
    // Đảm bảo chỉ user chính chủ mới hủy được đơn hàng của mình
    if ($order->customer_id !== auth()->id()) {
        abort(403, 'Bạn không có quyền hủy đơn hàng này.');
    }

    // Chỉ cho phép hủy khi đơn hàng đang ở trạng thái pending
    if ($order->order_status !== 'pending') {
        return back()->with('error', 'Không thể hủy đơn hàng đã được xử lý.');
    }

    $order->update([
        'order_status' => 'cancelled',
    ]);

    return back()->with('success', 'Đơn hàng đã được hủy thành công.');
}

public function confirm($id)
{
    $order = Order::findOrFail($id);

    if ($order->order_status === 'delivered' && !$order->is_confirmed) {
        $order->is_confirmed = true;
        $order->confirmed_at = now();
        $order->save();

        return redirect()->back()->with('success', 'Bạn đã xác nhận đơn hàng hoàn tất.');
    }

    return redirect()->back()->with('error', 'Không thể xác nhận đơn hàng này.');
}


}
