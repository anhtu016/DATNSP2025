<?php

namespace App\Http\Controllers;
 use App\Models\Product;
 use Illuminate\Support\Facades\Auth;
 use App\Models\Coupon;
 use App\Models\Category;
class HomeController extends Controller
{
   

    public function index()
    {
        $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập
    
        // Lấy tất cả sản phẩm (nếu bạn vẫn muốn show tổng thể ở đầu trang)
        $data = Product::with('productReview', 'brand')->get();
        
        $latestProducts = Product::with('productReview', 'brand')
        ->orderBy('created_at', 'desc')
        ->take(4)
        ->get();
        // Lấy tất cả danh mục và các sản phẩm của từng danh mục
        $categories = Category::with(['products' => function($query) {
            $query->with('productReview', 'brand'); // Nếu cần lấy thêm các quan hệ của sản phẩm
        }])->get();
    
        return view('client.index', compact('user', 'data', 'categories','latestProducts')); 
    }
    public function index1(){
        return view('admin.index');
    }
}

