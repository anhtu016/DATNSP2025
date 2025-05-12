<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Staff
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user(); 

        if ($user && $user->permissions->contains('permission_name', 'staff'))  {
            return $next($request);
        }

        abort(403, 'Bạn không có quyền truy cập trang này.');
    }
}
