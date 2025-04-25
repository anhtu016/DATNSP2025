<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupon';

  
    protected $fillable = [
        'code', 'type', 'value', 'description', 'min_order_value', 'max_discount_value',
        'start_date', 'end_date', 'product_id', 'category_id', 'brand_id',   'apply_to_all_products','usage_limit'
    ];
    
    public function isValid()
{
    $now = now();
    return $this->start_date <= $now && $this->end_date >= $now;
}
public function products()
{
    return $this->belongsToMany(Product::class, 'coupon_product');
}


}
