<?php 
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class checkoutController extends Controller
{
    public function selectProducts(Request $request)
{
    $selectedProductIds = $request->input('selected_products', []);

    // Xử lý các sản phẩm đã chọn để thanh toán
    $cart = session('cart', []);
    $selectedProducts = [];
    
    foreach ($selectedProductIds as $productId) {
        if (isset($cart[$productId])) {
            $selectedProducts[] = $cart[$productId];
        }
    }

    // Tiến hành thanh toán với các sản phẩm đã chọn
    // Ví dụ: redirect tới trang thanh toán
    return view('client.order', compact('selectedProducts'));
}

}
