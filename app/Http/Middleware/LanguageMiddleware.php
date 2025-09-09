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
        // Get language from session or request based on type
        if ($type === 'admin') {
            $locale = $request->session()->get('admin_locale', $request->get('lang', 'vi'));
        } else {
            $locale = $request->session()->get('language', $request->get('lang', 'vi'));
        }
        
        // Validate locale
        if (!LanguageHelper::isSupported($locale)) {
            $locale = 'vi'; // Default to Vietnamese
        }
        
        // Set the application locale
        app()->setLocale($locale);
        
        // Debug for admin
        if ($type === 'admin') {
            \Log::info('LanguageMiddleware Admin', [
                'type' => $type,
                'locale' => $locale,
                'session_admin_locale' => $request->session()->get('admin_locale'),
                'app_locale' => app()->getLocale(),
                'url' => $request->url(),
                'request_method' => $request->method()
            ]);
        }
        
        // Store the language type (admin or user) in the request
        $request->merge(['language_type' => $type]);
        
        return $next($request);
    }
}
