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
use App\Models\OrderDetail;
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
        // Lấy sản phẩm + attributes + categories + paginate 10 sp/trang
        $products = Product::with(['attributes', 'categories'])
            ->paginate(10);
    
        // Tính tổng số lượng tồn kho cho mỗi sản phẩm
        $products->getCollection()->each(function ($product) {
            $totalQuantity = 0;
            
            // Lấy tất cả các biến thể của sản phẩm này và tính tổng số lượng
            $variants = $product->variants;  // Giả sử sản phẩm có quan hệ `variants`
            
            foreach ($variants as $variant) {
                $totalQuantity += $variant->quantity_variant;  // Cộng dồn số lượng biến thể
            }
            
            // Cập nhật số lượng tổng cho sản phẩm
            $product->quantity = $totalQuantity;
        });
    
        // Lấy danh sách attributes + attributeValues để tạo biến thể
        $attributes = Attribute::with('attributeValue')->get();
    
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
             'brand_id' => 'required|exists:brands,id',
             'categories' => 'required|array',
         ]);
     
         if ($request->sell_price > 0 && $request->price >= $request->sell_price) {
            return back()
                ->withErrors(['price' => 'Giá sale phải nhỏ hơn giá gốc.'])
                ->withInput();
        }
        
         $thumbnailPath = null;
         if ($request->hasFile('thumbnail')) {
             $thumbnailPath = $request->file('thumbnail')->store('products', 'public');
         }
     
         // Tạo slug duy nhất
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
             'quantity' => 0, // sẽ tính sau khi có biến thể
             'brand_id' => $request->brand_id,
         ]);
     
         $product->categories()->attach($request->categories);
     
         return redirect()->route('Variants', $product->id)
                          ->with('success', 'Tạo sản phẩm thành công! Hãy thêm biến thể.');
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
     
         // Không cho cập nhật nếu sản phẩm có trong đơn hàng
         if ($product->orderDetails()->exists()) {
             return redirect()->back()->with('error', 'Không thể cập nhật sản phẩm vì đã có trong đơn hàng.');
         }
     
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
        // Lấy sản phẩm với các biến thể và các giá trị thuộc tính đi kèm
        $product = Product::with('variants.attributeValues', 'brand')->findOrFail($id);
        
        // Lấy danh sách các biến thể của sản phẩm và phân trang
        $variants = $product->variants()
                            ->with('attributeValues.attribute') // Lấy các giá trị thuộc tính
                            ->paginate(10); // Phân trang 10 biến thể mỗi trang
        
        // Lấy tất cả thuộc tính và giá trị của các thuộc tính
        $attributes = Attribute::with('attributeValue')->get();
    
        // Trả về view với dữ liệu cần thiết
        return view('admin.products.Variants', compact('product', 'attributes', 'variants'));
    }
    // app/Http/Controllers/VariantController.php

public function destroyVariant($id)
{
    // Tìm biến thể theo ID
    $variant = Variant::findOrFail($id);
    
    // Xóa biến thể
    $variant->delete();

    // Quay lại trang trước với thông báo thành công
    return redirect()->back()->with('success', 'Biến thể đã được xóa thành công!');
}

    
public function destroy($id)
{
    // Tìm sản phẩm theo ID
    $product = Product::findOrFail($id);

    // Kiểm tra xem sản phẩm có tồn tại trong các đơn hàng có trạng thái 'pending' không
    $orderDetail = OrderDetail::where('product_id', $id)
                               ->whereHas('order', function($query) {
                                   $query->where('order_status', 'pending'); // Kiểm tra trạng thái 'pending'
                               })
                               ->first();

    // Nếu sản phẩm đã có trong đơn hàng có trạng thái 'pending', không cho phép xóa
    if ($orderDetail) {
        return redirect()->route('products.index')
                         ->with('error', 'Không thể xóa sản phẩm này vì nó đã có trong đơn hàng đang chờ xử lý.');
    }

    // Xóa sản phẩm
    try {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được xóa thành công!');
    } catch (\Exception $e) {
        return redirect()->route('products.index')->with('error', 'Xóa sản phẩm không thành công do sản phẩm đã được bày bán');
    }
}


    
















    //biến thể ----------------------------------------------------
    
    public function createVariants($id)
{
    $product = Product::findOrFail($id);
    $attributes = Attribute::with('attributeValue')->get();

    $combinations = $this->generateCombinationsForView($attributes);

    return view('products.variants.create', compact('product', 'combinations'));
}



public function storeVariants(Request $request, $id)
{
    $product = Product::with('variants.attributeValues')->findOrFail($id);

    $attributes = $request->input('attributes', []);
    $inputValueIds = collect($attributes)->values()->sort()->values()->toArray();

    foreach ($product->variants as $variant) {
        $existingValueIds = $variant->attributeValues->pluck('id')->sort()->values()->toArray();
        if ($existingValueIds == $inputValueIds) {
            return back()->with('error','Biến thể với tổ hợp thuộc tính này đã tồn tại.');
        }
    }

    // Validate
    $request->validate([
        'quantity_variant' => 'required|integer|min:0',
        'image_variant' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // validate ảnh
    ]);

    $sku = Str::uuid();

    $imagePath = null;
    if ($request->hasFile('image_variant')) {
        $imagePath = $request->file('image_variant')->store('variants', 'public'); // lưu vào storage/app/public/variants
    }

    $variant = new Variant();
    $variant->product_id = $product->id;
    $variant->sku = $sku;
    $variant->quantity_variant = $request->input('quantity_variant');
    $variant->image_variant = $imagePath; // gán path ảnh đã upload
    $variant->save();

    // Gắn thuộc tính cho biến thể
    foreach ($attributes as $attributeId => $valueId) {
        $variant->attributeValues()->attach($valueId);
    }

    // Cập nhật lại số lượng tổng cho sản phẩm
    $product->quantity = $product->variants()->sum('quantity_variant');
    $product->save();

    return back()->with('success', 'Tạo biến thể thành công!');
}






    public function showVariants($id)
{
    $product = Product::findOrFail($id);
    return view('products.variants.index', compact('product'));
}





}
