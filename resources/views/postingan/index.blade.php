<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Publikasi Konten') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tombol Tambah Data -->
            <div class="mb-4 flex justify-end">
                <a href="{{ route('postingan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                    + Tambah Konten Baru
                </a>
            </div>

            <!-- Tabel Data -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b">
                                <th class="p-3">Judul/Keterangan</th>
                                <th class="p-3">Jenis</th>
                                <th class="p-3">Sumber</th>
                                <th class="p-3">Tagar</th>
                                <th class="p-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Asumsi datanya dikirim dari controller dengan nama $postingan -->
                            @foreach ($postingan as $item)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">
                                    <a href="{{ $item->link }}" target="_blank" class="text-blue-500 underline">{{ $item->judul }}</a>
                                </td>
                                <td class="p-3">{{ $item->jenisKonten->nama_jenis ?? 'N/A' }}</td>
                                <td class="p-3">{{ $item->sumberKonten->nama_sumber ?? 'N/A' }}</td>
                                <td class="p-3">{{ $item->tagar }}</td>
                                <td class="p-3 text-center flex justify-center space-x-2">
                                    <a href="{{ route('postingan.edit', $item->id) }}" class="text-yellow-600 hover:text-yellow-800 font-semibold">Edit</a>
                                    
                                    <!-- Form Delete dengan Konfirmasi -->
                                    <form action="{{ route('postingan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>