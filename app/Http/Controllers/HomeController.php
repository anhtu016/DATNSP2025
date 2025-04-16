<?php

namespace App\Http\Controllers;
 use App\Models\Product;
 use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
   

    public function index()
    {
        $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập
        $data = Product::with('productReview','brand')->get();
        return view('client.index', compact('user','data')); // Truyền dữ liệu sang view
        
    }
    public function index1(){
        return view('admin.index');
    }
}

