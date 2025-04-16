<?php

use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use League\CommonMark\Extension\Attributes\Node\Attributes;
use App\Http\Controllers\UserController;

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

use App\Http\Controllers\Client\ProductDetailController;
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
->name('categories.index');
//add
Route::get('add-categories',[App\Http\Controllers\CategoriesController::class,'create'])
->name('categories.create');

Route::post('admin-add-categories',[App\Http\Controllers\CategoriesController::class,'store'])
->name('categories.store');

Route::delete('admin-delete-categories/{id}',[App\Http\Controllers\CategoriesController::class,'destroy'])
->name('categories.destroy');

Route::get('admin-edit-categories/{id}',[App\Http\Controllers\CategoriesController::class,'edit'])
->name('categories.edit');

Route::put('admin-update-categories/{id}',[App\Http\Controllers\CategoriesController::class,'update'])
->name('categories.update');

Route::get('trash-categories',[App\Http\Controllers\CategoriesController::class,'trash'])
->name('categories.trash');

Route::get('admin-reset-categories/{id}',[App\Http\Controllers\CategoriesController::class,'reset'])
->name('categories.reset');        

Route::delete('admin-forceDel-categories/{id}',[App\Http\Controllers\CategoriesController::class,'forceDelete'])
->name('categories.forceDelete');

// chi tiết sản phẩm 
Route::get('client-detail/{id}',[App\Http\Controllers\Client\ProductDetailController::class,'index'])
->name('detail.index');

// quản lý reviews
Route::get('list-reviews',[ReviewController::class,'index'])
->name('reviews.index');
// ẩn reviews
Route::get('reviews-presently/{id}',[ReviewController::class,'presently'])
->name('reviews.presently');

// load reviews
Route::get('load-reviews/{id}',[ReviewController::class,'loadReview'])
->name('reviews.loadReview');



// routes/web.php
Route::get('/', [ProductController::class, 'index']);
// routes/web.php
Route::get('/attributes', [AttributeController::class, 'index'])->name('attributes');
Route::get('/', [HomeController::class, 'index1']);
Route::get('/home', [ProductController::class, 'index'])->name('home');
Route::get('/homeadmin', [HomeController::class, 'index1'])->name('homeadmin');


// ==== Auth: Đăng nhập / Đăng ký / Đăng xuất ====
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// ==== Quên mật khẩu / Đặt lại mật khẩu ====
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');


// ==== Category ====
Route::get('list-categories', [App\Http\Controllers\CategoriesController::class, 'index'])->name('index');
Route::get('add-categories', [App\Http\Controllers\CategoriesController::class, 'create'])->name('create');
Route::post('admin-add-categories', [App\Http\Controllers\CategoriesController::class, 'store'])->name('store');
Route::delete('admin-delete-categories/{id}', [App\Http\Controllers\CategoriesController::class, 'destroy'])->name('destroy');
Route::get('admin-edit-categories/{id}', [App\Http\Controllers\CategoriesController::class, 'edit'])->name('edit');
Route::put('admin-update-categories/{id}', [App\Http\Controllers\CategoriesController::class, 'update'])->name('update');
Route::get('trash-categories', [App\Http\Controllers\CategoriesController::class, 'trash'])->name('trash');
Route::get('admin-reset-categories/{id}', [App\Http\Controllers\CategoriesController::class, 'reset'])->name('reset');
Route::delete('admin-forceDel-categories/{id}', [App\Http\Controllers\CategoriesController::class, 'forceDelete'])->name('forceDelete');


// ==== Sản phẩm - Chi tiết sản phẩm ====
Route::get('client-detail/{id}', [App\Http\Controllers\CuaHangController::class, 'index'])->name('detail.index');


// ==== Thuộc tính sản phẩm (attributes) ====
Route::get('/attributes', [AttributeController::class, 'index'])->name('attributes');
Route::group(['prefix' => 'admin'], function () {
    Route::resource('attributes', AttributeController::class);
});


// ==== Quản lý người dùng (admin/users) ====
Route::get('admin/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
Route::get('admin/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
Route::post('admin/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
Route::get('admin/users/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
Route::put('admin/users/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
Route::delete('admin/users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
//giở hàng
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');

// thêm sản phẩm vào giỏ hàng

Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
//xóa sản phẩm khỏi giỏ hàng
Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
//cập nhật số lượng sản phẩm trong rỏ hàng
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');




// hiển thị danh sách sản phẩm
Route::get('/products', [ProductController::class, 'index1'])->name('products.index');
// Hiển thị trang tạo sản phẩm
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
// Xử lý việc tạo sản phẩm
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
//cập nhật sản phẩm 
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
//xử lý put
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

//xóa sản phẩm
Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');


// biến thể ?
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Route để tạo mới biến thể cho sản phẩm
    Route::get('products/{product}/variants', [ProductController::class, 'showVariants'])->name('products.variants.index');
  
}); 
 Route::post('products/{product}/variants', [ProductController::class, 'storeVariants'])->name('products.variants.store');
 Route::get('/products/{product}/addVariants', [ProductController::class, 'Variants'])->name('Variants');



// đặt hàng


// routes/web.php
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [OrderController::class, 'create'])->name('checkout.form');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
});







