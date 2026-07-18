<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Semua Konten') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- TOMBOL INPUT BARU -->
            <div class="mb-6">
                <a href="{{ route('postingan.create') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                    + Input Konten Baru
                </a>
            </div>

            <!-- TABEL DATA -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    @if($postingan->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full border-collapse">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border px-4 py-3 text-left font-semibold text-gray-700">No</th>
                                        <th class="border px-4 py-3 text-left font-semibold text-gray-700">Judul</th>
                                        <th class="border px-4 py-3 text-left font-semibold text-gray-700">Link</th>
                                        <th class="border px-4 py-3 text-left font-semibold text-gray-700">Jenis Konten</th>
                                        <th class="border px-4 py-3 text-left font-semibold text-gray-700">Sumber</th>
                                        <th class="border px-4 py-3 text-left font-semibold text-gray-700">Hashtag</th>
                                        <th class="border px-4 py-3 text-left font-semibold text-gray-700">Tanggal Input</th>
                                        <th class="border px-4 py-3 text-left font-semibold text-gray-700">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($postingan as $index => $post)
                                        <tr class="hover:bg-gray-50 border-b">
                                            <td class="border px-4 py-3 text-sm">{{ ($postingan->currentPage() - 1) * $postingan->perPage() + $loop->iteration }}</td>
                                            
                                            <td class="border px-4 py-3 text-sm font-medium text-gray-900">
                                                {{ Str::limit($post->judul, 40) }}
                                            </td>
                                            
                                            <td class="border px-4 py-3 text-sm">
                                                <a href="{{ $post->link }}" target="_blank" class="text-blue-600 hover:underline truncate block max-w-xs">
                                                    {{ Str::limit($post->link, 35) }}
                                                </a>
                                            </td>
                                            
                                            <td class="border px-4 py-3 text-sm">
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                    @if($post->jenisKonten->id == 1) bg-green-100 text-green-800
                                                    @elseif($post->jenisKonten->id == 2) bg-purple-100 text-purple-800
                                                    @elseif($post->jenisKonten->id == 3) bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800
                                                    @endif
                                                ">
                                                    {{ $post->jenisKonten->nama }}
                                                </span>
                                            </td>
                                            
                                            <td class="border px-4 py-3 text-sm text-gray-700">
                                                {{ $post->sumberKonten->nama }}
                                            </td>
                                            
                                            <td class="border px-4 py-3 text-sm text-gray-600">
                                                {{ $post->hashtag ?? '-' }}
                                            </td>
                                            
                                            <td class="border px-4 py-3 text-sm text-gray-600">
                                                {{ $post->created_at->format('d M Y H:i') }}
                                            </td>
                                            
                                            <td class="border px-4 py-3 text-sm">
                                                <div class="flex gap-2">
                                                    <a href="{{ route('postingan.edit', $post->id) }}" class="text-blue-600 hover:text-blue-900 hover:underline font-medium">
                                                        Edit
                                                    </a>
                                                    
                                                    <form action="{{ route('postingan.destroy', $post->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus data: {{ addslashes($post->judul) }}?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900 hover:underline font-medium">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- PAGINATION -->
                        <div class="mt-6 flex justify-center">
                            {{ $postingan->links() }}
                        </div>

                        <!-- INFO JUMLAH DATA -->
                        <div class="mt-4 text-sm text-gray-600">
                            Total data: <strong>{{ $postingan->total() }}</strong> konten
                        </div>

                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-500 text-lg mb-4">
                                Belum ada data postingan
                            </div>
                            <a href="{{ route('postingan.create') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                                Input Konten Pertama
                            </a>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>