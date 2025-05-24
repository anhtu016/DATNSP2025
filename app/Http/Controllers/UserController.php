<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // Hiển thị danh sách người dùng
public function index()
{
    // Lấy danh sách users kèm permissions, phân trang 10 user mỗi trang
    $users = User::with('permissions')
                 ->orderBy('created_at', 'asc')
                 ->paginate(10);

    return view('admin.users.index', compact('users'));
}


  // Hiển thị form tạo người dùng
  public function create()
  {
      $permissionIds = [1, 2, 3, 4];
      $permissions = Permission::whereIn('id', $permissionIds)->get(); 
      return view('admin.users.create', compact('permissions'));  
  }
  
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email|max:255',
        'password' => 'required|string|min:8',
    ]);

    // Tạo người dùng mới
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);

    // Nếu có quyền được chọn trong form, gán vào
    if ($request->filled('permissions')) {
        $permissions = (array) $request->permissions;
        $user->permissions()->attach($permissions);
    }

    return redirect()->route('users.index')->with('success', 'Người dùng đã được thêm thành công');
}

  
  


public function edit($id)
{

    $user = User::findOrFail($id);
    

    $permissions = Permission::all();
    

    $userPermissions = $user->permissions->pluck('id')->toArray(); 
    
    
    return view('admin.users.edit', compact('user', 'permissions', 'userPermissions'));
}


public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    // Kiểm tra xem người dùng có phải là admin không
    if ($user->isAdmin()) {
        return back()->with(['error' => 'Không thể sửa thông tin tài khoản admin.']);
    }

    // Validate dữ liệu nhập vào
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'permissions' => 'array|nullable',
    ]);

    // Cập nhật thông tin người dùng
    $user->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
    ]);

    // Cập nhật quyền nếu có
    if (isset($validated['permissions'])) {
        $user->permissions()->sync($validated['permissions']);
    } else {
        $user->permissions()->detach();
    }

    return redirect()->route('users.index')->with('success', 'Người dùng đã được cập nhật!');
}



 

public function toggleStatus($id)
{
    $user = User::findOrFail($id);

    // Kiểm tra xem người dùng có phải là admin không
    if ($user->isAdmin()) {
        return back()->with(['error' => 'Không thể khóa tài khoản admin.']);
    }

    // Đảo trạng thái tài khoản (kích hoạt / khóa)
    $user->is_active = !$user->is_active;
    $user->save();

    return redirect()->back()->with('success', 'Trạng thái tài khoản đã được cập nhật!');
}


public function destroy($id)
{
    $user = User::findOrFail($id);

    // Kiểm tra đơn hàng đang xử lý
    $hasProcessingOrders = DB::table('order')
        ->where('user_id', $id)
        ->where('order_status', 'pending') 
        ->exists();

    if ($hasProcessingOrders) {
        return redirect()->route('users.index')
            ->with('error', 'Không thể xóa người dùng đang có đơn hàng đang xử lý!');
    }

    // Xóa quyền người dùng
    DB::table('users_permissions')->where('user_id', $id)->delete();

    // Xóa người dùng
    $user->delete();

    return redirect()->route('users.index')->with('success', 'Người dùng và quyền đã được xóa!');
}
    
}
