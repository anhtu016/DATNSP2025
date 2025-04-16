<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
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
    
        // Duyệt qua tất cả các biến thể của sản phẩm
        foreach ($product->variants as $variant) {
            foreach ($variant->attributeValues as $attrValue) {
                $attrName = $attrValue->attribute->name;
    
                // Ánh xạ màu sắc nếu thuộc tính là màu sắc
                if ($attrName == 'color') {
                    $attrValue->colorHex = $colorMap[$attrValue->value] ?? '#FFFFFF';  // Gán màu sắc tương ứng, mặc định là trắng nếu không tìm thấy
                }
    
                // Đảm bảo không trùng lặp giá trị thuộc tính
                if (!isset($attributes[$attrName])) {
                    $attributes[$attrName] = [];
                }
    
                if (!collect($attributes[$attrName])->contains('id', $attrValue->id)) {
                    $attributes[$attrName][] = $attrValue;
                }
            }
        }
    
        // Trả về view với sản phẩm và các thuộc tính đã ánh xạ
        return view('client.detail-product', compact('product', 'attributes'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
