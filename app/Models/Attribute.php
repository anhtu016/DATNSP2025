<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Attribute extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table ='attributes';
    protected $fillable =['name','type'];
    public function attributeValue(){
        return $this->hasMany(AttributeValue::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('attribute_value_id');
    }
    public function values() {
        return $this->hasMany(AttributeValue::class);
    }
    
}
