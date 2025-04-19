<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Order $order)
    {
        $ratings = $request->input('rating');
        $description = $request->input('description');

        foreach ($order->orderDetails as $item) {
            if (isset($ratings[$item->id]) && isset($comments[$item->id])) {
                ProductReview::create([
                    'product_id' => $item->product_id,
                    'rating' => $ratings[$item->id],
                    'description' => $description[$item->id],
                    'user_id' => auth()->id(),
                    'status' => 1
                ]);
            }
        }

        return redirect()->route('orders.review', $order->id)->with('success', 'Đánh giá của bạn đã được gửi thành công!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // dd(1);
        $order = Order::where('id', $id)
        ->with(['orderDetails.product', 'paymentMethod', 'shippingMethod'])
        ->firstOrFail();
        // dd($order->orderDetails,$order);
        return view('client.orders.review', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
