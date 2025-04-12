<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Lütfen giriş yapın.');
        }

        $user = Auth::user();

        // Eğer kullanıcı yetkili rollerden birine sahipse devam et
        if (in_array($user->user_type, $roles)) {
            return $next($request);
        }

        return redirect()->route('admin.dashboard')->with('error', 'Bu sayfaya erişim yetkiniz yok.');
    }
}
