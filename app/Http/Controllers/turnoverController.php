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
        
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }
    
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }
    
        $orders = $query->get();
    
        // Tổng doanh thu
        $totalRevenue = $orders->sum('total_amount');
    
        // Doanh thu theo tháng
        $monthlyRevenue = $orders
            ->groupBy(function ($order) {
                return Carbon::parse($order->created_at)->format('Y-m');
            })
            ->map(function ($group) {
                $first = $group->first();
                return (object)[
                    'year' => Carbon::parse($first->created_at)->year,
                    'month' => Carbon::parse($first->created_at)->month,
                    'revenue' => $group->sum('total_amount')
                ];
            })
            ->values();
    
        // Doanh thu theo năm
        $annualRevenue = $orders
            ->groupBy(function ($order) {
                return Carbon::parse($order->created_at)->year;
            })
            ->map(function ($group) {
                $first = $group->first();
                return (object)[
                    'year' => Carbon::parse($first->created_at)->year,
                    'revenue' => $group->sum('total_amount')
                ];
            })
            ->values();
    
        // Doanh thu từ đơn hàng có mã giảm giá
        $revenueWithDiscount = $orders
            ->whereNotNull('coupon_code')
            ->sum('total_amount');
    
        // Tổng số tiền giảm giá
        $totalDiscount = $orders->sum('discount_amount');
    
        return view('admin.turnover', compact(
            'totalRevenue',
            'monthlyRevenue',
            'annualRevenue',
            'revenueWithDiscount',
            'totalDiscount'
        ));
    }
    
    

}
