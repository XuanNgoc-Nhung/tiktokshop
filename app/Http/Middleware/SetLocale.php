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
        // Only set locale if it hasn't been set by LanguageMiddleware
        if (!app()->getLocale() || app()->getLocale() === 'en') {
            // Get locale from session, default to 'vi'
            $locale = session('language', 'vi');
            
            // Validate locale is supported
            $supportedLocales = ['vi', 'en', 'ja', 'zh', 'bn'];
            if (!in_array($locale, $supportedLocales)) {
                $locale = 'vi'; // fallback to Vietnamese
            }
            
            // Set the application locale
            app()->setLocale($locale);
        }
        
        return $next($request);
    }
}
