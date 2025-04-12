<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !in_array(Auth::user()->user_type, ['admin', 'agency','sales_consultant'])) {
            return redirect()->route('login')->with('error', 'Bu sayfaya erişim yetkiniz yok.');
        }

        return $next($request);
    }
} 