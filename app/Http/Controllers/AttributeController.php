<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;


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
    // Validate dữ liệu đầu vào
    $request->validate([
        'nameAttribute' => 'required|string|max:255',
        'selectAttribute' => 'required|string',
        'valueAttribute' => 'required|array',
        'valueAttribute.*' => 'required|string',
    ]);

    // Kiểm tra xem có giá trị nào trong valueAttribute đã tồn tại trong hệ thống chưa
    foreach ($request->valueAttribute as $value) {
        $exists = AttributeValue::where('value', $value)->exists();
        
        if ($exists) {
            // Nếu đã tồn tại, thông báo lỗi và không tiếp tục tạo mới attribute
            session()->flash('error', 'Giá trị "' . $value . '" đã tồn tại trong hệ thống. Không thể thêm mới thuộc tính.');
            return redirect()->back(); // Trả lại trang với thông báo lỗi
        }
    }

    // Kiểm tra xem attribute đã tồn tại chưa
    $attribute = Attribute::where('name', $request->nameAttribute)->first();

    if (!$attribute) {
        // Nếu chưa tồn tại thì tạo mới
        $attribute = Attribute::create([
            'name' => $request->nameAttribute,
            'type' => $request->selectAttribute,
        ]);
    }

    // Tạo các valueAttribute sau khi xác nhận không có trùng lặp
    foreach ($request->valueAttribute as $value) {
        AttributeValue::create([
            'attribute_id' => $attribute->id,
            'value' => $value,
        ]);
    }

    // Thông báo thành công khi tạo mới
    return redirect()->back();
}











public function update(Request $request, string $id)
{
    $validated = $request->validate([
        'updateAttribute' => 'required|string|max:255',
        'updateType' => 'required|in:color,size,text',
        'updateValue' => 'nullable|array',
        'updateValue.*' => 'string|max:255',
    ]);

    // Tìm và cập nhật thuộc tính
    $updateAttribute = Attribute::findOrFail($id);
    $updateAttribute->update([
        'name' => $validated['updateAttribute'],
        'type' => $validated['updateType'],
    ]);

    $newValues = collect($validated['updateValue'] ?? []);
    $currentValues = $updateAttribute->values;

    // Xóa những value không còn trong danh sách mới và không bị liên kết với variant nào
    foreach ($currentValues as $value) {
        if (!$newValues->contains($value->value)) {
            // Kiểm tra xem value này có đang được sử dụng trong variant không
            $isUsed = DB::table('variant_attribute_value') // hoặc bảng trung gian của bạn
                ->where('attribute_value_id', $value->id)
                ->exists();

            if (!$isUsed) {
                $value->delete();
            }
        }
    }

    // Thêm giá trị mới chưa có và đảm bảo không trùng
    foreach ($newValues as $newValue) {
        // Kiểm tra nếu giá trị này đã tồn tại trong thuộc tính
        $exists = $updateAttribute->values()->where('value', $newValue)->exists();

        if (!$exists) {
            $updateAttribute->values()->create([
                'value' => $newValue,
            ]);
        } else {
            // Nếu trùng thì thông báo lỗi
            return back()->with('error', 'Giá trị "' . $newValue . '" đã tồn tại trong hệ thống.');
        }
    }

    return back()->with('success', 'Cập nhật thành công mà không mất dữ liệu biến thể');
}




    
    public function destroy(string $id)
    {
        Attribute::find($id)->forceDelete();
        return back()->with('success','Delete success');
    }
}
