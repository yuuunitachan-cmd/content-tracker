<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostinganController; // Import PostinganController
use Illuminate\Support\Facades\Route;

// Redirect dari halaman utama langsung ke dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

// Route untuk memuat halaman Dashboard beserta datanya
Route::get('/dashboard', [PostinganController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Kumpulan route yang membutuhkan login (auth)
Route::middleware('auth')->group(function () {
    // Route bawaan Laravel Breeze untuk Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Route Resource untuk meng-handle semua fungsi CRUD Postingan (index, create, store, edit, update, destroy)
    Route::resource('postingan', PostinganController::class);
});

require __DIR__.'/auth.php';