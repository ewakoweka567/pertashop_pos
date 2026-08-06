<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// =======================
// Landing Page
// =======================

Route::get('/', function () {
    return view('pages.landing');
});

// =======================
// Login
// =======================

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);

// =======================
// Register
// =======================

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store']);

// =======================
// Dashboard Admin
// =======================

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard/admin', function () {
        return view('dashboard.admin');
    });

});

// =======================
// Dashboard Kasir
// =======================

Route::middleware(['auth', 'role:kasir'])->group(function () {

    Route::get('/dashboard/kasir', function () {
        return view('dashboard.kasir');
    });

});

// =======================
// Dashboard User
// =======================

Route::middleware(['auth', 'role:user'])->group(function () {

    Route::get('/dashboard/user', function () {
        return view('dashboard.user');
    });

});