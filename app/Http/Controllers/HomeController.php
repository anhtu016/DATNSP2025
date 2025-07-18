<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Coupon;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $categories = Category::with([
            'products' => function ($query) {
                $query->with('productReview', 'brand'); // Nếu cần lấy thêm các quan hệ của sản phẩm
            }
        ])->get();

        return view('client.index', compact('user', 'data', 'categories', 'latestProducts'));
    }
    public function index1()
    {
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
        $categories = Category::with([
            'products' => function ($query) {
                $query->with('productReview', 'brand');
            }
        ])->get();

        // Lấy thương hiệu (brand)
        $brands = Brand::all();


        $sizeAttribute = Attribute::where('name', 'Size')->first();

        $sizes = $sizeAttribute
            ? $sizeAttribute->attributeValue()->pluck('value')
            : collect();

        return view('client.productlist', compact(
            'user',
            'data',
            'categories',
            'latestProducts',
            'brands',
            'sizes'
        ));
    }
    public function filter(Request $request)
    {
        $query = Product::with('productReview', 'brand', 'categories'); // load luôn categories

        if ($request->filled('brands')) {
            $query->whereIn('brand_id', $request->brands);
        }

        if ($request->filled('categories')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->whereIn('categories.id', $request->categories);
            });
        }
        if ($request->filled('price_from') || $request->filled('price_to')) {
            $query->whereHas('variants', function ($q) use ($request) {
                if ($request->filled('price_from')) {
                    $q->where('price', '>=', $request->price_from);
                }
                if ($request->filled('price_to')) {
                    $q->where('price', '<=', $request->price_to);
                }
            });
        }
        // if ($request->filled('sizes')) {
        //     $sizeAttribute = Attribute::where('name', 'Size')->first();

        //     if ($sizeAttribute) {
        //         $query->whereHas('variants.attributeValues', function ($q) use ($request, $sizeAttribute) {
        //             $q->where('attribute_id', $sizeAttribute->id)
        //                 ->whereIn('value', $request->sizes);
        //         });

        //     }
        // }
        // if ($request->filled('sizes')) {
        //     $sizeAttribute = Attribute::where('name', 'Size')->first();

        //     if ($sizeAttribute) {
        //         $variantIds = DB::table('variant_attribute_value')
        //             ->join('attribute_values', 'variant_attribute_value.attribute_value_id', '=', 'attribute_values.id')
        //             ->where('attribute_values.attribute_id', $sizeAttribute->id)
        //             ->whereIn('attribute_values.value', $request->sizes)
        //             ->pluck('variant_attribute_value.variant_id');

        //         $productIds = DB::table('variants')
        //             ->whereIn('id', $variantIds)
        //             ->distinct()
        //             ->pluck('product_id');

        //         $query->whereIn('id', $productIds);
        //         if ($productIds->isNotEmpty()) {
        //             $query->whereIn('id', $productIds);
        //         } else {
        //             // Nếu không có sản phẩm nào match, đảm bảo không trả về gì cả
        //             $query->whereRaw('0 = 1');
        //         }
        //     }
        // }

        $products = $query->paginate(20);

        // Lấy các dữ liệu để filter
        $brands = Brand::all();
        $categories = Category::all();

        $sizeAttribute = Attribute::where('name', 'Size')->first();
        $sizes = $sizeAttribute
            ? $sizeAttribute->attributeValue()->pluck('value')
            : collect();


        $user = Auth::user();

        return view('client.productlist', compact('user', 'products', 'brands', 'categories', 'sizes'));
    }

// public function filter(Request $request)
// {
//     $query = Product::with('productReview', 'brand', 'categories');

//     $this->applyBrandFilter($query, $request);
//     $this->applyCategoryFilter($query, $request);
//     $this->applyPriceFilter($query, $request);
//     $this->applySizeFilter($query, $request);

//     $products = $query->paginate(20);

//     $brands = Brand::all();
//     $categories = Category::all();

//     $sizeAttribute = Attribute::where('name', 'Size')->first();
//     $sizes = $sizeAttribute
//         ? $sizeAttribute->attributeValue()->pluck('value')
//         : collect();

//     $user = Auth::user();

//     return view('client.productlist', compact('user', 'products', 'brands', 'categories', 'sizes'));
// }

// private function applyBrandFilter(&$query, $request)
// {
//     if ($request->filled('brands')) {
//         $query->whereIn('brand_id', $request->brands);
//     }
// }

// private function applyCategoryFilter(&$query, $request)
// {
//     if ($request->filled('categories')) {
//         $query->whereHas('categories', function ($q) use ($request) {
//             $q->whereIn('categories.id', $request->categories);
//         });
//     }
// }

// private function applyPriceFilter(&$query, $request)
// {
//     if ($request->filled('price_from') || $request->filled('price_to')) {
//         $query->whereHas('variants', function ($q) use ($request) {
//             if ($request->filled('price_from')) {
//                 $q->where('price', '>=', $request->price_from);
//             }
//             if ($request->filled('price_to')) {
//                 $q->where('price', '<=', $request->price_to);
//             }
//         });
//     }
// }

// private function applySizeFilter(&$query, $request)
// {
//     if ($request->filled('sizes')) {
//         $sizeAttribute = Attribute::where('name', 'Size')->first();

//         if ($sizeAttribute) {
//             $variantIds = DB::table('variant_attribute_value')
//                 ->join('attribute_values', 'variant_attribute_value.attribute_value_id', '=', 'attribute_values.id')
//                 ->where('attribute_values.attribute_id', $sizeAttribute->id)
//                 ->whereIn('attribute_values.value', $request->sizes)
//                 ->pluck('variant_attribute_value.variant_id');

//             $productIds = DB::table('variants')
//                 ->whereIn('id', $variantIds)
//                 ->distinct()
//                 ->pluck('product_id');

//             if ($productIds->isNotEmpty()) {
//                 $query->whereIn('id', $productIds);
//             } else {
//                 $query->whereRaw('0 = 1');
//             }
//         }
//     }
// }

}

