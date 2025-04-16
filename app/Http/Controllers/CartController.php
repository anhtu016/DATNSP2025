<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\AttributeValue;
use App\Models\Variant;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{
    public function viewCart()
{
    $cart = session()->get('cart', []);
    return view('client.cart', compact('cart'));
}



public function addToCart(Request $request, $id)
{
    $product = Product::findOrFail($id);
    $attributes = $request->input('attributes', []);
    $quantity = $request->input('quantity', 1);

    $colorId = $attributes['Color'] ?? null;
    $sizeId = $attributes['Size'] ?? null;

    if (!$colorId || !$sizeId) {
        return redirect()->back()->with('error', 'Vui lòng chọn thuộc tính.');
    }

    $color = AttributeValue::find($colorId);
    $size = AttributeValue::find($sizeId);

    if (!$color || !$size) {
        return redirect()->back()->with('error', 'Thuộc tính không hợp lệ.');
    }

    // Kiểm tra biến thể sản phẩm
    $variant = Variant::where('product_id', $id)
        ->whereHas('attributeValues', function ($query) use ($colorId, $sizeId) {
            $query->whereIn('attribute_value_id', [$colorId, $sizeId]);
        }, '=', 2)
        ->first();

    // Gán variant_id nếu tìm thấy biến thể
    $cartItemId = $id . '-' . $colorId . '-' . $sizeId;
    $cart = session()->get('cart', []);

    if (isset($cart[$cartItemId])) {
        $cart[$cartItemId]['quantity'] += $quantity;
    } else {
        $cart[$cartItemId] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $quantity,
            'Color' => $color->value,
            'Size' => $size->value,
            'thumbnail' => $product->thumbnail ?? 'client/img/default.png',
            'variant_id' => $variant->id ?? null, // Thêm variant_id vào giỏ hàng
        ];
    }

    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng');
}






public function removeFromCart($id)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }

    return redirect()->route('cart.view')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
}
// cập nhật số lượng sản phẩm trong giỏ hàng
public function update(Request $request, $id)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $cart[$id]['quantity'] = $request->quantity;
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Cập nhật số lượng thành công!');
    }

    return redirect()->back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
}

}
