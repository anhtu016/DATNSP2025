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

    // Kiểm tra xem có mã giảm giá hợp lệ hay không
    $hasValidCoupon = $coupons->isNotEmpty();

    return view('client.cart', compact('cart', 'coupons', 'hasValidCoupon'));
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

    $variant = Variant::where('product_id', $id)
        ->whereHas('attributeValues', function ($query) use ($colorId, $sizeId) {
            $query->whereIn('attribute_value_id', [$colorId, $sizeId]);
        }, '=', 2)
        ->first();

    if (!$variant) {
        return redirect()->back()->with('error', 'Không tìm thấy biến thể phù hợp.');
    }

    if (!is_numeric($variant->quantity_variant) || $variant->quantity_variant < $quantity) {
        return redirect()->back()->with('error', 'Số lượng tồn kho không đủ.');
    }

    $variantImage = $variant->image_variant ?? $product->thumbnail ?? 'client/img/default.png';

    $cartItemId = $id . '-' . $colorId . '-' . $sizeId;
    $cart = session()->get('cart', []);

    if (isset($cart[$cartItemId])) {
        $newQuantity = $cart[$cartItemId]['quantity'] + $quantity;

        if ($variant->quantity_variant < $newQuantity) {
            return redirect()->back()->with('error', 'Số lượng tồn kho không đủ để thêm tiếp.');
        }

        $cart[$cartItemId]['quantity'] = $newQuantity;
        $cart[$cartItemId]['quantity_variant'] = $variant->quantity_variant; // ✅ cập nhật lại
    } else {
        $cart[$cartItemId] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $quantity,
            'Color' => $color->value,
            'Size' => $size->value,
            'thumbnail' => $variantImage,
            'variant_id' => $variant->id,
            'quantity_variant' => $variant->quantity_variant, // ✅ thêm vào đây
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

        // Tính lại tổng giá trị giỏ hàng
        $updatedSubtotal = 0;
        $updatedTotal = 0;
        foreach ($cart as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $updatedSubtotal += $itemTotal;
        }

        // Trả về dữ liệu JSON với các thông tin cần thiết
        return response()->json([
            'success' => true,
            'updatedSubtotal' => number_format($updatedSubtotal),
            'updatedTotal' => number_format($updatedSubtotal) // hoặc tính toán tổng nếu có giảm giá
        ]);
    }

    return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng.']);
}

// xử lý mã giảm giá trong giỏ hàng
// public function applyCoupon(Request $request)
// {
//     $request->validate([
//         'coupon_code' => 'required|string',
//     ]);

//     $selectedItems = $request->input('selected_items', []);
    

//     // ✅ Kiểm tra nếu không có sản phẩm nào được chọn
//     if (empty($selectedItems)) {
//         return redirect()->back()
//             ->withInput()
//             ->with('error', 'Vui lòng chọn ít nhất một sản phẩm để áp dụng mã giảm giá.');
//     }

//     $coupon = Coupon::where('code', $request->coupon_code)->first();
//     if (!$coupon) {
//         return redirect()->back()->with('error', 'Mã giảm giá không hợp lệ.');
//     }

//     if (Carbon::parse($coupon->end_date)->isPast()) {
//         return redirect()->back()->with('error', 'Mã giảm giá đã hết hạn.');
//     }

//     $usageCount = Order::where('coupon_code', $coupon->code)->count();
//     if ($coupon->usage_limit > 0 && $usageCount >= $coupon->usage_limit) {
//         return redirect()->back()->with('error', 'Mã giảm giá đã hết lượt sử dụng.');
//     }

//     $cart = session()->get('cart', []);
//     $total = 0;

//     // ✅ Chỉ tính tổng của các sản phẩm đã chọn
//     foreach ($cart as $id => $item) {
//         if (in_array($id, $selectedItems)) {
//             $total += $item['price'] * $item['quantity'];
//         }
//     }

//     if ($total < $coupon->min_order_value) {
//         return redirect()->back()->with('error', 'Giá trị đơn hàng không đủ để áp dụng mã giảm giá.');
//     }

//     $discountAmount = 0;
//     if ($coupon->type == 'percentage') {
//         $discountAmount = ($total * $coupon->value) / 100;
//         if ($coupon->max_discount_value && $discountAmount > $coupon->max_discount_value) {
//             $discountAmount = $coupon->max_discount_value;
//         }
//     } elseif ($coupon->type == 'fixed') {
//         $discountAmount = min($coupon->value, $total);
//     }

//     $finalTotal = $total - $discountAmount;
//     if ($finalTotal < 0) {
//         $discountAmount = $total;
//         $finalTotal = 0;
//     }

//     // Phân bổ giảm giá theo tỷ lệ giá từng sản phẩm được chọn
// $discountPerItem = [];
// foreach ($selectedItems as $id) {
//     if (isset($cart[$id])) {
//         $itemTotal = $cart[$id]['price'] * $cart[$id]['quantity'];
//         $ratio = $itemTotal / $total;
//         $discountPerItem[$id] = round($discountAmount * $ratio); // phân bổ làm tròn
//     }
// }

// // Lưu session chi tiết mã giảm giá
// session([
//     'coupon' => [
//         'code' => $coupon->code,
//         'type' => $coupon->type,
//         'value' => $coupon->value,
//         'description' => $coupon->description ?? '',
//         'max_discount_value' => $coupon->max_discount_value ?? null,
//         'min_order_value' => $coupon->min_order_value ?? 0,
//         'end_date' => $coupon->end_date,
//         'selected_items' => $selectedItems,
//         'discount_amount' => $discountAmount,
//     ],
//     'coupon_applied_items' => $discountPerItem, // 💡 danh sách sản phẩm và giảm giá tương ứng
//     'discounted_subtotal' => $finalTotal,
// ]);

//     return redirect()->back()
//         ->withInput()
//         ->with('success', 'Áp dụng mã giảm giá thành công!');
// }




//hủy mã giảm giá 
// public function removeCoupon()
// {
//     session()->forget('coupon');
//     session()->forget('selectedItems');

//     return redirect()->back()->with('success', 'Đã hủy mã giảm giá.');
// }



}

