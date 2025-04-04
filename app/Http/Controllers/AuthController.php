<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;   
 use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('client.login'); // Hiển thị trang đăng nhập
    }
    // đăng nhập
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
        }
    
        return back()->withErrors(['email' => 'Sai tài khoản hoặc mật khẩu'])->withInput();
    }
    
    public function showRegister()
    {
        return view('client.register');
    }

    // Xử lý đăng ký


    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:6',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
    
        User::create([
            'name'=> $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Mã hóa mật khẩu
        ]);
    
        return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }
    
    // đăng xuất
    public function logout(Request $request)
    {
        Auth::logout(); // Xóa session đăng nhập
    
        $request->session()->invalidate(); // Xóa toàn bộ session
        $request->session()->regenerateToken(); // Tạo CSRF token mới
    
        return redirect()->route('login')->with('success', 'Bạn đã đăng xuất thành công!');
    }
}
