<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

Route::middleware(['language.user'])->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::get('/register', [UserController::class, 'register'])->name('register');
    Route::post('/register', [UserController::class, 'registerStore'])->name('register.store');
    Route::post('/login', [UserController::class, 'authenticate'])->name('login.authenticate');
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});

Route::group(['prefix' => 'admin', 'middleware' => ['language.admin:admin']], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::get('/register', [AdminController::class, 'register'])->name('admin.register');
    Route::post('/register', [AdminController::class, 'registerStore'])->name('admin.register.store');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.login.authenticate');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::post('/change-language', [AdminController::class, 'changeLanguage'])->name('admin.change-language');
});

// Test route for language debugging
Route::get('/admin/test-lang', function() {
    return response()->json([
        'current_locale' => app()->getLocale(),
        'session_admin_locale' => session('admin_locale'),
        'session_language' => session('language'),
        'available_locales' => ['vi', 'en', 'zh', 'ja', 'bn']
    ]);
})->middleware('language.admin:admin')->name('admin.test-lang');

// Simple language change route for admin
Route::post('/admin/set-language', function(\Illuminate\Http\Request $request) {
    $language = $request->input('language');
    
    if (in_array($language, ['vi', 'en', 'zh', 'ja', 'bn'])) {
        session(['admin_locale' => $language]);
        app()->setLocale($language);
        
        return response()->json([
            'success' => true,
            'message' => 'Language set to ' . $language,
            'current_locale' => app()->getLocale()
        ]);
    }
    
    return response()->json([
        'success' => false,
        'message' => 'Invalid language'
    ]);
})->name('admin.set-language');

// Language switching routes
Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'vi', 'ja', 'zh', 'bn'])) {
        session(['language' => $locale]);
    }
    return redirect()->back();
})->name('language.switch');

Route::get('/admin/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'vi', 'ja', 'zh', 'bn'])) {
        session(['language' => $locale]);
    }
    return redirect()->back();
})->name('admin.language.switch');

