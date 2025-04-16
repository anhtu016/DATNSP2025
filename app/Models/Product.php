<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    use HasFactory;
    protected $table ='products';
    
    protected $fillable = [
        'name',
        'slug',
        'sku',
        'price',
        'sell_price',
        'short_description',
        'description',
        'thumbnail',
        'quantity',
        'brand_id',
    ];
    

    public function category(){
        return $this->belongsToMany(Category::class);
    }
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    public function productImage(){
        return $this->hasMany(Brand::class);
    }
    public function productReview(){
        return $this->hasMany(ProductReview::class);
    }
    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    // Quan hệ với Attribute thông qua ProductAttribute (nếu cần)
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attributes');
    }
    public function variants()
    {
        return $this->hasMany(Variant::class);
    }
    
    


}
