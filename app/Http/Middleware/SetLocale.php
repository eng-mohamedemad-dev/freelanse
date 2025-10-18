<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Set locale from session
        if (session()->has('locale')) {
            $locale = session('locale');
            app()->setLocale($locale);
            config(['app.locale' => $locale]);
        } else {
            // Default to Arabic
            app()->setLocale('ar');
            config(['app.locale' => 'ar']);
        }
        
        return $next($request);
    }
}
