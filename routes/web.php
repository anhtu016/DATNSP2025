<?php

use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductController;

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



// routes/web.php

Route::get('/', [ProductController::class, 'index']);
Route::group(['prefix' => 'admin'], function () {
        Route::resource('attributes', AttributeController::class);
});
