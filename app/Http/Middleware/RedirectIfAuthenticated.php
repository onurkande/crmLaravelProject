<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->user_type === 'admin' || Auth::user()->user_type === 'sales_consultant') {
                return redirect()->route('admin.dashboard')->with('error', 'Zaten giriş yapmış durumdasınız.');
            }elseif(Auth::user()->user_type === 'agency'){
                return redirect()->route('admin.advertisements.index')->with('error', 'Zaten giriş yapmış durumdasınız.');
            }
        }

        return $next($request);
    }
}
