<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Dashboard Tracking Konten') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-cloud min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            
            <!-- 1. BAGIAN FILTER WAKTU -->
            <div class="bg-surface border border-primary/10 shadow-lg rounded-[1.5rem] p-5 space-y-5">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <span class="font-semibold text-primary">Filter Waktu</span>
                        <p class="mt-1 text-sm text-primary/70">Pilih hari, bulan, tahun, atau rentang tanggal untuk melihat data secara akurat.</p>
                    </div>
                    @php
                        $dashboardParams = [
                            'date' => $selected_date,
                            'month' => $selected_month,
                            'year' => $selected_year,
                            'start_date' => $start_date,
                            'end_date' => $end_date,
                        ];
                    @endphp

                    <div class="inline-flex rounded-full shadow-sm overflow-hidden" role="group">
                        <a href="{{ route('dashboard', array_merge($dashboardParams, ['date_mode' => 'hari'])) }}"
                           class="px-5 py-2 text-sm font-semibold border border-primary/10 transition duration-200 ease-in-out {{ $date_mode === 'hari' ? 'bg-primary text-white' : 'bg-white text-primary hover:bg-mist' }}">
                            Hari
                        </a>
                        <a href="{{ route('dashboard', array_merge($dashboardParams, ['date_mode' => 'bulan'])) }}"
                           class="px-5 py-2 text-sm font-semibold border-t border-b border-primary/10 transition duration-200 ease-in-out {{ $date_mode === 'bulan' ? 'bg-primary text-white' : 'bg-white text-primary hover:bg-mist' }}">
                            Bulan
                        </a>
                        <a href="{{ route('dashboard', array_merge($dashboardParams, ['date_mode' => 'tahun'])) }}"
                           class="px-5 py-2 text-sm font-semibold border border-primary/10 transition duration-200 ease-in-out {{ $date_mode === 'tahun' ? 'bg-primary text-white' : 'bg-white text-primary hover:bg-mist' }}">
                            Tahun
                        </a>
                        <a href="{{ route('dashboard', array_merge($dashboardParams, ['date_mode' => 'rentang'])) }}"
                           class="px-5 py-2 text-sm font-semibold border border-primary/10 transition duration-200 ease-in-out {{ $date_mode === 'rentang' ? 'bg-primary text-white' : 'bg-white text-primary hover:bg-mist' }}">
                            Rentang
                        </a>
                    </div>
                </div>

                <form method="GET" action="{{ route('dashboard') }}" class="grid gap-4 md:grid-cols-[minmax(0,1fr)_auto] items-end">
                    <input type="hidden" name="date_mode" value="{{ $date_mode }}">
                    @if($date_mode === 'hari')
                        <div class="grid gap-2">
                            <label class="text-sm font-medium text-primary/70">Pilih tanggal</label>
                            <input type="date" name="date" value="{{ $selected_date }}" class="rounded-2xl border border-primary/20 bg-white px-4 py-3 text-primary shadow-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" />
                        </div>
                    @elseif($date_mode === 'bulan')
                        <div class="grid gap-2">
                            <label class="text-sm font-medium text-primary/70">Pilih bulan</label>
                            <input type="month" name="month" value="{{ $selected_month }}" class="rounded-2xl border border-primary/20 bg-white px-4 py-3 text-primary shadow-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" />
                        </div>
                    @elseif($date_mode === 'tahun')
                        <div class="grid gap-2">
                            <label class="text-sm font-medium text-primary/70">Pilih tahun</label>
                            <input type="number" name="year" value="{{ $selected_year }}" min="2000" max="2100" class="rounded-2xl border border-primary/20 bg-white px-4 py-3 text-primary shadow-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" />
                        </div>
                    @elseif($date_mode === 'rentang')
                        <div class="grid gap-2 md:grid-cols-2">
                            <div class="grid gap-2">
                                <label class="text-sm font-medium text-primary/70">Tanggal mulai</label>
                                <input type="date" name="start_date" value="{{ $start_date }}" class="rounded-2xl border border-primary/20 bg-white px-4 py-3 text-primary shadow-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" />
                            </div>
                            <div class="grid gap-2">
                                <label class="text-sm font-medium text-primary/70">Tanggal selesai</label>
                                <input type="date" name="end_date" value="{{ $end_date }}" class="rounded-2xl border border-primary/20 bg-white px-4 py-3 text-primary shadow-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" />
                            </div>
                        </div>
                    @endif
                    <button type="submit" class="inline-flex items-center justify-center rounded-full bg-primary px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary/10 transition hover:bg-primary/90">
                        Terapkan
                    </button>
                </form>
            </div>

            <!-- 2. BAGIAN RINGKASAN STATISTIK -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-white/95 border border-primary/10 shadow-xl rounded-[1.5rem] p-6">
                    <div class="text-sm font-medium text-primary/70 truncate">Total Konten ({{ $label_waktu }})</div>
                    <div class="mt-3 text-3xl font-bold text-primary">{{ $total_konten }}</div>
                </div>
                <div class="bg-white/95 border border-primary/10 shadow-xl rounded-[1.5rem] p-6">
                    <div class="text-sm font-medium text-primary/70 truncate">Total Foto</div>
                    <div class="mt-3 text-3xl font-bold text-primary">{{ $total_foto }}</div>
                </div>
                <div class="bg-white/95 border border-primary/10 shadow-xl rounded-[1.5rem] p-6">
                    <div class="text-sm font-medium text-primary/70 truncate">Total Video</div>
                    <div class="mt-3 text-3xl font-bold text-primary">{{ $total_video }}</div>
                </div>
            </div>

            <!-- 2b. CHART -->
            <div class="bg-white/95 border border-primary/10 shadow-xl rounded-[1.5rem] p-6">
                <h4 class="text-sm font-semibold text-primary mb-3">Trend Konten (per hari)</h4>
                <canvas id="kontenChart" height="100"></canvas>
            </div>

            <!-- 3. BAGIAN TABEL DATA & TOMBOL INPUT -->
            <div class="bg-white/95 border border-primary/10 shadow-xl rounded-[1.5rem] overflow-hidden">
                <div class="p-6">
                    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-primary">Riwayat Postingan</h3>
                            <p class="text-sm text-primary/70">Semua konten yang direkam selama periode yang dipilih.</p>
                        </div>
                        <a href="{{ route('postingan.create') }}" class="inline-flex items-center justify-center rounded-full bg-primary px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-primary/10 transition hover:bg-primary/90">
                            + Tambah Konten Baru
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left border-separate border-spacing-0">
                            <thead>
                                <tr class="bg-surface text-primary/90">
                                    <th class="px-4 py-3 text-xs font-semibold uppercase tracking-[0.18em]">Waktu Input</th>
                                    <th class="px-4 py-3 text-xs font-semibold uppercase tracking-[0.18em]">Judul/Keterangan</th>
                                    <th class="px-4 py-3 text-xs font-semibold uppercase tracking-[0.18em]">Jenis</th>
                                    <th class="px-4 py-3 text-xs font-semibold uppercase tracking-[0.18em]">Sumber</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-[0.18em]">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($postingan as $item)
                                <tr class="border-b border-primary/10 hover:bg-mist transition-colors duration-200">
                                    <td class="px-4 py-4 text-sm text-primary/70">{{ $item->created_at->format('d M Y, H:i') }}</td>
                                    <td class="px-4 py-4">
                                        <a href="{{ $item->link }}" target="_blank" class="text-primary font-medium hover:underline">{{ $item->judul }}</a>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-primary/80">{{ $item->jenisKonten->nama ?? 'N/A' }}</td>
                                    <td class="px-4 py-4 text-sm text-primary/80">{{ $item->sumberKonten->nama ?? 'N/A' }}</td>
                                    <td class="px-4 py-4 text-center">
                                        <div class="inline-flex items-center justify-center gap-3">
                                            <a href="{{ route('postingan.edit', $item->id) }}" class="text-primary font-semibold hover:text-primary/80">Edit</a>
                                            <form action="{{ route('postingan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-primary/70">Belum ada data konten untuk periode ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>

@push('scripts')
    <div id="dashboard-chart-data" class="hidden"
         data-labels="{{ htmlspecialchars(json_encode($chartLabels ?? []), ENT_QUOTES, 'UTF-8') }}"
         data-values="{{ htmlspecialchars(json_encode($chartData ?? []), ENT_QUOTES, 'UTF-8') }}">
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function(){
            const ctx = document.getElementById('kontenChart');
            if (!ctx) return;
            const chartDataEl = document.getElementById('dashboard-chart-data');
            const labels = chartDataEl ? JSON.parse(chartDataEl.dataset.labels || '[]') : [];
            const data = chartDataEl ? JSON.parse(chartDataEl.dataset.values || '[]') : [];

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Konten',
                        data: data,
                        borderColor: getComputedStyle(document.documentElement).getPropertyValue('--tw-color-primary') || '#003d56',
                        backgroundColor: 'rgba(0,61,86,0.08)',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: { display: true },
                        y: { beginAtZero: true }
                    }
                }
            });
        })();
    </script>
@endpush