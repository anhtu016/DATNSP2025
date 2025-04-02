<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    public function list_category()
    {
        
        // $categories = Category::get()->toTree();
        return view('admin.add-category');
    }

}
