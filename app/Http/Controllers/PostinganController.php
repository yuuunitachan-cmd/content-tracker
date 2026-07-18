<?php

namespace App\Http\Controllers;

use App\Models\Postingan;
use App\Models\JenisKonten;
use App\Models\SumberKonten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostinganController extends Controller
{
    public function index()
    {
        $postingan = Postingan::with(['jenisKonten', 'sumberKonten'])
                               ->latest()
                               ->paginate(20);
        
        return view('postingan.index', compact('postingan'));
    }

    public function create()
    {
        $jenisKonten = JenisKonten::all();
        $sumberKonten = SumberKonten::all();
        
        return view('postingan.create', compact('jenisKonten', 'sumberKonten'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'link' => 'required|url|unique:postingan,link',
            'judul' => 'required|string|max:255',
            'jenis_konten_id' => 'required|exists:jenis_konten,id',
            'sumber_konten_id' => 'required|exists:sumber_konten,id',
            'hashtag' => 'nullable|string',
        ]);
        
        Postingan::create([
            ...$validated,
            'user_id' => Auth::id(),
        ]);
        
        return redirect()->route('postingan.index')
                        ->with('success', 'Data postingan berhasil disimpan');
    }

    public function edit(Postingan $postingan)
    {
        $jenisKonten = JenisKonten::all();
        $sumberKonten = SumberKonten::all();
        
        return view('postingan.edit', compact('postingan', 'jenisKonten', 'sumberKonten'));
    }

    public function update(Request $request, Postingan $postingan)
    {
        $validated = $request->validate([
            'link' => 'required|url|unique:postingan,link,' . $postingan->id,
            'judul' => 'required|string|max:255',
            'jenis_konten_id' => 'required|exists:jenis_konten,id',
            'sumber_konten_id' => 'required|exists:sumber_konten,id',
            'hashtag' => 'nullable|string',
        ]);
        
        $postingan->update($validated);
        
        return redirect()->route('postingan.index')
                        ->with('success', 'Data postingan berhasil diupdate');
    }

    public function destroy(Postingan $postingan)
    {
        $postingan->delete();
        
        return redirect()->route('postingan.index')
                        ->with('success', 'Data postingan berhasil dihapus');
    }

public function dashboard()
{
    $filter = request('filter', 'semua');
    
    $query = Postingan::with(['jenisKonten', 'sumberKonten']);
    
    if ($filter !== 'semua' && is_numeric($filter)) {
        $query->where('jenis_konten_id', $filter);
    }
    
    $postingan = $query->latest()->paginate(20);
    
    $totalKonten = Postingan::count();
    $fotoCount = Postingan::where('jenis_konten_id', 1)->count();
    $videoCount = Postingan::where('jenis_konten_id', 2)->count();
    $infografikCount = Postingan::where('jenis_konten_id', 3)->count();
    $flyerCount = Postingan::where('jenis_konten_id', 4)->count();
    
    return view('dashboard', compact(
        'postingan',
        'totalKonten',
        'fotoCount',
        'videoCount',
        'infografikCount',
        'flyerCount',
        'filter'
    ));

    }
}