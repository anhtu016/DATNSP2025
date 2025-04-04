<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    public function list_category()
    {
// <<<<<<< cong_code
        $categories = Category::get()->toTree();
        return view('admin.add-category', compact('categories'));
// =======
        
//         // $categories = Category::get()->toTree();
//         return view('admin.add-category');
// >>>>>>> main
    }

}
