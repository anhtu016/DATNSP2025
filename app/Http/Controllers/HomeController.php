<?php

namespace App\Http\Controllers;
 use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
   

    public function index()
    {
        $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập
        return view('client.index', compact('user')); // Truyền dữ liệu sang view
        
    }
}

