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
        $users = User::orderBy('created_at', 'asc')->get(); 
        $users = User::with('permissions')->get();
        return view('admin.users.index', compact('users'));
    }

  // Hiển thị form tạo người dùng
  public function create()
  {
      $permissionIds = [1, 2];
      $permissions = Permission::whereIn('id', $permissionIds)->get(); 
      return view('admin.users.create', compact('permissions'));  
  }
  


public function store(Request $request)
{
    
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email|max:255',
        'password' => 'required|string|min:8|confirmed', 
    ]);

    // Tạo người dùng mới
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']), 
    ]);

 
    if (isset($validated['permissions'])) {
        $user->permissions()->attach($validated['permissions']);  
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

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,  
        'permissions' => 'array|nullable',  
    ]);
    

    $user->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
    ]);
    

    if (isset($validated['permissions'])) {

        $user->permissions()->sync($validated['permissions']);
    } else {

        $user->permissions()->detach();
    }

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
