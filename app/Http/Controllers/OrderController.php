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
        return view('client.oder', compact('shippingMethods', 'paymentMethods', 'cart', 'total', 'userName'));
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
    
    
    
    
    
}
