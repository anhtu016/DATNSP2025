<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\AttributeValue;
use App\Models\Variant;
use App\Models\Coupon;
use Carbon\Carbon;
use App\Models\Order;
class CartController extends Controller
{

    public function viewCart()
    {
        $cart = session()->get('cart', []);
        
        // Tính tổng giá trị giỏ hàng
        $cartTotal = 0;
        foreach ($cart as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
        }
    
        // Lấy 3 mã giảm giá tối ưu nhất (dựa trên tổng giỏ hàng)
        $now = now();
    
        $coupons = Coupon::where('start_date', '<=', $now)
                    ->where('end_date', '>=', $now)
                    ->where(function($query) use ($cartTotal) {
                        $query->where('min_order_value', '<=', $cartTotal)
                              ->orWhereNull('min_order_value');
                    })
                    ->where(function($query) {
                        $query->whereColumn('usage_count', '<', 'usage_limit')
                              ->orWhereNull('usage_limit');
                    })
                    ->orderBy('value', 'desc') // Coupon giá trị giảm cao hơn ưu tiên trước
                    ->take(3)
                    ->get();
    
        return view('client.cart', compact('cart', 'coupons'));
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
// xử lý mã giảm giá trong giỏ hàng
public function applyCoupon(Request $request)
{
    // Validate mã giảm giá
    $request->validate([
        'coupon_code' => 'required|string',
    ]);

    // Tìm coupon theo mã
    $coupon = Coupon::where('code', $request->coupon_code)->first();

    // Kiểm tra nếu coupon không tồn tại
    if (!$coupon) {
        return redirect()->back()->with('error', 'Mã giảm giá không hợp lệ.');
    }

    // Kiểm tra hạn sử dụng của coupon
    if (Carbon::parse($coupon->end_date)->isPast()) {
        return redirect()->back()->with('error', 'Mã giảm giá đã hết hạn.');
    }

    // Kiểm tra số lượt sử dụng hiện tại
    $usageCount = Order::where('coupon_code', $coupon->code)->count();

    // Kiểm tra nếu coupon đã hết lượt sử dụng
    if ($coupon->usage_limit > 0 && $usageCount >= $coupon->usage_limit) {
        return redirect()->back()->with('error', 'Mã giảm giá đã hết lượt sử dụng.');
    }

    // Lấy tổng giỏ hàng từ session
    $cart = session()->get('cart', []);
    $total = 0;

    // Tính tổng giá trị giỏ hàng
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Kiểm tra giá trị đơn hàng có đủ điều kiện sử dụng mã giảm giá
    if ($total < $coupon->min_order_value) {
        return redirect()->back()->with('error', 'Giá trị đơn hàng không đủ để áp dụng mã giảm giá.');
    }

    $discountAmount = 0;

    // Tính toán số tiền giảm giá theo loại coupon
    if ($coupon->type == 'percentage') {
        $discountAmount = ($total * $coupon->value) / 100;

        // Giới hạn số tiền giảm giá không vượt quá max_discount_value
        if ($coupon->max_discount_value && $discountAmount > $coupon->max_discount_value) {
            $discountAmount = $coupon->max_discount_value;
        }
    } elseif ($coupon->type == 'fixed') {
        // Nếu là giảm giá cố định, kiểm tra nếu coupon không vượt quá tổng giỏ hàng
        $discountAmount = min($coupon->value, $total);
    }

    // Đảm bảo tổng giỏ hàng không bị âm sau khi áp dụng mã giảm giá
    $finalTotal = $total - $discountAmount;

    // Nếu tổng giỏ hàng sau khi giảm giá là âm, điều chỉnh lại giá trị giảm giá
    if ($finalTotal < 0) {
        $discountAmount = $total; // Chỉ giảm hết số tiền có trong giỏ hàng
        $finalTotal = 0; // Đảm bảo tổng giỏ hàng không bị âm
    }

    // Lưu thông tin mã giảm giá vào session
    session([
        'coupon' => [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'description' => $coupon->description ?? '',
            'max_discount_value' => $coupon->max_discount_value ?? null,
            'min_order_value' => $coupon->min_order_value ?? 0,
            'apply_to_all_products' => $coupon->apply_to_all_products,
            'discount_amount' => $discountAmount,
            'end_date' => $coupon->end_date,
        ]
    ]);

    // Lưu tổng giỏ hàng đã giảm vào session
    session(['total' => $finalTotal]);

    return redirect()->back()->with('success', 'Áp dụng mã giảm giá thành công!');
}



//hủy mã giảm giá 
public function removeCoupon()
{
    // Xóa mã giảm giá khỏi session
    session()->forget('coupon');

    // Cập nhật lại giỏ hàng, tính toán lại tổng tiền
    return redirect()->route('cart.view')->with('success', 'Mã giảm giá đã được hủy.');
}


}

