<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $listReviews = ProductReview::query()->paginate(10);
        return view('admin.reviews.index', compact('listReviews'));
    }

    public function loadReview($id)
    {
       
        return view('client.detail-product', compact('loadReviews'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|between:1,5',
            'description' => 'required|string|max:1000',
        ]);

        ProductReview::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'description' => $request->description,
            'status' => 0, // Mặc định là chưa duyệt
        ]);

        return back()->with('success', 'Đánh giá của bạn đã được gửi và đang chờ duyệt.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
     public function presently($id){
            $review = ProductReview::find($id);
            if($review->status == 1){
                $review->update([
                    'status' => 0
                ]);
            }else{
                $review->update([
                    'status' => 1
                ]);
            }
            return redirect()->route('reviews.index');
    }
}
