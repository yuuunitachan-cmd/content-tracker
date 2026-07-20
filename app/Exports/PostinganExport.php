<?php

namespace App\Exports;

use App\Models\Postingan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PostinganExport implements FromQuery, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Postingan::with(['jenisKonten', 'sumberKonten']);

        if (!empty($this->filters['jenis_konten_id'])) {
            $query->where('jenis_konten_id', $this->filters['jenis_konten_id']);
        }

        if (!empty($this->filters['sumber_konten_id'])) {
            $query->where('sumber_konten_id', $this->filters['sumber_konten_id']);
        }

        $dateMode = $this->filters['date_mode'] ?? 'hari';
        if ($dateMode === 'hari' && !empty($this->filters['date'])) {
            try {
                $d = Carbon::createFromFormat('d/m/Y', $this->filters['date']);
                $query->whereBetween('created_at', [$d->startOfDay(), $d->endOfDay()]);
            } catch (\Exception $e) {
                // ignore invalid date
            }
        }

        if ($dateMode === 'bulan' && !empty($this->filters['month'])) {
            try {
                $monthRaw = $this->filters['month'];
                if (preg_match('/^\d{2}\/\d{4}$/', $monthRaw)) {
                    $m = Carbon::createFromFormat('m/Y', $monthRaw);
                } else {
                    $m = Carbon::createFromFormat('Y-m', $monthRaw);
                }
                $query->whereBetween('created_at', [$m->startOfMonth(), $m->endOfMonth()]);
            } catch (\Exception $e) {
                // ignore invalid month
            }
        }

        if ($dateMode === 'rentang' && !empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            try {
                $s = Carbon::createFromFormat('d/m/Y', $this->filters['start_date']);
                $e = Carbon::createFromFormat('d/m/Y', $this->filters['end_date']);
                $query->whereBetween('created_at', [$s->startOfDay(), $e->endOfDay()]);
            } catch (\Exception $e) {
                // ignore invalid range
            }
        }

        if ($dateMode === 'tahun' && !empty($this->filters['year'])) {
            $year = $this->filters['year'];
            if (preg_match('/^\d{4}$/', $year)) {
                $query->whereBetween('created_at', [Carbon::parse($year.'-01-01')->startOfDay(), Carbon::parse($year.'-12-31')->endOfDay()]);
            }
        }

        if (!empty($this->filters['tagar'])) {
            $query->where('tagar', 'like', '%'.$this->filters['tagar'].'%');
        }

        return $query;
    }
    
    public function headings(): array
    {
        return ['Judul', 'Link', 'Jenis', 'Sumber', 'Hashtag', 'Tanggal']; // Kepala kolom laporan Excel[cite: 1]
    }
    
    /**
     * BUG FIX 3: Memperbaiki mapping nama properti relasi sesuai database master
     * dan menambahkan proteksi null-safe (?->) agar tidak crash jika relasi kosong.
     */
    public function map($postingan): array
    {
        return [
            $postingan->judul,
            $postingan->link,
            $postingan->jenisKonten?->nama ?? '-',
            $postingan->sumberKonten?->nama ?? '-',
            $postingan->hashtag ?? '-',
            $postingan->created_at?->format('d-m-Y') ?? '-',
        ];
    }
}
