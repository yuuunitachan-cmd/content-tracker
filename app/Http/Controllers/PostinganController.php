<?php

namespace App\Http\Controllers;

use App\Models\Postingan;
use Illuminate\Http\Request;
use Carbon\Carbon; // Wajib dipanggil untuk manipulasi waktu

class PostinganController extends Controller
{
    /**
     * Method untuk memuat halaman utama (Dashboard + Tabel Data)
     */
    public function dashboard(Request $request)
    {
        // 1. Ambil parameter 'filter' dari URL (default: 'bulan')
        $filter = $request->query('filter', 'bulan'); 
        
        // 2. Siapkan query dasar dengan relasi agar pemuatan data lebih cepat (Eager Loading)
        $query = Postingan::with(['jenisKonten', 'sumberKonten']);
        $now = Carbon::now(); 

        // 3. Logika Filter Waktu
        switch ($filter) {
            case 'hari':
                $query->whereDate('created_at', $now->format('Y-m-d'));
                $label_waktu = "Hari Ini";
                break;
            case 'minggu':
                $query->whereBetween('created_at', [$now->startOfWeek()->format('Y-m-d'), $now->endOfWeek()->format('Y-m-d')]);
                $label_waktu = "Minggu Ini";
                break;
            case 'tahun':
                $query->whereYear('created_at', $now->year);
                $label_waktu = "Tahun Ini";
                break;
            case 'bulan':
            default:
                $query->whereMonth('created_at', $now->month)
                      ->whereYear('created_at', $now->year);
                $label_waktu = "Bulan Ini";
                break;
        }

        // 4. Eksekusi query, urutkan dari data paling baru
        $postingan = $query->latest()->get();

        // 5. Hitung Statistik
        $total_konten = $postingan->count();
        $total_foto = $postingan->where('jenis_konten_id', 1)->count(); // ID 1 = Foto
        $total_video = $postingan->where('jenis_konten_id', 2)->count(); // ID 2 = Video

        return view('dashboard', compact('postingan', 'filter', 'label_waktu', 'total_konten', 'total_foto', 'total_video'));
    }

    /**
     * Karena kita menggunakan route resource dan dashboard menampilkan halaman yang sama,
     * method index diarahkan ke method dashboard.
     */
    public function index(Request $request)
    {
        return $this->dashboard($request);
    }

    /**
     * Menampilkan form untuk menambah data baru.
     */
    public function create()
    {
        return view('postingan.create');
    }

    /**
     * Menyimpan data baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi data yang masuk dari form
        $request->validate([
            'judul' => 'required|string|max:255',
            'link' => 'required|url',
            'jenis_konten_id' => 'required|integer',
            'sumber_konten_id' => 'required|integer',
            'tagar' => 'nullable|string|max:255',
        ]);

        // Simpan ke database
        Postingan::create($request->all());

        // Redirect kembali ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Data konten berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit data.
     */
    public function edit(Postingan $postingan)
    {
        return view('postingan.edit', compact('postingan'));
    }

    /**
     * Menyimpan perubahan data ke database.
     */
    public function update(Request $request, Postingan $postingan)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'link' => 'required|url',
            'jenis_konten_id' => 'required|integer',
            'sumber_konten_id' => 'required|integer',
            'tagar' => 'nullable|string|max:255',
        ]);

        $postingan->update($request->all());

        return redirect()->route('dashboard')->with('success', 'Data konten berhasil diperbarui!');
    }

    /**
     * Menghapus data dari database.
     */
    public function destroy(Postingan $postingan)
    {
        $postingan->delete();

        return redirect()->route('dashboard')->with('success', 'Data konten berhasil dihapus!');
    }
}