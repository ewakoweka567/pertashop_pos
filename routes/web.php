<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;

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

Route::get('/admin/stok', function () {
    return view('admin.stok');
})->middleware('auth');

Route::get('/admin/pembayaran', function () {
    return view('admin.pembayaran');
})->middleware('auth');

Route::get('/admin/produk', [ProdukController::class, 'index'])
    ->middleware('auth')
    ->name('admin.produk');

Route::get('/admin/pengguna', function () {
    return view('admin.pengguna');
})->middleware('auth');

Route::get('/admin/produk/{id}/edit', function ($id) {
    return view('admin.produk-edit', compact('id'));
})->middleware('auth');

Route::get('/admin/stok/{id}/edit', function ($id) {
    return view('admin.stok-edit', compact('id'));
})->middleware('auth');

Route::get('/admin/riwayat', function () {
    return view('admin.riwayat');
})->name('admin.riwayat');

Route::get('/admin/pengguna', function () {
    return view('admin.pengguna');
})->name('admin.pengguna');

Route::get('/admin/pengguna/edit/{id}', function ($id) {
    return view('admin.edit-pengguna');
})->name('admin.pengguna.edit');

Route::get('/admin/produk/create', function () {
    return view('admin.create');
})->name('admin.produk.create');

Route::post('/admin/produk', [ProdukController::class, 'store'])
    ->middleware('auth')
    ->name('admin.produk.store');

// =======================
// Dashboard Kasir
// =======================

Route::middleware(['auth', 'role:kasir'])->group(function () {

    Route::get('/dashboard/kasir', function () {
        return view('dashboard.kasir');
    });

    Route::get('/dashboard/kasir/pos', function () {
        return view('kasir.pos');
    })->name('kasir.pos');

});

// =======================
// Dashboard User
// =======================

Route::middleware(['auth', 'role:user'])->group(function () {

    Route::get('/dashboard/user', function () {
        return view('dashboard.user');
    });

});
