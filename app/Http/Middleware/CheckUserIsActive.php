<?php 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserIsActive
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->is_active) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Tài khoản của bạn đã bị khóa.'
            ]);
        }

        return $next($request);
    }
}
