<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Product;

use App\Models\ProductImage;
use App\Models\ProductReview;
use Illuminate\Http\Request;


class ProductDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $detailProduct = Product::query()->find($id);
        $imageProduct = ProductImage::query()->where('product_id',$id)->get();
        $loadReviews = ProductReview::with(['product', 'user'])
        ->where('product_id', $id)->get();    

     
        return view('client.detail-product', compact('detailProduct','imageProduct','loadReviews','isLowStock'));
    }
}
