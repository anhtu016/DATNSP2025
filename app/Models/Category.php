<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
class Category extends Model
{
    use HasFactory;
    use NodeTrait;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'name', 
        'slug',
        'description',
    ];
    public function products()
{
    return $this->belongsToMany(Product::class, 'product_category');
}


}
