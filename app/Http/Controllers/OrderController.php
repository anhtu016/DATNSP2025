<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
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


    public function create()
    {
        $cart = session()->get('cart', []);
        $total = 0;
    
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
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
    
        $user = Auth::user();
        $userName = $user ? $user->name : 'Khách';
    
        
        return view('client.order', compact('shippingMethods', 'paymentMethods', 'cart', 'total', 'userName'));
    }
    
    

    public function store(Request $request)
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
                ->with('error', 'Sản phẩm "' . $product->name . '" không đủ số lượng trong kho. Bạn vui lòng đặt lại số lượng sản phẩm !');
            
            }
    
            $total += $item['price'] * $item['quantity'];
        }
    
        $customerId = Auth::id();
    
        try {
            $order = Order::create([
                'total_amount' => $total,
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

    public function destroy($id)
{
    $order = Order::findOrFail($id);
    if (in_array($order->order_status, ['pending', 'cancelled'])) {
    $order = Order::find($id);
    $order->orderDetails()->delete();
    $order->delete();

        return redirect()->back()->with('success', 'Đã xoá đơn hàng thành công.');
    }

    return redirect()->back()->with('error', 'Chỉ được xoá đơn hàng chưa xử lý hoặc đã hủy.');
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
}

