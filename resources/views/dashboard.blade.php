<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Tracking Konten') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- 1. BAGIAN FILTER WAKTU -->
            <div class="bg-white p-4 shadow sm:rounded-lg flex justify-between items-center">
                <span class="font-bold text-gray-700">Filter Waktu:</span>
                <div class="inline-flex rounded-md shadow-sm" role="group">
                    <a href="{{ route('dashboard', ['filter' => 'hari']) }}" 
                       class="px-4 py-2 text-sm font-medium border border-gray-200 rounded-l-lg hover:bg-blue-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700
                       {{ $filter == 'hari' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-900' }}">
                        Hari Ini
                    </a>
                    <a href="{{ route('dashboard', ['filter' => 'minggu']) }}" 
                       class="px-4 py-2 text-sm font-medium border-t border-b border-gray-200 hover:bg-blue-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700
                       {{ $filter == 'minggu' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-900' }}">
                        Minggu Ini
                    </a>
                    <a href="{{ route('dashboard', ['filter' => 'bulan']) }}" 
                       class="px-4 py-2 text-sm font-medium border border-gray-200 hover:bg-blue-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700
                       {{ $filter == 'bulan' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-900' }}">
                        Bulan Ini
                    </a>
                    <a href="{{ route('dashboard', ['filter' => 'tahun']) }}" 
                       class="px-4 py-2 text-sm font-medium border border-gray-200 rounded-r-md hover:bg-blue-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700
                       {{ $filter == 'tahun' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-900' }}">
                        Tahun Ini
                    </a>
                </div>
            </div>

            <!-- 2. BAGIAN RINGKASAN STATISTIK -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-sm font-medium text-gray-500 truncate">Total Konten ({{ $label_waktu }})</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $total_konten }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-sm font-medium text-gray-500 truncate">Total Foto</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $total_foto }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                    <div class="text-sm font-medium text-gray-500 truncate">Total Video</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $total_video }}</div>
                </div>
            </div>

            <!-- 3. BAGIAN TABEL DATA & TOMBOL INPUT -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Tombol Tambah Data -->
                    <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-700">Riwayat Postingan</h3>
                        <a href="{{ route('postingan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                            + Tambah Konten Baru
                        </a>
                    </div>

                    <!-- Tabel Data -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b">
                                    <th class="p-3">Waktu Input</th>
                                    <th class="p-3">Judul/Keterangan</th>
                                    <th class="p-3">Jenis</th>
                                    <th class="p-3">Sumber</th>
                                    <th class="p-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($postingan as $item)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3 text-sm text-gray-500">{{ $item->created_at->format('d M Y, H:i') }}</td>
                                    <td class="p-3">
                                        <a href="{{ $item->link }}" target="_blank" class="text-blue-500 underline">{{ $item->judul }}</a>
                                    </td>
                                    <td class="p-3">{{ $item->jenisKonten->nama_jenis ?? 'N/A' }}</td>
                                    <td class="p-3">{{ $item->sumberKonten->nama_sumber ?? 'N/A' }}</td>
                                    <td class="p-3 text-center flex justify-center space-x-2">
                                        <a href="{{ route('postingan.edit', $item->id) }}" class="text-yellow-600 hover:text-yellow-800 font-semibold">Edit</a>
                                        
                                        <form action="{{ route('postingan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="p-3 text-center text-gray-500">Belum ada data konten untuk periode ini.</td>
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