<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', [UserController::class, 'index']);
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'authenticate'])->name('login.authenticate');
Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

