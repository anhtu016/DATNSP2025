<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
 use Illuminate\Support\Facades\Auth;
 use App\Models\Coupon;
 use App\Models\Category;
    use App\Models\Attribute;
    use Illuminate\Http\Request;
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
    public function index3()
{
    $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập

    // Tất cả sản phẩm
    $data = Product::with('productReview', 'brand')->get();

    // Sản phẩm mới nhất
    $latestProducts = Product::with('productReview', 'brand')
        ->orderBy('created_at', 'desc')
        ->take(4)
        ->get();

    // Lấy tất cả danh mục (có sản phẩm)
    $categories = Category::with(['products' => function($query) {
        $query->with('productReview', 'brand');
    }])->get();

    // Lấy thương hiệu (brand)
    $brands = Brand::all();


$sizeAttribute = Attribute::where('name', 'size')->first();

$sizes = $sizeAttribute
    ? $sizeAttribute->attributeValue()->pluck('value')
    : collect();

    return view('client.productlist', compact(
        'user', 'data', 'categories', 'latestProducts',
        'brands', 'sizes'
    ));
}
public function filter(Request $request)
{
    $query = Product::with('productReview', 'brand', 'categories'); // load luôn categories

    if ($request->filled('brands')) {
        $query->whereIn('brand_id', $request->brands);
    }

    if ($request->filled('categories')) {
        $query->whereHas('categories', function($q) use ($request) {
            $q->whereIn('categories.id', $request->categories);
        });
    }

    if ($request->filled('sizes')) {
        $query->whereHas('variants', function ($q) use ($request) {
            $q->whereIn('size', $request->sizes);
        });
    }

    if ($request->filled('price_from')) {
        $query->where('price', '>=', $request->price_from);
    }

    if ($request->filled('price_to')) {
        $query->where('price', '<=', $request->price_to);
    }

    $products = $query->paginate(20);

    // Lấy các dữ liệu để filter
    $brands = Brand::all();
    $categories = Category::all();

    $sizeAttribute = Attribute::where('name', 'size')->first();
    $sizes = $sizeAttribute
        ? $sizeAttribute->attributeValue()->pluck('value')
        : collect();


    $user = Auth::user();

    return view('client.productlist', compact('user', 'products', 'brands', 'categories', 'sizes'));
}



}

