<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use Illuminate\Database\QueryException;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;



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


public function store(Request $request)
{
    // Danh sách các thể loại hợp lệ
    $validTypes = ['size', 'color', 'classification'];

    // Validate dữ liệu đầu vào
    $request->validate([
        'nameAttribute' => 'required|string|max:255',
        'selectAttribute' => ['required', 'string', Rule::in($validTypes)],  // Kiểm tra thể loại hợp lệ
        'valueAttribute' => 'required|array',
        'valueAttribute.*' => 'required|string',
    ]);

    // Kiểm tra xem có giá trị nào trong valueAttribute đã tồn tại chưa
    foreach ($request->valueAttribute as $value) {
        $exists = AttributeValue::where('value', $value)->exists();
        
        if ($exists) {
            session()->flash('error', 'Giá trị "' . $value . '" đã tồn tại trong hệ thống.');
            return redirect()->back();
        }
    }

    // Kiểm tra xem thuộc tính đã tồn tại chưa
    $attribute = Attribute::where('name', $request->nameAttribute)->first();

    if (!$attribute) {
        // Nếu chưa tồn tại, tạo mới thuộc tính với thể loại đã chọn
        $attribute = Attribute::create([
            'name' => $request->nameAttribute,
            'type' => $request->selectAttribute,  // Sử dụng thể loại đã chọn
        ]);
    }

    // Tạo các giá trị thuộc tính
    foreach ($request->valueAttribute as $value) {
        AttributeValue::create([
            'attribute_id' => $attribute->id,
            'value' => $value,
        ]);
    }

    return back()->with('success', 'Thêm giá trị biến thể mới thành công');
}













    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'updateAttribute' => 'required|string|max:255',
            'updateType' => 'required|in:color,size,classification',
            'updateValue' => 'nullable|array',
            'updateValue.*' => 'string|max:255',
        ]);

        $updateAttribute = Attribute::findOrFail($id);
        $updateAttribute->update([
            'name' => $validated['updateAttribute'],
            'type' => $validated['updateType'],
        ]);

        $newValues = collect($validated['updateValue'] ?? []);
        $currentValues = $updateAttribute->values;

        // Kiểm tra giá trị trùng lặp không hợp lệ
        foreach ($newValues as $newValue) {
            $exists = $updateAttribute->values()->where('value', $newValue)->exists();
            if ($exists && !in_array($newValue, $currentValues->pluck('value')->toArray())) {
                return back()->with('error', 'Giá trị "' . $newValue . '" đã tồn tại trong hệ thống.');
            }
        }

        // Kiểm tra và xóa giá trị không còn dùng
        foreach ($currentValues as $value) {
            if (!$newValues->contains($value->value)) {
                // Kiểm tra xem giá trị có đang được sử dụng trong biến thể nào không
                $isUsed = DB::table('variant_attribute_value')
                    ->where('attribute_value_id', $value->id)
                    ->exists();

                if ($isUsed) {
                    return back()->with('error', 'Không thể sửa giá trị "' . $value->value . '" vì đang được sử dụng trong một biến thể.');
                }

                $value->delete();
            }
        }

        // Thêm giá trị mới nếu chưa có
        foreach ($newValues as $newValue) {
            $existsInSystem = $updateAttribute->values()->where('value', $newValue)->exists();
            if (!$existsInSystem) {
                $updateAttribute->values()->create([
                    'value' => $newValue,
                ]);
            }
        }

        return back()->with('success', 'Cập nhật thành công mà không mất dữ liệu biến thể');
    }







    public function destroy(string $id)
    {
        $attribute = Attribute::with('values')->findOrFail($id);

        // Kiểm tra từng giá trị có đang được dùng trong biến thể không
        foreach ($attribute->values as $value) {
            $isUsed = DB::table('variant_attribute_value')
                ->where('attribute_value_id', $value->id)
                ->exists();

            if ($isUsed) {
                return back()->with('error', 'Không thể xóa thuộc tính vì một hoặc nhiều giá trị đang được sử dụng trong biến thể.');
            }
        }

        // Nếu không bị sử dụng, xóa hết các giá trị rồi xóa thuộc tính
        $attribute->values()->delete();
        $attribute->forceDelete();

        return back()->with('success', 'Xóa thành công');
    }
    public function destroyValue(string $id)
    {
        $value = AttributeValue::findOrFail($id);

        // Kiểm tra nếu giá trị đang được dùng trong biến thể
        $isUsed = DB::table('variant_attribute_value')
            ->where('attribute_value_id', $value->id)
            ->exists();

        if ($isUsed) {
            return back()->with('error', 'Không thể xóa giá trị vì đang được sử dụng.');
        }

        $value->delete();
        return back()->with('success', 'Xóa giá trị thành công.');
    }

}
