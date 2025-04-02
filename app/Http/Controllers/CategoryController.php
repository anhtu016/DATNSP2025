<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::get()->toTree();
        return view('client.index', compact('categories'));
    }
    public function list_category()
    {
        $categories = Category::get()->toTree();
        return view('admin.add-category', compact('categories'));
    }

}
