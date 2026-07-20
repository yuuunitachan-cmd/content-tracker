<?php

namespace App\Http\Controllers;

use App\Models\Postingan;
use App\Models\JenisKonten;
use App\Models\SumberKonten;
use App\Exports\PostinganExport;
use App\Exports\PostinganAggregateExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostinganController extends Controller
{
    public function index(Request $request)
    {
        $jenisKonten = JenisKonten::all();
        $sumberKonten = SumberKonten::all();

        $baseQuery = $this->buildFilteredQuery($request);
        $query = (clone $baseQuery)->latest();

        // compute totals for summary (clone query to avoid interfering with pagination)
        $totalCount = (clone $query)->count();
        $countsBySumber = (clone $query)
                            ->reorder() // remove any existing ORDER BY
                            ->select('sumber_konten_id', DB::raw('count(*) as total'))
                            ->groupBy('sumber_konten_id')
                            ->get()
                            ->mapWithKeys(function ($row) use ($sumberKonten) {
                                $name = optional($sumberKonten->firstWhere('id', $row->sumber_konten_id))->nama ?? 'Unknown';
                                return [$name => $row->total];
                            });

        $countsByJenis = (clone $query)
                            ->reorder()
                            ->select('jenis_konten_id', DB::raw('count(*) as total'))
                            ->groupBy('jenis_konten_id')
                            ->get()
                            ->mapWithKeys(function ($row) {
                                $name = optional(JenisKonten::find($row->jenis_konten_id))->nama ?? 'Unknown';
                                return [$name => $row->total];
                            });

        $postingan = $query->paginate(20)->appends($request->query());

        return view('postingan.index', compact('postingan', 'jenisKonten', 'sumberKonten', 'totalCount', 'countsBySumber', 'countsByJenis'));
    }

    /**
     * Build a filtered Postingan query from request parameters so listing and exports stay aligned.
     */
    protected function buildFilteredQuery(Request $request)
    {
        $query = Postingan::with(['jenisKonten', 'sumberKonten']);

        if ($request->filled('jenis_konten_id')) {
            $query->where('jenis_konten_id', $request->query('jenis_konten_id'));
        }

        if ($request->filled('sumber_konten_id')) {
            $query->where('sumber_konten_id', $request->query('sumber_konten_id'));
        }

        $dateMode = $request->query('date_mode', 'hari');
        if ($dateMode === 'hari' && $request->filled('date')) {
            try {
                $d = Carbon::createFromFormat('d/m/Y', $request->query('date'));
                $query->whereBetween('created_at', [$d->startOfDay(), $d->endOfDay()]);
            } catch (\Exception $e) {
                // ignore invalid date
            }
        } elseif ($dateMode === 'bulan' && $request->filled('month')) {
            try {
                $monthRaw = $request->query('month');
                if (preg_match('/^\d{2}\/\d{4}$/', $monthRaw)) {
                    $m = Carbon::createFromFormat('m/Y', $monthRaw);
                } else {
                    $m = Carbon::createFromFormat('Y-m', $monthRaw);
                }
                $query->whereBetween('created_at', [$m->startOfMonth(), $m->endOfMonth()]);
            } catch (\Exception $e) {
                // ignore invalid month
            }
        } elseif ($dateMode === 'rentang' && $request->filled('start_date') && $request->filled('end_date')) {
            try {
                $s = Carbon::createFromFormat('d/m/Y', $request->query('start_date'));
                $e = Carbon::createFromFormat('d/m/Y', $request->query('end_date'));
                $query->whereBetween('created_at', [$s->startOfDay(), $e->endOfDay()]);
            } catch (\Exception $e) {
                // ignore invalid range
            }
        } elseif ($dateMode === 'tahun' && $request->filled('year')) {
            $year = $request->query('year');
            if (preg_match('/^\d{4}$/', $year)) {
                $query->whereBetween('created_at', [Carbon::parse($year.'-01-01')->startOfDay(), Carbon::parse($year.'-12-31')->endOfDay()]);
            }
        }

        if ($request->filled('tagar')) {
            $query->where('tagar', 'like', '%'.$request->query('tagar').'%');
        }

        return $query;
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
            'tagar' => 'nullable|string',
        ]);
        // validated already contains 'tagar' from the form

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
            'tagar' => 'nullable|string',
        ]);
        // validated already contains 'tagar' from the form

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

    /**
     * Export postingan to Excel with the same filters as the list.
     */
    public function exportExcel(Request $request)
    {
        $filters = $request->only([
            'jenis_konten_id',
            'sumber_konten_id',
            'date_mode',
            'date',
            'month',
            'year',
            'start_date',
            'end_date',
            'tagar',
        ]);

        $fileName = 'postingan_export_'.now()->format('Ymd_His').'.xlsx';

        return Excel::download(new PostinganExport($filters), $fileName);
    }

    public function exportAggregate(Request $request)
    {
        $filters = $request->only([
            'jenis_konten_id',
            'sumber_konten_id',
            'date_mode',
            'date',
            'month',
            'year',
            'start_date',
            'end_date',
            'tagar',
        ]);

        $fileName = 'postingan_aggregate_'.now()->format('Ymd_His').'.xlsx';

        return Excel::download(new PostinganAggregateExport($filters), $fileName);
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