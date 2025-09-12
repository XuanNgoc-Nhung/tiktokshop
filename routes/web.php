<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ThongBaoController;
use App\Http\Controllers\SlideShowController;
use App\Http\Controllers\LichSuController;

Route::middleware(['language.user'])->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::get('/register', [UserController::class, 'register'])->name('register');
    Route::post('/register', [UserController::class, 'registerStore'])->name('register.store');
    Route::post('/login', [UserController::class, 'authenticate'])->name('login.authenticate');
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    //notification
    Route::get('/notification', [UserController::class, 'notification'])->name('notification');
    Route::get('/search', [UserController::class, 'search'])->name('search');
    Route::get('/orders', [UserController::class, 'orders'])->name('orders');
    Route::get('/account', [UserController::class, 'account'])->name('account');
    Route::group(['prefix' => 'account'], function () {
        Route::get('/personal-info', [UserController::class, 'personalInfo'])->name('account.personal-info');
        Route::post('/personal-info', [UserController::class, 'personalInfoUpdate'])->name('account.personal-info.update');
        Route::get('/bank', [UserController::class, 'bank'])->name('account.bank');
        Route::post('/bank', [UserController::class, 'bankUpdate'])->name('account.bank.update');
        Route::get('/kyc', [UserController::class, 'kyc'])->name('account.kyc');
        Route::post('/kyc', [UserController::class, 'kycUpdate'])->name('account.kyc.update');
        Route::get('/account-history', [UserController::class, 'accountHistory'])->name('account.account-history');
        Route::get('/order-history', [UserController::class, 'orderHistory'])->name('account.order-history');
        Route::get('/password', [UserController::class, 'password'])->name('account.password');
        Route::post('/password/change-login', [UserController::class, 'changeLoginPassword'])->name('account.password.change-login');
        Route::post('/password/change-transfer', [UserController::class, 'changeTransferPassword'])->name('account.password.change-transfer');
        Route::get('/support', [UserController::class, 'support'])->name('account.support');
        Route::post('/support', [UserController::class, 'supportUpdate'])->name('account.support.update');
    });
});

// Admin routes without authentication check (login, register)
Route::group(['prefix' => 'admin', 'middleware' => ['language.admin:admin']], function () {
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::get('/register', [AdminController::class, 'register'])->name('admin.register');
    Route::post('/register', [AdminController::class, 'registerStore'])->name('admin.register.store');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.login.authenticate');
    //user management
    Route::get('/user-management', [AdminController::class, 'userManagement'])->name('admin.user-management');
    Route::get('/user-management/create', [AdminController::class, 'createUser'])->name('admin.user-management.create');
    Route::post('/user-management/store', [AdminController::class, 'storeUser'])->name('admin.user-management.store');
    Route::put('/user-management/{id}', [AdminController::class, 'updateUser'])->name('admin.user-management.update');
    Route::put('/user-management/{id}/adjust-balance', [AdminController::class, 'adjustBalance'])->name('admin.user-management.adjust-balance');
    Route::delete('/user-management/{id}', [AdminController::class, 'deleteUser'])->name('admin.user-management.delete');
    //product management
    Route::get('/product-management', [ProductController::class, 'productManagement'])->name('admin.product-management');
    Route::get('/product-management/create', [ProductController::class, 'createProduct'])->name('admin.product-management.create');
    Route::post('/product-management/store', [ProductController::class, 'storeProduct'])->name('admin.product-management.store');
    Route::put('/product-management/{id}', [ProductController::class, 'updateProduct'])->name('admin.product-management.update');
    Route::delete('/product-management/{id}', [ProductController::class, 'deleteProduct'])->name('admin.product-management.delete');
    //reward management
    // Route::get('/reward-management', [RewardController::class, 'rewardManagement'])->name('admin.reward-management');
    // thong bao management
    Route::get('/thong-bao-management', [ThongBaoController::class, 'thongBaoManagement'])->name('admin.thong-bao-management');
    Route::get('/thong-bao', [ThongBaoController::class, 'index'])->name('admin.thong-bao.index');
    Route::post('/thong-bao', [ThongBaoController::class, 'store'])->name('admin.thong-bao.store');
    Route::put('/thong-bao/{id}', [ThongBaoController::class, 'update'])->name('admin.thong-bao.update');
    Route::delete('/thong-bao/{id}', [ThongBaoController::class, 'destroy'])->name('admin.thong-bao.destroy');
    Route::patch('/thong-bao/{id}/toggle', [ThongBaoController::class, 'toggleStatus'])->name('admin.thong-bao.toggle');
    // slider management
    Route::get('/slider-management', [SlideShowController::class, 'sliderManagement'])->name('admin.slider-management');
    Route::get('/slider', [SlideShowController::class, 'index'])->name('admin.slider.index');
    Route::post('/slider', [SlideShowController::class, 'store'])->name('admin.slider.store');
    Route::put('/slider/{id}', [SlideShowController::class, 'update'])->name('admin.slider.update');
    Route::delete('/slider/{id}', [SlideShowController::class, 'destroy'])->name('admin.slider.destroy');
    Route::patch('/slider/{id}/toggle', [SlideShowController::class, 'toggleStatus'])->name('admin.slider.toggle');
    // lich su management
    Route::get('/lich-su-management', [LichSuController::class, 'lichSuManagement'])->name('admin.lich-su-management');
    Route::get('/lich-su', [LichSuController::class, 'index'])->name('admin.lich-su.index');
    Route::post('/lich-su', [LichSuController::class, 'store'])->name('admin.lich-su.store');
    Route::put('/lich-su/{id}', [LichSuController::class, 'update'])->name('admin.lich-su.update');
    Route::delete('/lich-su/{id}', [LichSuController::class, 'destroy'])->name('admin.lich-su.destroy');
    Route::patch('/lich-su/{id}/toggle', [LichSuController::class, 'toggleStatus'])->name('admin.lich-su.toggle');
});

// Admin routes with authentication check
Route::group(['prefix' => 'admin', 'middleware' => ['language.admin:admin', 'checkAdmin']], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    // Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
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
        session(['admin_locale' => $locale]);
    }
    return redirect()->back();
})->name('admin.language.switch');


