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
Route::get('/', function () {
        return view('client.index');
    });
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
=======
// Route::get('/',[CategoryController::class,'index']);
Route::get('/', function(){return view('admin.index');});
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

Route::get('trash-categories',[App\Http\Controllers\CategoriesController::class,'trash'])
->name('trash');

Route::get('admin-reset-categories/{id}',[App\Http\Controllers\CategoriesController::class,'reset'])
->name('reset');

Route::delete('admin-forceDel-categories/{id}',[App\Http\Controllers\CategoriesController::class,'forceDelete'])
->name('forceDelete');

// routes/web.php

Route::get('/', [ProductController::class, 'index']);
Route::group(['prefix' => 'admin'], function () {
    Route::resource('attributes', AttributeController::class);
});
