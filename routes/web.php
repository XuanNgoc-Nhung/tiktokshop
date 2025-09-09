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

Route::group(['prefix' => 'admin', 'middleware' => ['language.admin']], function () {
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::get('/register', [AdminController::class, 'register'])->name('admin.register');
    Route::post('/register', [AdminController::class, 'registerStore'])->name('admin.register.store');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.login.authenticate');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});

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

