<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.coupons.create', compact('products'));
    
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:coupon,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric',
            'min_order_value' => 'nullable|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'apply_to_all_products' => 'nullable|boolean',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
        ]);
    
        $coupon = Coupon::create([
            'code' => $validated['code'],
            'type' => $validated['type'],
            'value' => $validated['value'],
            'min_order_value' => $validated['min_order_value'] ?? null,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'apply_to_all_products' => $validated['apply_to_all_products'] ?? false,
        ]);
    
        if (!$coupon->apply_to_all_products && !empty($validated['product_ids'])) {
            $coupon->products()->attach($validated['product_ids']);
        }
    
        return redirect()->route('admin.coupons.index')->with('success', 'Tạo mã giảm giá thành công!');
    }
    
    

    public function edit(Coupon $coupon)
    {
        $products = Product::all();
        return view('admin.coupons.edit', compact('coupon','products'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:coupon,code,' . $coupon->id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric',
            'min_order_value' => 'nullable|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'apply_to_all_products' => 'nullable|boolean',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
        ]);
    
        $coupon->update([
            'code' => $validated['code'],
            'type' => $validated['type'],
            'value' => $validated['value'],
            'min_order_value' => $validated['min_order_value'] ?? null,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'apply_to_all_products' => $validated['apply_to_all_products'] ?? false,
        ]);
    
        if (!$coupon->apply_to_all_products) {
            $coupon->products()->sync($validated['product_ids'] ?? []);
        } else {
            $coupon->products()->detach();
        }
    
        return redirect()->route('admin.coupons.index')->with('success', 'Cập nhật mã giảm giá thành công!');
    }
    

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Mã giảm giá đã được xóa.');
    }
}
