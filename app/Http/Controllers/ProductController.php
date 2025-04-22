<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\Variant;
use App\Models\ProductAttribute;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::with('productReview','brand')->get();
        return view('client.index',compact('data'));
    }
    // danh sách sản phẩm
    public function index1()
    {
        // Lấy tất cả sản phẩm cùng với các biến thể của chúng
        $products = Product::with('attributes')->get();
    
        $products = Product::with('categories')->get();

        // Lấy danh sách attributes + attributeValues để tạo biến thể
        $attributes = Attribute::with('attributeValue')->get();

        // Tạo các kết hợp từ các giá trị thuộc tính
        $combinations = $this->generateCombinations($attributes);
    
        return view('admin.products.index', compact('products', 'attributes'));
    }
     // Hiển thị trang tạo sản phẩm
     public function create()
     {
         $attributes = Attribute::with('attributeValue')->get();
         $brands = Brand::all();
         $categories = Category::all();
         return view('admin.products.create', compact('attributes', 'brands', 'categories'));
     }
     
     public function store(Request $request)
     {
         $request->validate([
             'name' => 'required|string|max:200',
             'sku' => 'required|string|max:150|unique:products',
             'price' => 'required|numeric|min:0',
             'sell_price' => 'required|nullable|numeric|min:0',
             'short_description' => 'required|string',
             'description' => 'required|string',
             'thumbnail' => 'required|nullable|image|max:2048',
             'quantity' => 'required|integer|min:1',
             'brand_id' => 'required|exists:brands,id',
             'categories' => 'required|array',
         ]);
     
         $thumbnailPath = null;
         if ($request->hasFile('thumbnail')) {
             $thumbnailPath = $request->file('thumbnail')->store('products', 'public');
         }
     
         // Tạo slug và kiểm tra trùng lặp
         $slug = Str::slug($request->name);
         $originalSlug = $slug;
         $count = 1;

         while (Product::where('slug', $slug)->exists()) {
             $slug = $originalSlug . '-' . $count++;
         }
     
         $product = Product::create([
             'name' => $request->name,
             'slug' => $slug,
             'sku' => $request->sku,
             'price' => $request->price,
             'sell_price' => $request->sell_price ?? 0,
             'short_description' => $request->short_description,
             'description' => $request->description,
             'thumbnail' => $thumbnailPath,
             'quantity' => $request->quantity,
             'brand_id' => $request->brand_id,
         ]);
     
         $product->categories()->attach($request->categories);
     
         return redirect()->route('Variants', $product->id)->with('success', 'Tạo sản phẩm thành công!');
     }
     
     public function edit($id)
     {
         $product = Product::with('categories')->findOrFail($id);
         $categories = Category::all();
         return view('admin.products.edit', compact('product', 'categories'));
     }
     
     public function update(Request $request, $id)
     {
         $product = Product::findOrFail($id);
     
         $request->validate([
             'name' => 'required|string|max:200',
             'sku' => 'required|string|max:150|unique:products,sku,' . $product->id,
             'price' => 'required|numeric|min:0',
             'sell_price' => 'nullable|numeric|min:0',
             'short_description' => 'required|string',
             'description' => 'required|string',
             'thumbnail' => 'nullable|image|max:2048',
             'quantity' => 'required|integer|min:0',
             'brand_id' => 'required|exists:brands,id',
             'categories' => 'required|array',
         ]);
     
         if ($request->hasFile('thumbnail')) {
             $product->thumbnail = $request->file('thumbnail')->store('products', 'public');
         }
     
         // Cập nhật slug nếu tên thay đổi
         if ($product->name !== $request->name) {
             $slug = Str::slug($request->name);
             $originalSlug = $slug;
             $count = 1;
     
             while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                 $slug = $originalSlug . '-' . $count++;
             }
     
             $product->slug = $slug;
         }
     
         $product->update([
             'name' => $request->name,
             'sku' => $request->sku,
             'price' => $request->price,
             'sell_price' => $request->sell_price ?? 0,
             'short_description' => $request->short_description,
             'description' => $request->description,
             'quantity' => $request->quantity,
             'brand_id' => $request->brand_id,
         ]);
     
         $product->categories()->sync($request->categories);
     
         return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công.');
     }

  


    public function show($id)
    {
        
        $products = Product::with(['variants.attributeValues.attribute'])->get();

    
        return view('admin.products.index', compact('product'));
    }
    

    public function Variants($id)
{
    $product = Product::with('variants.attributeValues', 'brand')->findOrFail($id);
    $attributes = Attribute::with('attributeValue')->get(); // Lấy tất cả thuộc tính và giá trị

    return view('admin.products.Variants', compact('product', 'attributes'));
}
public function destroy($id)
{
    $product = Product::findOrFail($id); // Tìm sản phẩm theo ID
    
    // Xóa sản phẩm
    $product->delete();
    
    return redirect()->route('products.index')->with('success', 'Sản phẩm đã được xóa thành công!');
}

    
















    //biến thể ----------------------------------------------------
    
    public function createVariants($id)
{
    $product = Product::findOrFail($id);
    $attributes = Attribute::with('attributeValue')->get();

    $combinations = $this->generateCombinationsForView($attributes);

    return view('products.variants.create', compact('product', 'combinations'));
}

    public function showVariants($id)
{
    $product = Product::findOrFail($id);
    return view('products.variants.index', compact('product'));
}

public function storeVariants(Request $request, $id)
{
    $product = Product::findOrFail($id);

    // Nhận dữ liệu từ form gửi lên
    $attributes = $request->input('attributes', []);

    // Tạo SKU (hoặc bạn có thể logic tạo SKU theo ý muốn)
    $sku = Str::uuid();

    // Lưu biến thể vào bảng variants
    $variant = new Variant();
    $variant->product_id = $product->id;
    $variant->sku = $sku;
    $variant->save();

    // Gắn các giá trị thuộc tính cho biến thể này
    foreach ($attributes as $attributeId => $valueId) {
        $variant->attributeValues()->attach($valueId); // Gắn các attributeValue vào variant
    }

    return back()->with('success', 'Tạo biến thể thành công!');
}







// Hàm tạo các kết hợp (combinations) từ các giá trị thuộc tính
private function generateCombinations($attributes)
{
    $combinations = [[]]; // Khởi tạo mảng các kết hợp

    foreach ($attributes as $attribute) {
        $temp = [];
        foreach ($attribute->attributeValue as $value) {
            foreach ($combinations as $combination) {
                $temp[] = array_merge($combination, [$value->id]);
            }
        }
        $combinations = $temp;
    }

    return $combinations;
}


}
