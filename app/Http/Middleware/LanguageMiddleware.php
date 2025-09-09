<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\LanguageHelper;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $type = 'user')
    {
        // Get language from session or request
        $locale = $request->session()->get('language', $request->get('lang', 'vi'));
        
        // Validate locale
        if (!LanguageHelper::isSupported($locale)) {
            $locale = 'vi'; // Default to Vietnamese
        }
        
        // Set the application locale
        app()->setLocale($locale);
        
        // Store the language type (admin or user) in the request
        $request->merge(['language_type' => $type]);
        
        return $next($request);
    }
}
