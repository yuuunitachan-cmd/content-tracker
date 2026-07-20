<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SumberKonten;
use App\Models\JenisKonten;
use App\Models\Postingan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $date_mode = $request->query('date_mode', 'hari');
        $selected_date = $request->query('date', now()->toDateString());
        $selected_month = $request->query('month', now()->format('Y-m'));
        $selected_year = $request->query('year', now()->format('Y'));
        $start_date = $request->query('start_date', now()->subDays(6)->toDateString());
        $end_date = $request->query('end_date', now()->toDateString());

        if ($date_mode === 'hari') {
            $start = now()->parse($selected_date)->startOfDay();
            $end = now()->parse($selected_date)->endOfDay();
        } elseif ($date_mode === 'bulan') {
            $start = now()->parse($selected_month . '-01')->startOfMonth();
            $end = now()->parse($selected_month . '-01')->endOfMonth();
        } elseif ($date_mode === 'tahun') {
            $start = now()->parse($selected_year . '-01-01')->startOfDay();
            $end = now()->parse($selected_year . '-12-31')->endOfDay();
        } elseif ($date_mode === 'rentang') {
            $start = now()->parse($start_date)->startOfDay();
            $end = now()->parse($end_date)->endOfDay();
        } else {
            $date_mode = 'hari';
            $start = now()->startOfDay();
            $end = now()->endOfDay();
        }

        $postinganQuery = Postingan::with(['jenisKonten', 'sumberKonten'])->latest();
        $summaryQuery = Postingan::query();

        $postinganQuery->whereBetween('created_at', [$start, $end]);
        $summaryQuery->whereBetween('created_at', [$start, $end]);

        $postingan = $postinganQuery->paginate(20);
        $total_konten = (clone $summaryQuery)->count();
        $total_foto = (clone $summaryQuery)->where('jenis_konten_id', 1)->count();
        $total_video = (clone $summaryQuery)->where('jenis_konten_id', 2)->count();

        // Chart data: count per day within range
        $rows = DB::table('postingan')
            ->selectRaw("DATE(created_at) as date, COUNT(*) as total")
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = $rows->pluck('date')->map(function ($d) { return date('Y-m-d', strtotime($d)); })->toArray();
        $chartData = $rows->pluck('total')->toArray();

        $label_waktu = match ($date_mode) {
            'hari' => now()->parse($selected_date)->translatedFormat('d F Y'),
            'bulan' => now()->parse($selected_month . '-01')->translatedFormat('F Y'),
            'tahun' => $selected_year,
            'rentang' => now()->parse($start_date)->translatedFormat('d F Y').' - '.now()->parse($end_date)->translatedFormat('d F Y'),
            default => now()->translatedFormat('d F Y'),
        };

        return view('dashboard', compact(
            'postingan',
            'total_konten',
            'total_foto',
            'total_video',
            'label_waktu',
            'chartLabels',
            'chartData',
            'date_mode',
            'selected_date',
            'selected_month',
            'selected_year',
            'start_date',
            'end_date'
        ));
    }
}