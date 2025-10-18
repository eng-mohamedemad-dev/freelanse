<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // التحقق من تسجيل الدخول
        if (!Auth::check()) {
            return redirect()->route('admin.login')
                ->with('error', __('admin.login_first'));
        }

        // التحقق من دور المدير
        if (!Auth::user()->isAdmin()) {
            Auth::logout();
            
            return redirect()->route('admin.login')
                ->with('error', __('admin.no_permission'));
        }

        return $next($request);
    }
}
