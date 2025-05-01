<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends model{
public function product()
{
    return $this->belongsTo(Product::class);
}

public function attributeValues()
{
    return $this->belongsToMany(AttributeValue::class, 'variant_attribute_value');
}
public function orderDetails()
{
    return $this->hasMany(OrderDetail::class);
}
// Trong model Variant.php
public function attributes()
{
    return $this->belongsToMany(Attribute::class, 'attribute_value_variant', 'variant_id', 'attribute_id')
                ->withPivot('value');
}



}
