<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
class CategoriesController extends Controller
{
    public function index()
    {
        $listCategory = Category::query()->paginate(10);
        return view('admin.categories.index', compact('listCategory'));
    }

    public function create()
    {
        return view('admin.categories.add');
    }

    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|nullable|string|max:255|unique:categories', // Kiểm tra slug không trùng
            'description' => 'required|nullable|string|max:255'
        ]);
    
        // Nếu người dùng không nhập slug, tự động tạo slug từ tên
        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);
    
        // Lưu danh mục mới với slug nhập vào
        $data = $request->only('name','description');
        $data['slug'] = $slug;
    
        Category::create($data);
    
        return redirect()->route('categories.index')->with('success', 'Danh mục đã được tạo thành công');
    }

    public function edit(string $id)
    {
        $editCategory = Category::findOrFail($id);
        return view('admin.categories.edit', compact('editCategory'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $id,
            'description' => 'nullable|string',
        ]);
    
        $category = Category::findOrFail($id);
    
        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);
    
        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
        ]);
    
        return redirect()->route('categories.index')->with('success', 'Cập nhật danh mục thành công');
    }

    public function destroy(string $id)
    {
        $delCategory = Category::findOrFail($id);
        $delCategory->delete();

        return redirect()->route('categories.index')->with('success', 'Danh mục đã được đưa vào thùng rác');
    }

    public function trash()
    {
        $trash = Category::onlyTrashed()->get();
        return view('admin.categories.trash', compact('trash'));
    }

    public function reset(string $id)
    {
        Category::withTrashed()->where('id', $id)->restore();
        return redirect()->route('categories.index')->with('success', 'Khôi phục danh mục thành công');
    }

    public function forceDelete(string $id)
    {
        Category::withTrashed()->where('id', $id)->forceDelete();
        return redirect()->route('categories.index')->with('success', 'Xóa vĩnh viễn danh mục thành công');
    }

    public function showProducts($slug)
{
    $category = Category::where('slug', $slug)->firstOrFail();
    $products = $category->products()->paginate(12);

    return view('client.categories.index', compact('category', 'products'));
}
}
