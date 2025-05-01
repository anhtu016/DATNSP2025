<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
class PromotionController extends Controller
{



    public function index()
    {
        $now = now();
    
        $coupons = Coupon::where('is_active', true)
            ->whereDate('start_date', '<=', $now)
            ->whereDate('end_date', '>=', $now)
            ->orderBy('end_date', 'asc')
            ->get();
    
        return view('client.promotions', compact('coupons'));
    }
    


}
