<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
    $rules = [];
    $attributes = [];

    foreach ($order->orderDetails as $item) {
        $rules["image.{$item->id}"] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        $rules["rating.{$item->id}"] = 'required|integer|min:1|max:5';
        $rules["description.{$item->id}"] = 'required|string';

        $attributes["image.{$item->id}"] = 'ảnh đánh giá';
        $attributes["rating.{$item->id}"] = 'đánh giá sao';
        $attributes["description.{$item->id}"] = 'bình luận';
    }

    // Validate dữ liệu, nếu lỗi sẽ tự redirect với lỗi về form
    $request->validate($rules, [], $attributes);

    // Lấy dữ liệu
    $ratings = $request->input('rating', []);
    $descriptions = $request->input('description', []);
    $images = $request->file('image', []);

    $hasReview = false;
    $hasError = false;
    $errorMessage = null;

    foreach ($order->orderDetails as $item) {
        $orderDetailId = $item->id;

        $rating = $ratings[$orderDetailId] ?? null;
        $description = trim($descriptions[$orderDetailId] ?? '');
        $variantId = $item->variant_id;

        $alreadyReviewed = ProductReview::where([
            'variants_id' => $variantId,
            'user_id' => auth()->id(),
            'order_id' => $item->order_id,
        ])->exists();

        if (!$alreadyReviewed) {
            $imagePath = null;
            if (isset($images[$orderDetailId])) {
                $imagePath = $images[$orderDetailId]->store('reviews', 'public');
            }

            ProductReview::create([
                'variants_id' => $variantId,
                'user_id' => auth()->id(),
                'order_id' => $item->order_id,
                'rating' => $rating,
                'description' => $description,
                'status' => 1,
                'product_id' => $item->product_id,
                'image' => $imagePath,
            ]);

            $hasReview = true;
        } else {
            $hasError = true;
            $errorMessage = "Bạn đã đánh giá sản phẩm ID $orderDetailId rồi.";
            break;
        }
    }

    if ($hasReview) {
        return redirect()->route('orders.review', $order->id)
            ->with('success', 'Đánh giá của bạn đã được gửi thành công!');
    } elseif ($hasError) {
        return redirect()->route('orders.review', $order->id)
            ->with('error', $errorMessage)
            ->withInput();
    }

    return redirect()->route('orders.review', $order->id)
        ->with('error', 'Vui lòng nhập đánh giá cho sản phẩm')
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
