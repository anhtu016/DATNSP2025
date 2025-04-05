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
        $users = User::orderBy('created_at', 'asc')->get(); // Hiển thị theo thứ tự tăng dần
        $users = User::with('permissions')->get();
        return view('admin.users.index', compact('users'));
    }

  // Hiển thị form tạo người dùng
  public function create()
  {
      $permissionIds = [1, 2];  // Mảng chứa các ID quyền bạn muốn lấy
      $permissions = Permission::whereIn('id', $permissionIds)->get();  // Lấy quyền với ID trong mảng
      return view('admin.users.create', compact('permissions'));  // Truyền quyền vào view
  }
  

  // Lưu người dùng mới
  public function store(Request $request)
  {
      // Tạo người dùng mới
      $user = User::create([

          'name' => $request->name,

          'email' => $request->email,

          'password' => bcrypt($request->password),

      ]);
  
   
      if ($request->has('permissions')) {

          $user->permissions()->attach($request->permissions);  // Hoặc sử dụng sync nếu muốn thay thế quyền cũ
      }
  
      return redirect()->route('users.index')->with('success', 'Người dùng đã được thêm thành công');
  }
  
  

    // Hiển thị form chỉnh sửa người dùng
    public function edit($id)
    {
        // Tìm người dùng theo id
        $user = User::findOrFail($id);
    
        // Lấy tất cả quyền
        $permissions = Permission::all();
    
        // Lấy quyền hiện tại của người dùng
        $userPermissions = $user->permissions->pluck('id')->toArray();  // Chỉ lấy các ID quyền
    
        return view('admin.users.edit', compact('user', 'permissions', 'userPermissions'));
    }
    

    // Cập nhật người dùng
    public function update(Request $request, $id)
    {
        // Tìm người dùng theo id
        $user = User::findOrFail($id);
    
        // Xác thực dữ liệu đầu vào
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'permissions' => 'array|nullable', // Quyền có thể là mảng
        ]);
    
        // Cập nhật thông tin người dùng
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);
    
        // Cập nhật quyền cho người dùng
        // Nếu có quyền được chọn, gán lại quyền cho người dùng
        if (isset($validated['permissions'])) {
            // Xóa quyền cũ của người dùng
            $user->permissions()->sync($validated['permissions']); // Cập nhật quyền cho người dùng
        } else {
            // Nếu không có quyền nào được chọn, xóa hết quyền của người dùng
            $user->permissions()->detach();
        }
    
        // Quay lại danh sách người dùng với thông báo thành công
        return redirect()->route('users.index')->with('success', 'Người dùng đã được cập nhật!');
    }
    
    

 
    public function destroy($id)
    {
   
        $user = User::findOrFail($id);
        
        DB::table('users_permissions')->where('user_id', $id)->delete();
        
        $user->delete();
        
        return redirect()->route('users.index')->with('success', 'Người dùng và quyền đã được xóa!');
    }
    
    
}
