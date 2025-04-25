<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\AttributeValue;

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
        // Validate nếu cần
        $request->validate([
            'nameAttribute' => 'required|string|max:255',
            'selectAttribute' => 'required|string|max:255',
            'valueAttribute' => 'required|array',
            'valueAttribute.*' => 'required|string|max:255'
        ]);
    
        // Tạo attribute mới
        $attribute = Attribute::create([
            'name' => $request->nameAttribute,
            'type' => $request->selectAttribute,
        ]);
    
        // Lưu từng value vào bảng attribute_values
        foreach ($request->valueAttribute as $value) {
            AttributeValue::create([
                'attribute_id' => $attribute->id,
                'value' => $value,
            ]);
        }
    
        return back()->with('success', 'Added Successfully');
    }
    



    public function update(Request $request, string $id)
    {
        // Cập nhật thuộc tính (name và type)
        $newAttribute = [
            'name' => $request->updateAttribute,
            'type' => $request->updateType,
        ];
    
        // Tìm và cập nhật thuộc tính
        $updateAttribute = Attribute::findOrFail($id); // Dùng findOrFail để xử lý khi không tìm thấy bản ghi
        $updateAttribute->update($newAttribute);
    
        // Cập nhật các giá trị (attribute_value)
        // Xóa các giá trị cũ trước khi thêm mới
        $updateAttribute->values()->delete();
    
        // Thêm các giá trị mới
        if ($request->updateValue) {
            foreach ($request->updateValue as $value) {
                $updateAttribute->values()->create([
                    'value' => $value,
                ]);
            }
        }
    
        // Trả về trang trước với thông báo thành công
        return back()->with('success', 'Update success');
    }
    
    public function destroy(string $id)
    {
        Attribute::find($id)->forceDelete();
        return back()->with('success','Delete success');
    }
}
