<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Models\Variant;
use App\Models\Attribute;

use Illuminate\Support\Facades\DB;

class CuaHangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        
        // Mảng ánh xạ màu
        $colorMap = [
            'Red' => '#FF0000',
            'Blue' => '#0000FF',
            'Green' => '#00FF00',
            'Black' => '#000000',
            'White' => '#FFFFFF',
            // Thêm màu khác nếu cần
        ];
    
        // Lấy sản phẩm và các thuộc tính của nó
        $product = Product::with('variants.attributeValues.attribute')->findOrFail($id);
        $attributes = [];
        $detailProduct = Product::find($id);
        $imageProduct = ProductImage::where('product_id', $id)->get();
        $loadReviews = ProductReview::with(['product', 'user'])->where('product_id', $id)->get();
    
        $isLowStock = $product->quantity <= 5;
    
        foreach ($product->variants as $variant) {
            foreach ($variant->attributeValues as $attrValue) {
                $attrName = $attrValue->attribute->name;
    
                // Ánh xạ màu sắc nếu thuộc tính là màu
                if ($attrName === 'color') {
                    $attrValue->colorHex = $colorMap[$attrValue->value] ?? '#FFFFFF';
                }
    
                // Gom nhóm thuộc tính
                if (!isset($attributes[$attrName])) {
                    $attributes[$attrName] = [];
                }
    
                if (!collect($attributes[$attrName])->contains('id', $attrValue->id)) {
                    $attributes[$attrName][] = $attrValue;
                }
            }
        }
    
        // Tính tổng tồn kho
        $totalQuantity = $product->variants->sum('quantity_variant');
        $product->quantity = $totalQuantity;
    
        // Tính tồn kho theo tổ hợp thuộc tính
        $variantStock = [];
        foreach ($product->variants as $variant) {
            $attributeOrder = array_keys($attributes); // ['color', 'size', ...]
            $values = [];
    
            foreach ($attributeOrder as $attrName) {
                $attr = Attribute::where('name', $attrName)->first();
                if ($attr) {
                    $value = $variant->attributeValues->firstWhere('attribute_id', $attr->id);
                    $values[] = $value ? $value->id : '';
                }
            }
    
            $key = implode('-', $values);
            $variantStock[$key] = $variant->quantity_variant;
        }
    
        // 🔥 Dữ liệu biến thể cho JavaScript: dùng để đổi ảnh theo màu
        $variantsData = $product->variants->map(function ($variant) use ($product) {
            return [
                'id' => $variant->id,
                'image' => $variant->image_variant 
                    ? asset('storage/' . $variant->image_variant)
                    : asset('storage/' . $product->thumbnail),
                'attributes' => $variant->attributeValues->pluck('id')->sort()->values()->toArray(),
                'quantity' => $variant->quantity_variant,
            ];
        });
        
        $loadReviews = ProductReview::with(['user', 'variant.attributeValues.attribute'])
    ->where('product_id', $product->id)
    ->where('status', 1)
    ->latest()
    ->paginate(5);  // 5 đánh giá mỗi trang

        return view('client.detail-product', compact(
            'product', 'attributes', 'detailProduct', 'imageProduct', 'loadReviews',
            'isLowStock', 'variantStock', 'variantsData'
        ));
    }
    
    
    public function getVariantStock(Request $request)
    {
        // Lấy các thuộc tính và giá trị đã chọn từ request
        $attributes = $request->input('attributes');
        
        // Kiểm tra nếu mảng attributes không rỗng
        if (empty($attributes)) {
            return response()->json(['stock' => 0]);
        }
    
        // Tạo điều kiện where cho các thuộc tính
        $query = Variant::query();
        foreach ($attributes as $attributeId => $valueId) {
            $query->whereHas('attributeValues', function ($query) use ($attributeId, $valueId) {
                $query->where('attribute_id', $attributeId)
                      ->where('attribute_value_id', $valueId);
            });
        }
    
        // Tìm biến thể sản phẩm dựa trên các thuộc tính đã chọn
        $variant = $query->first();
    
        // Kiểm tra số lượng tồn kho của biến thể
        if ($variant) {
            return response()->json([
                'stock' => $variant->quantity_variant,
            ]);
        }
    
        return response()->json([
            'stock' => 0,
        ]);
    }
    

    
}
