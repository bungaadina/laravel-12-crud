<?php

use Illuminate\Support\Facades\Route;

// Import Product Controller
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Route Khusus Eksport PDF (Wajib di atas Resource agar tidak bentrok)
Route::get('/products/export-pdf', [ProductController::class, 'exportPdf'])->name('products.export-pdf');

// 2. Route Resource untuk CRUD Produk (Index, Create, Store, Show, Edit, Update, Destroy)
Route::resource('/products', ProductController::class);

// 3. Route Halaman Utama Welcoming Laravel
Route::get('/', function () {
    return view('welcome');
});