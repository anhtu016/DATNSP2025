<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 
        'attribute_id', 
        'attribute_value_id'
    ];

    // Mối quan hệ với bảng Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Mối quan hệ với bảng Attribute
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    // Mối quan hệ với bảng AttributeValue
    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class);
    }
}
