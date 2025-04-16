<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listCategory = Category::query()->get();
        return view('admin.categories.index', compact('listCategory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $createCategory = Category::query()->create($data);
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $editCategory = Category::query()->find($id);
        return view('admin.categories.edit', compact('editCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->except('_token');
        $updateCategory = Category::query()->findOrFail($id);
        $updateCategory->update($data);
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delCategory = Category::query()->find($id);
        $delCategory->delete();
        return redirect()->route('categories.index');
    }

    public function trash( ){
        $trash = Category::query()->onlyTrashed()->get();             
        return view('admin.categories.trash', compact('trash'));
    }

    public function reset(string $id){
        Category::query()->withTrashed()->where('id',$id)
        ->restore();
        return redirect()->route('categories.index');       
    }
    public function forceDelete(string $id){
        Category::query()->withTrashed()->where('id',$id)
        ->forceDelete();
        return redirect()->route('categories.index');       
    }


}
