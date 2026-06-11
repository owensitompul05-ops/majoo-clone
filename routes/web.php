<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EmployeeController; // <-- Tambahan baris ini agar rute employees aktif sempurna

Route::get('/', function () {
    return view('welcome');
});

// Route otomatis untuk CRUD Produk (Index, Create, Store, Edit, Update, Destroy)
Route::resource('products', ProductController::class);

// Jalur untuk menampilkan halaman kasir POS
Route::get('transactions', [ProductController::class, 'posIndex'])->name('transactions.index');

// Jalur untuk memproses simpan transaksi dan potong stok
Route::post('transactions', [ProductController::class, 'posStore'])->name('transactions.store');

// Jalur untuk menampilkan halaman struk berdasarkan ID Transaksi
Route::get('transactions/{id}/print', [ProductController::class, 'posPrint'])->name('transactions.print');

// Jalur untuk menampilkan halaman laporan penjualan / dashboard admin
Route::get('reports', [ProductController::class, 'reportIndex'])->name('reports.index');

// Jalur CRUD Manajemen Karyawan
Route::resource('employees', EmployeeController::class);