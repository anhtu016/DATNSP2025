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
        $hasReview = false;
        $hasError = false;

        $images = $request->file('image');

        foreach ($order->orderDetails as $item) {
            if (isset($ratings[$item->id]) && isset($description[$item->id])) {
                $existingReview = ProductReview::where([
                    'variants_id' => $item->variant_id,
                    'user_id' => auth()->id(),
                    'order_id' => $item->order_id
                ])->first();

                if (!$existingReview) {
                    // Xử lý ảnh nếu có upload
                    $imagePath = null;
                    if (isset($images[$item->id])) {
                        $imagePath = $images[$item->id]->store('reviews', 'public');
                    }

                    // Tạo đánh giá
                    ProductReview::create([
                        'variants_id' => $item->variant_id,
                        'user_id' => auth()->id(),
                        'order_id' => $item->order_id,
                        'rating' => $ratings[$item->id],
                        'description' => $description[$item->id],
                        'status' => 1,
                        'product_id' => $item->product_id,
                        'image' => $imagePath, 
                    ]);
                    $hasReview = true;
                } else {
                    $hasError = true;
                }
            }
        }


        if ($hasReview) {
            return redirect()->route('orders.review', $order->id)
                ->with('success', 'Đánh giá của bạn đã được gửi thành công!');
        } elseif ($hasError) {
            return redirect()->route('orders.review', $order->id)
                ->with('error', 'Bạn đã đánh giá sản phẩm này rồi')
                ->withInput();
        }

        return redirect()->route('orders.review', $order->id)
            ->with('error', 'Vui lòng chọn đánh giá và nhập bình luận cho sản phẩm')
            ->withInput();
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
