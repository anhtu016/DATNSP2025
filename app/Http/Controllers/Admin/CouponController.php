<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        // Lấy tất cả các mã giảm giá với phân trang
        $coupons = Coupon::paginate(10); // 10 mã mỗi trang
    
        // Kiểm tra các đơn hàng đã bị hủy và có sử dụng mã giảm giá
    
        // Trả về danh sách mã giảm giá
        return view('admin.coupons.index', compact('coupons'));
    }
    

    public function create()
    {
        $products = Product::all();
        return view('admin.coupons.create', compact('products'));
    
    }
    public function store(Request $request)
    {
        // Validate dữ liệu từ request
        $validated = $request->validate([
            'code' => 'required|string|unique:coupon,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric',
            'min_order_value' => 'nullable|numeric',
            'start_date' => 'required|date|after_or_equal:today', // Validate start_date
            'end_date' => 'required|date|after_or_equal:start_date', // end_date >= start_date
            'apply_to_all_products' => 'nullable|boolean',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
            'usage_limit' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean', 
        ]);
    
        // Kiểm tra nếu type là 'percentage'
        if ($validated['type'] === 'percentage') {
            if ($validated['value'] < 0 || $validated['value'] > 100) {
                return redirect()->back()->withInput()->with('error', 'Giá trị giảm giá cho loại "percentage" phải trong khoảng 0 đến 100%.');
            }
    
            if (floor($validated['value']) != $validated['value']) {
                return redirect()->back()->withInput()->with('error', 'Giá trị giảm giá cho loại "percentage" phải là số nguyên.');
            }
        }
    
        // Kiểm tra nếu type là 'fixed'
        if ($validated['type'] === 'fixed') {
            if (floor($validated['value']) != $validated['value']) {
                return redirect()->back()->withInput()->with('error', 'Giá trị giảm giá cho loại "fixed" phải là số nguyên.');
            }
    
            if ($validated['value'] <= 0) {
                return redirect()->back()->withInput()->with('error', 'Giá trị giảm giá cho loại "fixed" phải lớn hơn 0.');
            }
        }
    
        // Lưu start_date và end_date
        $startDate = \Carbon\Carbon::parse($validated['start_date'])->toDateString();
        $endDate = \Carbon\Carbon::parse($validated['end_date'])->toDateString();
    
        // Tạo mã giảm giá
        $coupon = Coupon::create([
            'code' => $validated['code'],
            'type' => $validated['type'],
            'value' => $validated['value'],
            'min_order_value' => $validated['min_order_value'] ?? null,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'apply_to_all_products' => $validated['apply_to_all_products'] ?? false,
            'usage_limit' => $validated['usage_limit'],
            'is_active' => $validated['is_active'] ?? true, 
        ]);
    
        // Gắn sản phẩm nếu có
        if (!$coupon->apply_to_all_products && !empty($validated['product_ids'])) {
            $coupon->products()->attach($validated['product_ids']);
        }
    
        return redirect()->route('admin.coupons.index')->with('success', 'Tạo mã giảm giá thành công!');
    }
    
    
    
    
    
    //sửa
    public function edit(Coupon $coupon)
    {
        $products = Product::all();
        return view('admin.coupons.edit', compact('coupon','products'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        // Kiểm tra xem mã đã được sử dụng ít nhất 1 lần hoặc đã hết hạn chưa
        if ($coupon->usage_count > 0 || $coupon->end_date < now()) {
            return redirect()->back()->with('error', 'Không thể sửa mã giảm giá đã có lượt sử dụng hoặc đã hết hạn sử dụng.');
        }
    
        $validated = $request->validate([
            'code' => 'required|string|unique:coupon,code,' . $coupon->id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric',
            'min_order_value' => 'nullable|numeric',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'apply_to_all_products' => 'nullable|boolean',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
            'usage_limit' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean', 
        ]);
    
        // Cập nhật thông tin mã giảm giá
        $coupon->update([
            'code' => $validated['code'],
            'type' => $validated['type'],
            'value' => $validated['value'],
            'min_order_value' => $validated['min_order_value'] ?? null,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'apply_to_all_products' => $validated['apply_to_all_products'] ?? false,
            'usage_limit' => $validated['usage_limit'],
            'is_active' => $validated['is_active'] ?? true, 
        ]);
    
        if (!$coupon->apply_to_all_products) {
            $coupon->products()->sync($validated['product_ids'] ?? []);
        } else {
            $coupon->products()->detach();
        }
    
        return redirect()->route('admin.coupons.index')->with('success', 'Cập nhật mã giảm giá thành công!');
    }
    
    
    //xóa
    public function destroy(Coupon $coupon)
    {
        $now = now();
    
        // Không cho phép xóa nếu mã còn hạn hoặc còn lượt sử dụng
        
        $usageRemaining = is_null($coupon->usage_limit) || $coupon->usage_limit <= $coupon->usage_count;
        $isExpired = $coupon->end_date < $now;
        if (!($isExpired || $usageRemaining)) {
            return redirect()->back()->with('error', 'Chỉ được xóa mã giảm giá khi đã hết hạn hoặc đã hết lượt sử dụng.');
        }
        
    
        $coupon->delete();
        return redirect()->route('coupons.index')->with('success', 'Mã giảm giá đã xóa thành công.');
    }
    // ẩn và hiện
    public function toggleStatus(Coupon $coupon)
{
    $coupon->is_active = !$coupon->is_active;
    $coupon->save();

    return redirect()->back()->with('success', 'Cập nhật trạng thái mã giảm giá thành công!');
}
// cập nhật mã giảm giá 






}
