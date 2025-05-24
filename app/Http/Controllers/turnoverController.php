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
        // 1. Base query cho đơn hàng "delivered"
        $baseQ = Order::query()
            ->where('order_status', 'delivered');

        // 2. Áp filter năm / tháng nếu có
        if ($request->filled('year')) {
            $baseQ->whereYear('created_at', $request->year);
        }
        if ($request->filled('month')) {
            $baseQ->whereMonth('created_at', $request->month);
        }

        // 3. Tính tổng các chỉ số mà không load toàn bộ collection
        $totalRevenue        = (clone $baseQ)->sum('total_amount');
        $revenueWithDiscount = (clone $baseQ)
                                  ->whereNotNull('coupon_code')
                                  ->sum('total_amount');
        $totalDiscount       = (clone $baseQ)->sum('discount_amount');

        // 4. Lấy doanh thu theo tháng & năm kèm filter
        $monthlyRevenue = (clone $baseQ)
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total_amount) as revenue')
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderBy('year','desc')
            ->orderBy('month','desc')
            ->get();

        // 5. Render view
        return view('admin.turnover', compact(
            'totalRevenue',
            'revenueWithDiscount',
            'totalDiscount',
            'monthlyRevenue'
        ));
    }
}

    

    
    


