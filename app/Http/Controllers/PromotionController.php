<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
class PromotionController extends Controller
{



    public function index()
    {
        $coupons = Coupon::orderBy('end_date', 'asc')->get(); // Lấy tất cả, kể cả hết hạn
        return view('client.promotions', compact('coupons'));
    }


}
