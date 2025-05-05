<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use Carbon\Carbon;
class turnoverController extends Controller
{
    
    public function index(Request $request)
    {
        // Query đơn hàng giao thành công
        $query = Order::query()->where('order_status', 'delivered');
        
        // Lọc theo năm nếu có
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }
        
        // Lọc theo tháng nếu có
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }
    
        // Lấy danh sách đơn hàng
        $orders = $query->get();
    
        // Tổng doanh thu
        $totalRevenue = $orders->sum('total_amount');
    
        // Doanh thu từ đơn hàng có mã giảm giá
        $revenueWithDiscount = $orders->whereNotNull('coupon_code')->sum('total_amount');
    
        // Tổng số tiền giảm giá
        $totalDiscount = $orders->sum('discount_amount');
    
        // Doanh thu theo tháng và năm (để hiển thị trong bảng)
        $monthlyRevenue = DB::table('order')
                            ->where('order_status', 'delivered')
                            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total_amount) as revenue')
                            ->groupBy(DB::raw('MONTH(created_at)'), DB::raw('YEAR(created_at)'))
                            ->get();
    
        return view('admin.turnover', compact(
            'totalRevenue',
            'monthlyRevenue', // Cung cấp doanh thu theo tháng
            'revenueWithDiscount',
            'totalDiscount'
        ));
    }
    
    public function showRevenue()
    {
        $monthlyRevenue = DB::table('order')
            ->where('order_status', 'delivered')
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total_amount) as revenue')
            ->groupBy(DB::raw('MONTH(created_at)'), DB::raw('YEAR(created_at)'))
            ->get();
    
        return view('revenue', compact('monthlyRevenue'));
    }
    
    

    
    

}
