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
        // Lấy tất cả các thuộc tính với giá trị của chúng
        $dataAttributes = Attribute::with('values')->latest()->paginate(10);
    
        // Tạo mảng attributes từ các thuộc tính và giá trị
        $attributesArray = [];
    
        foreach ($dataAttributes as $attribute) {
            $values = $attribute->values->pluck('value')->toArray(); // Lấy các giá trị thuộc tính
            $attributesArray[$attribute->name] = $values; // Thêm vào mảng theo tên thuộc tính
        }
    
        // Truyền mảng vào view
        return view('admin.attributes', compact('attributesArray', 'dataAttributes'));
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
// AttributeController.php
public function store(Request $request)
{
    $request->validate([
        'nameAttribute' => 'required|string|max:255',
        'selectAttribute' => 'required|string',
        'valueAttribute' => 'required|array',
        'valueAttribute.*' => 'required|string',
    ]);

    // Check nếu attribute đã tồn tại
    $attribute = Attribute::where('name', $request->nameAttribute)->first();

    if (!$attribute) {
        // Nếu chưa tồn tại thì tạo mới
        $attribute = Attribute::create([
            'name' => $request->nameAttribute,
            'type' => $request->selectAttribute,
        ]);
    }

    // Sau đó tạo các valueAttribute
    foreach ($request->valueAttribute as $value) {
        AttributeValue::create([
            'attribute_id' => $attribute->id,
            'value' => $value,
        ]);
    }

    return redirect()->back()->with('success', 'Done');
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
