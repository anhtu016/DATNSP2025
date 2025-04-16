<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Order;
use App\Models\AttributeValue;
class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_detail';  // Đảm bảo tên bảng chính xác
    protected $fillable = [
        'order_id',
        'product_id',
        'variant_id',
        'quantity',
        'price',
        'total',
    ];

    // Mối quan hệ với bảng Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    // Mối quan hệ với bảng Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    // Mối quan hệ với bảng AttributeValue (nếu có liên quan đến sản phẩm biến thể)
    // public function productVariantAttributeValue()
    // {
    //     return $this->belongsTo(AttributeValue::class, 'product_variant_attribute_value_id', 'id');
    // }
}
