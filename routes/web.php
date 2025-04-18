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
use App\Http\Controllers\Client\ProductDetailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\Admin\CouponController;
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/', [HomeController::class, 'index1']);
    Route::get('/homeadmin', [HomeController::class, 'index1'])->name('homeadmin');
});

Route::get('/home', [ProductController::class, 'index'])->name('home');



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


//danh mục sản phẩm
Route::get('list-categories', [App\Http\Controllers\CategoriesController::class, 'index'])->name('index');
Route::get('add-categories', [App\Http\Controllers\CategoriesController::class, 'create'])->name('create');
Route::post('admin-add-categories', [App\Http\Controllers\CategoriesController::class, 'store'])->name('store');
Route::delete('admin-delete-categories/{id}', [App\Http\Controllers\CategoriesController::class, 'destroy'])->name('destroy');
Route::get('admin-edit-categories/{id}', [App\Http\Controllers\CategoriesController::class, 'edit'])->name('edit');
Route::put('admin-update-categories/{id}', [App\Http\Controllers\CategoriesController::class, 'update'])->name('update');
Route::get('trash-categories', [App\Http\Controllers\CategoriesController::class, 'trash'])->name('trash');
Route::get('admin-reset-categories/{id}', [App\Http\Controllers\CategoriesController::class, 'reset'])->name('reset');
Route::delete('admin-forceDel-categories/{id}', [App\Http\Controllers\CategoriesController::class, 'forceDelete'])->name('forceDelete');


// Chi tiết sản phẩm 
Route::get('client-detail/{id}', [App\Http\Controllers\CuaHangController::class, 'index'])->name('detail.index');


// Thuộc tính sản phẩm 
Route::get('/attributes', [AttributeController::class, 'index'])->name('attributes');
Route::group(['prefix' => 'admin'], function () {
    Route::resource('attributes', AttributeController::class);
});


//  Quản lý người dùng 
Route::get('admin/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
Route::get('admin/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
Route::post('admin/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
Route::get('admin/users/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
Route::put('admin/users/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
Route::delete('admin/users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
//giỏ hàng
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');



// sản phẩm
Route::get('/products', [ProductController::class, 'index1'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');


// biến thể ?
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('products/{product}/variants', [ProductController::class, 'showVariants'])->name('products.variants.index');
  
}); 
 Route::post('products/{product}/variants', [ProductController::class, 'storeVariants'])->name('products.variants.store');
 Route::get('/products/{product}/addVariants', [ProductController::class, 'Variants'])->name('Variants');



// đặt hàng
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [OrderController::class, 'create'])->name('checkout.form');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
});

// quản lý reviews
Route::get('list-reviews',[ReviewController::class,'index'])
->name('reviews.index');
// ẩn reviews
Route::get('reviews-presently/{id}',[ReviewController::class,'presently'])
->name('reviews.presently');

// load reviews
Route::get('load-reviews/{id}',[ReviewController::class,'loadReview'])
->name('reviews.loadReview');


// Quản lý đơn hàng
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
Route::delete('/admin/orders/{order}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');
Route::put('/admin/orders/{id}/cancel-approve', [OrderController::class, 'approveCancel'])->name('admin.orders.cancel.approve');
Route::put('/admin/orders/{id}/cancel-reject', [OrderController::class, 'rejectCancel'])->name('admin.orders.cancel.reject');
Route::post('/orders/{id}/confirm-cancel', [OrderController::class, 'confirmCancel'])->name('admin.orders.confirmCancel');
Route::post('/admin/orders/{order}/reject-cancel', [OrderController::class, 'rejectCancel'])->name('admin.orders.rejectCancel');
Route::post('/orders/{id}/mark-delivered', [OrderController::class, 'markAsDelivered'])->name('orders.markDelivered');
});

// theo dõi đơn hàng
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [UserOrderController::class, 'index'])->name('user.orders.index');
    Route::get('/orders/{id}', [UserOrderController::class, 'show'])->name('user.orders.show');
    Route::put('/orders/{order}/cancel', [UserOrderController::class, 'cancel'])->name('user.orders.cancel');
    Route::put('/user/orders/{id}/cancel-request', [UserOrderController::class, 'requestCancel'])->name('user.orders.cancel');

});
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::put('/orders/{id}/cancel', [OrderController::class, 'requestCancel'])->name('orders.cancel');
});
// confirm đơn hàng
Route::put('/user/orders/{order}/confirm', [UserOrderController::class, 'confirm'])->name('user.orders.confirm');



//route mã giảm giá
Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('coupons', [CouponController::class, 'index'])->name('coupons.index');

    // Hiển thị form tạo mới mã giảm giá
    Route::get('coupons/create', [CouponController::class, 'create'])->name('coupons.create');

    // Lưu mã giảm giá mới
    Route::post('coupons', [CouponController::class, 'store'])->name('coupons.store');

    // Hiển thị form chỉnh sửa mã giảm giá
    Route::get('coupons/{coupon}/edit', [CouponController::class, 'edit'])->name('coupons.edit');

    // Cập nhật mã giảm giá
    Route::put('coupons/{coupon}', [CouponController::class, 'update'])->name('coupons.update');

    // Xóa mã giảm giá
    Route::delete('coupons/{coupon}', [CouponController::class, 'destroy'])->name('coupons.destroy');
});












