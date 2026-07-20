<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PostinganAggregateExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = DB::table('postingan')
            ->join('sumber_konten', 'postingan.sumber_konten_id', '=', 'sumber_konten.id')
            ->join('jenis_konten', 'postingan.jenis_konten_id', '=', 'jenis_konten.id')
            ->selectRaw('YEAR(postingan.created_at) as year, MONTH(postingan.created_at) as month, sumber_konten.nama as sumber, jenis_konten.nama as jenis, COUNT(*) as total')
            ->groupByRaw('YEAR(postingan.created_at), MONTH(postingan.created_at), sumber_konten.id, jenis_konten.id')
            ->orderByRaw('YEAR(postingan.created_at) desc, MONTH(postingan.created_at) desc');

        if (!empty($this->filters['jenis_konten_id'])) {
            $query->where('postingan.jenis_konten_id', $this->filters['jenis_konten_id']);
        }

        if (!empty($this->filters['sumber_konten_id'])) {
            $query->where('postingan.sumber_konten_id', $this->filters['sumber_konten_id']);
        }

        $dateMode = $this->filters['date_mode'] ?? 'hari';
        if ($dateMode === 'hari' && !empty($this->filters['date'])) {
            try {
                $d = Carbon::createFromFormat('d/m/Y', $this->filters['date']);
                $query->whereBetween('postingan.created_at', [$d->startOfDay(), $d->endOfDay()]);
            } catch (\Exception $e) {
                // ignore invalid date
            }
        } elseif ($dateMode === 'bulan' && !empty($this->filters['month'])) {
            try {
                $monthRaw = $this->filters['month'];
                if (preg_match('/^\d{2}\/\d{4}$/', $monthRaw)) {
                    $m = Carbon::createFromFormat('m/Y', $monthRaw);
                } else {
                    $m = Carbon::createFromFormat('Y-m', $monthRaw);
                }
                $query->whereBetween('postingan.created_at', [$m->startOfMonth(), $m->endOfMonth()]);
            } catch (\Exception $e) {
                // ignore invalid month
            }
        } elseif ($dateMode === 'rentang' && !empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            try {
                $s = Carbon::createFromFormat('d/m/Y', $this->filters['start_date']);
                $e = Carbon::createFromFormat('d/m/Y', $this->filters['end_date']);
                $query->whereBetween('postingan.created_at', [$s->startOfDay(), $e->endOfDay()]);
            } catch (\Exception $e) {
                // ignore invalid range
            }
        } elseif ($dateMode === 'tahun' && !empty($this->filters['year'])) {
            $year = $this->filters['year'];
            if (preg_match('/^\d{4}$/', $year)) {
                $query->whereBetween('postingan.created_at', [Carbon::parse($year.'-01-01')->startOfDay(), Carbon::parse($year.'-12-31')->endOfDay()]);
            }
        }

        if (!empty($this->filters['tagar'])) {
            $query->where('postingan.tagar', 'like', '%'.$this->filters['tagar'].'%');
        }

        return $query->get();
    }

    public function headings(): array
    {
        return ['Tahun', 'Bulan', 'Sumber', 'Jenis', 'Jumlah'];
    }
}
