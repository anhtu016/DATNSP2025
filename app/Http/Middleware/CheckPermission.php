<?php 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $requiredPermission)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Bạn chưa đăng nhập.');
        }

        if ($user->permissions->contains('permission_name', $requiredPermission) || 
            $user->permissions->contains('permission_name', 'admin')) {
            return $next($request);
        }

        abort(403, 'Bạn không có quyền truy cập.');
    }
}
