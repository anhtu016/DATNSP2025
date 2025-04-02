<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
class Category extends Model
{
    use HasFactory;
    use NodeTrait;
    protected $fillable = [
        'id',
        'name', 
        'slug',
        'description',
    ];

// =======
//     protected $table ='categories';
//     public function product(){
//         return $this->belongsToMany(Product::class);
//     }
// >>>>>>> main
}
