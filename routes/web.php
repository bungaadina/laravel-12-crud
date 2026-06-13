<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

// ============================================================
// ROUTE UMUM (BISA DIAKSES SIAPA SAJA: SUDAH/BELUM LOGIN)
// ============================================================
Route::get('/', function () {
    return view('welcome');
});

// ============================================================
// ROUTE YANG HANYA BISA DIAKSES OLEH TAMU (BELUM LOGIN)
// ============================================================
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ============================================================
// ROUTE YANG WAJIB LOGIN TERLEBIH DAHULU (MENGGUNAKAN AUTH)
// ============================================================
Route::middleware('auth')->group(function () {
    
    // Alihkan rute /dashboard langsung ke daftar produk
    Route::get('/dashboard', function () {
        return redirect()->route('products.index');
    })->name('dashboard');

    // Fitur Cetak PDF (Wajib berada di atas Route::resource)
    Route::get('/products/export-pdf', [ProductController::class, 'exportPdf'])->name('products.export-pdf');

    // Semua Fitur CRUD Produk (Index, Create, Store, Show, Edit, Update, Destroy)
    Route::resource('products', ProductController::class);

    // Proses Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});