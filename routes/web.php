<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AccountManagementController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [LoginController::class, 'register']);
});

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/dashboard/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/dashboard/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
    
    // Administrator-only routes
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard/accounts', [AccountManagementController::class, 'index'])->name('admin.accounts');
        Route::post('/dashboard/accounts/{user}/toggle', [AccountManagementController::class, 'toggleStatus'])->name('admin.accounts.toggle');
    });
});

