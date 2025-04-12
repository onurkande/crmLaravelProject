<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next)
    {
        $settings = SiteSetting::first();
        
        if ($settings && $settings->maintenance_mode) {
            if (!$request->user() || $request->user()->user_type !== 'admin') {
                return response()->view('maintenance');
            }
        }

        return $next($request);
    }
} 