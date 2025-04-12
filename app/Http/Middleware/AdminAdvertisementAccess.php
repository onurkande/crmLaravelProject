<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminAdvertisementAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Eğer kullanıcı admin değilse ve ilan satıldıysa, erişimi engelle
        if ($user->user_type !== 'admin' && $request->advertisement->sale_status === 'Satıldı') {
            abort(403, 'Bu ilana erişim izniniz yok.');
        }

        return $next($request);
    }
}
