<?php

use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use League\CommonMark\Extension\Attributes\Node\Attributes;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', [ProductController::class, 'index']);
// Route::group(['prefix' => 'admin'], function () {
//         Route::resource('attributes', AttributeController::class);
// });
// Route::get('/', function () {
//         return view('client.index');
//     });
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    
    
    
    // đăng nhập , đăng xuất , đăng ký
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
    
    // xử lý quên mật khẩu 
    
    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    //xử lý đổi mật khẩu
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

// Route::get('/',[CategoryController::class,'index']);
Route::get('/homeadmin', [HomeController::class, 'index1'])->name('homeadmin');
// Route::get('abc',[CategoryController::class,'list_category']);

Route::get('list-categories',[App\Http\Controllers\CategoriesController::class,'index'])
->name('index');
//add
Route::get('add-categories',[App\Http\Controllers\CategoriesController::class,'create'])
->name('create');

Route::post('admin-add-categories',[App\Http\Controllers\CategoriesController::class,'store'])
->name('store');

Route::delete('admin-delete-categories/{id}',[App\Http\Controllers\CategoriesController::class,'destroy'])
->name('destroy');

Route::get('admin-edit-categories/{id}',[App\Http\Controllers\CategoriesController::class,'edit'])
->name('edit');

Route::put('admin-update-categories/{id}',[App\Http\Controllers\CategoriesController::class,'update'])
->name('update');



// routes/web.php
Route::get('/attributes', [AttributeController::class, 'index'])->name('attributes');
Route::get('/', [HomeController::class, 'index1']);
Route::group(['prefix' => 'admin'], function () {
        Route::resource('attributes', AttributeController::class);
});


// routes/web.php
// Route để hiển thị danh sách người dùng
Route::get('admin/users', [App\Http\Controllers\UserController::class, 'index'])
    ->name('users.index');

// Thêm người dùng mới
Route::get('admin/users/create', [App\Http\Controllers\UserController::class, 'create'])
    ->name('users.create');

// Lưu người dùng mới
Route::post('admin/users', [App\Http\Controllers\UserController::class, 'store'])
    ->name('users.store');

// Xóa người dùng
Route::delete('admin/users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])
    ->name('users.destroy');

// Route để hiển thị form chỉnh sửa người dùng (GET)
Route::get('admin/users/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');

// Route để cập nhật người dùng (PUT)
Route::put('admin/users/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');






