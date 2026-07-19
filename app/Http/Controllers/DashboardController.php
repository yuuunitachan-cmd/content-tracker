<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SumberKonten;
use App\Models\JenisKonten;
use App\Models\Postingan;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data untuk Grafik (Menghitung jumlah postingan per Sumber Konten)
        // Pastikan model SumberKonten memiliki relasi hasMany ke model Postingan
        $sumberKonten = SumberKonten::withCount('postingan')->get();
        
        // Memisahkan data untuk Sumbu X (Labels) dan Sumbu Y (Values/Data)
        // Sudah disesuaikan menjadi 'nama' berdasarkan file migration-mu
        $grafikLabels = $sumberKonten->pluck('nama'); 
        $grafikData = $sumberKonten->pluck('postingan_count');

        // 2. Ambil data ringkasan untuk kartu informasi di atas grafik
        $totalPostingan = Postingan::count();
        $totalSumber = SumberKonten::count();
        $totalJenis = JenisKonten::count();

        // Kirim semua variabel ke view 'dashboard'
        return view('dashboard', compact(
            'grafikLabels', 
            'grafikData', 
            'totalPostingan', 
            'totalSumber', 
            'totalJenis'
        ));
    }
}