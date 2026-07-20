<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostinganController; // Import PostinganController[cite: 4]
use App\Http\Controllers\DashboardController; // Tambah import agar kode lebih bersih
use Illuminate\Support\Facades\Route;

// Redirect dari halaman utama langsung ke dashboard[cite: 4]
Route::get('/', function () {
    return redirect('/dashboard');
});

// Route untuk memuat halaman Dashboard beserta datanya[cite: 4]
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Kumpulan route yang membutuhkan login (auth)[cite: 4]
Route::middleware('auth')->group(function () {
    // Route bawaan Laravel Breeze untuk Profile[cite: 4]
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // ROUTE TAMBAHAN: Proses ekspor data ke Excel (Wajib di atas Route::resource)
    Route::get('/postingan/export/excel', [PostinganController::class, 'exportExcel'])->name('postingan.export');
    Route::get('/postingan/export/aggregate', [PostinganController::class, 'exportAggregate'])->name('postingan.export.aggregate');

    // Route Resource untuk meng-handle semua fungsi CRUD Postingan (index, create, store, edit, update, destroy)[cite: 4]
    Route::resource('postingan', PostinganController::class);
});

require __DIR__.'/auth.php';