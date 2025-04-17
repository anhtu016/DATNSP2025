<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Log;



class OrderController extends Controller
{
    
        public function index()
        {
            $orders = Order::with('customer')->latest()->paginate(10);
            return view('admin.orders.index', compact('orders'));
        }
    
// Trong OrderController.php
public function show($orderId)
{
    // Eager load mối quan hệ 'orderDetail.variant.attributes' để tối ưu số lượng truy vấn
    $order = Order::with('orderDetail.variant.attributeValues.attribute')->find($orderId);


    // Kiểm tra xem đơn hàng có tồn tại không
    if (!$order) {
        abort(404, 'Đơn hàng không tồn tại');
    }

    // Trả dữ liệu về view
    return view('admin.orders.show', compact('order'));
}

    
        public function updateStatus(Request $request, Order $order)
        {
            $request->validate([
                'order_status' => 'required|string'
            ]);
    
            $order->order_status = $request->order_status;
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
        ->where('customer_id', auth()->id()) // đảm bảo người dùng chỉ được hủy đơn của mình
        ->where('order_status', 'pending') // chỉ cho hủy khi chưa xử lý
        ->firstOrFail();

    $order->order_status = 'cancel_requested';
    $order->save();

    return redirect()->route('user.orders.show', $order->id)
        ->with('success', 'Yêu cầu hủy đơn hàng đã được gửi. Vui lòng chờ xác nhận từ quản trị viên.');
}

    // tạo đơn hàng
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
    
        // 👇 Thêm cart, total và userName vào đây
        return view('client.order', compact('shippingMethods', 'paymentMethods', 'cart', 'total', 'userName'));
    }
    
    

    public function store(Request $request)
    {
        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);
        $total = 0;
    
        // Kiểm tra và tính tổng số tiền trong giỏ hàng
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    
        // Lấy ID người dùng
        $customerId = Auth::id();
    
        // Tạo đơn hàng mới
        try {
            $order = Order::create([
                'total_amount' => $total,
                'shipping_address' => $request->shipping_address,
                'order_date' => now(), // Hoặc lấy từ $request nếu có
                'shipping_method_id' => $request->shipping_method_id,
                'payment_methods_id' => $request->payment_methods_id,
                'phone_number' => $request->phone_number,
                'customer_id' => $customerId,
                'order_status' => 'pending', // Trạng thái đơn hàng
            ]);
    
            // Lưu chi tiết đơn hàng vào bảng order_details
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
            
            
            
    
            // Xóa giỏ hàng sau khi đặt hàng thành công
            session()->forget('cart');
    
        } catch (\Exception $e) {
            return back()->with('error', 'Đặt hàng thất bại: ' . $e->getMessage());
        }
    
        return redirect()->route('home')->with('success', 'Đặt hàng thành công!');
    }
    // xóa đơn hàng
    public function destroy($id)
{
    $order = Order::findOrFail($id);

    // Optional: Kiểm tra trạng thái trước khi xoá
    if (in_array($order->order_status, ['pending', 'cancelled'])) {
        $order->delete();
        return redirect()->back()->with('success', 'Đã xoá đơn hàng thành công.');
    }

    return redirect()->back()->with('error', 'Chỉ được xoá đơn hàng chưa xử lý hoặc đã hủy.');
}

    

public function confirmCancel($id)
{
    // Tìm đơn hàng yêu cầu hủy
    $order = Order::findOrFail($id);

    if ($order->order_status !== 'cancel_requested') {
        return redirect()->route('admin.orders.index')->with('error', 'Đơn hàng không yêu cầu hủy hoặc đã hủy trước đó.');
    }

    // Cập nhật trạng thái đơn hàng thành hủy
    $order->order_status = 'cancelled';
    $order->save();

    return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được xác nhận hủy.');
}

    
    
}
