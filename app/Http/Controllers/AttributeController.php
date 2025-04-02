<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataAttributes = Attribute::with('attributeValue')->latest()->paginate(10);
        return view('admin.attributes',compact('dataAttributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newAttribute = [
            'name' => $request->nameAttribute,
            'type' => $request->selectAttribute,
        ];
        Attribute::create($newAttribute);
        return back()
        ->with('success', 'Added Successfully')
        ->withResponse(response()->json([
            'status' => 'success',
            'message' => 'Data added successfully'
        ]));;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $newAttribute = [
            'name' => $request->updateAttribute,
            'type' => $request->updateType,
        ];
         $updateAttribute = Attribute::find($id);
         $updateAttribute->update($newAttribute);
        return back()->with('success','Update success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Attribute::find($id)->delete();
        return back()->with('success','Delete success');
    }
}
