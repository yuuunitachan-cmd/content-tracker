<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-600 text-sm font-medium">Total Konten</div>
                    <div class="text-3xl font-bold text-blue-600 mt-2">{{ $totalKonten }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-600 text-sm font-medium">Foto</div>
                    <div class="text-3xl font-bold text-green-600 mt-2">{{ $fotoCount }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="text-gray-600 text-sm font-medium">Video</div>
                    <div class="text-3xl font-bold text-purple-600 mt-2">{{ $videoCount }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-gray-600 text-sm font-medium">Infografis</div>
                    <div class="text-3xl font-bold text-yellow-600 mt-2">{{ $infografikCount }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                    <div class="text-gray-600 text-sm font-medium">Flyer</div>
                    <div class="text-3xl font-bold text-red-600 mt-2">{{ $flyerCount }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Filter</h3>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('dashboard', ['filter' => 'semua']) }}" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-800 hover:bg-gray-700 hover:text-white transition">Semua</a>
                    <a href="{{ route('dashboard', ['filter' => 1]) }}" class="px-4 py-2 rounded-lg bg-green-100 text-green-800 hover:bg-green-700 hover:text-white transition">Foto</a>
                    <a href="{{ route('dashboard', ['filter' => 2]) }}" class="px-4 py-2 rounded-lg bg-purple-100 text-purple-800 hover:bg-purple-700 hover:text-white transition">Video</a>
                    <a href="{{ route('dashboard', ['filter' => 3]) }}" class="px-4 py-2 rounded-lg bg-yellow-100 text-yellow-800 hover:bg-yellow-700 hover:text-white transition">Infografis</a>
                    <a href="{{ route('dashboard', ['filter' => 4]) }}" class="px-4 py-2 rounded-lg bg-red-100 text-red-800 hover:bg-red-700 hover:text-white transition">Flyer</a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <a href="{{ route('postingan.create') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">+ Input Konten Baru</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Data Postingan</h3>
                    @if($postingan->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border px-4 py-3 text-left">No</th>
                                        <th class="border px-4 py-3 text-left">Judul</th>
                                        <th class="border px-4 py-3 text-left">Jenis</th>
                                        <th class="border px-4 py-3 text-left">Sumber</th>
                                        <th class="border px-4 py-3 text-left">Hashtag</th>
                                        <th class="border px-4 py-3 text-left">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($postingan as $post)
                                        <tr class="hover:bg-gray-50">
                                            <td class="border px-4 py-3">{{ $loop->iteration }}</td>
                                            <td class="border px-4 py-3"><a href="{{ $post->link }}" target="_blank" class="text-blue-600">{{ Str::limit($post->judul, 40) }}</a></td>
                                            <td class="border px-4 py-3">{{ $post->jenisKonten->nama }}</td>
                                            <td class="border px-4 py-3">{{ $post->sumberKonten->nama }}</td>
                                            <td class="border px-4 py-3">{{ $post->hashtag ?? '-' }}</td>
                                            <td class="border px-4 py-3">{{ $post->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6">{{ $postingan->links() }}</div>
                    @else
                        <p class="text-gray-500">Belum ada data</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>