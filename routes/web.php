<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengambilanController;

use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\PemesananController;
use App\Http\Controllers\User\ProdukController as UserProdukController;

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

    Route::get('/dashboard/admin', [
        DashboardController::class,
        'index'
    ])->name('admin.dashboard');

});

Route::get('/admin/stok', [StokController::class, 'index'])
    ->middleware('auth')
    ->name('admin.stok');

Route::get('/admin/stok/{id}/edit', [StokController::class, 'edit'])
    ->middleware('auth')
    ->name('admin.stok.edit');

Route::put('/admin/stok/{id}', [StokController::class, 'update'])
    ->middleware('auth')
    ->name('admin.stok.update');

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/pembayaran', [
        PembayaranController::class,
        'index'
    ])->name('admin.pembayaran');

    Route::post('/admin/pembayaran/{id}/konfirmasi', [
        PembayaranController::class,
        'konfirmasi'
    ])->name('admin.pembayaran.konfirmasi');

    Route::post('/admin/pembayaran/{id}/tolak', [
        PembayaranController::class,
        'tolak'
    ])->name('admin.pembayaran.tolak');

});

Route::get('/admin/produk', [ProdukController::class, 'index'])
    ->middleware('auth')
    ->name('admin.produk');

Route::get('/admin/produk/{id}/edit', [ProdukController::class, 'edit'])
    ->middleware('auth')
    ->name('admin.produk.edit');

Route::put('/admin/produk/{id}', [ProdukController::class, 'update'])
    ->middleware('auth')
    ->name('admin.produk.update');

Route::get('/admin/riwayat', [
    RiwayatController::class,
    'index'
])
->middleware(['auth', 'role:admin'])
->name('admin.riwayat');

Route::get('/admin/riwayat/cetak', [RiwayatController::class, 'cetak'])
    ->middleware('auth')
    ->name('admin.riwayat.cetak');

Route::get('/admin/pengguna', [PenggunaController::class, 'index'])
    ->middleware('auth')
    ->name('admin.pengguna');

Route::get('/admin/pengguna/edit/{id}', [PenggunaController::class, 'edit'])
    ->name('admin.pengguna.edit');

Route::put('/admin/pengguna/{id}', [PenggunaController::class, 'update'])
    ->name('admin.pengguna.update');

Route::get('/admin/produk/create', function () {
    return view('admin.create');
})->name('admin.produk.create');

Route::post('/admin/produk', [ProdukController::class, 'store'])
    ->middleware('auth')
    ->name('admin.produk.store');

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/pesanan', [
        PengambilanController::class,
        'index'
    ])->name('admin.pesanan');

    Route::post('/admin/pesanan/{id}/konfirmasi-pengambilan', [
        PengambilanController::class,
        'konfirmasi'
    ])->name('admin.pesanan.konfirmasi-pengambilan');

});

Route::middleware(['auth', 'role:kasir'])->group(function () {

    Route::get('/kasir/pesanan', [
        PengambilanController::class,
        'index'
    ])->name('kasir.pesanan');

    Route::post('/kasir/pesanan/{id}/konfirmasi-pengambilan', [
        PengambilanController::class,
        'konfirmasi'
    ])->name('kasir.pesanan.konfirmasi-pengambilan');

});


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

    Route::get('/dashboard/user', [
        UserDashboardController::class,
        'index'
    ])->name('user.dashboard');

});

Route::middleware(['auth', 'role:user'])->group(function () {

    Route::get('/dashboard/user', [
        UserDashboardController::class,
        'index'
    ])->name('user.dashboard');

    Route::get('/user/profile', [
        ProfileController::class,
        'index'
    ])->name('user.profile');

    Route::put('/user/profile', [
        ProfileController::class,
        'update'
    ])->name('user.profile.update');

});

Route::post('/logout', function (Request $request) {

    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/login');

})->middleware('auth')->name('logout');

Route::middleware(['auth', 'role:user'])->group(function () {

    Route::get('/pemesanan-bbm', [
        PemesananController::class,
        'create'
    ])->name('user.pemesanan');

    Route::post('/pemesanan-bbm', [
        PemesananController::class,
        'store'
    ])->name('user.pemesanan.store');

});

Route::middleware(['auth', 'role:user'])->group(function () {

    Route::get('/user/produk-stok', [
        UserProdukController::class,
        'index'
    ])->name('user.produk.stok');

});