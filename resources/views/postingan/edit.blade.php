<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Konten') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    <!-- FORM EDIT -->
                    <form action="{{ route('postingan.update', $postingan->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- LINK POSTINGAN -->
                        <div>
                            <label for="link" class="block text-sm font-medium text-gray-700 mb-2">
                                Link Postingan *
                            </label>
                            <input type="url" 
                                   id="link" 
                                   name="link" 
                                   placeholder="https://instagram.com/p/..." 
                                   required
                                   class="w-full px-4 py-2 border @error('link') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   value="{{ old('link', $postingan->link) }}">
                            @error('link')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- JUDUL/KETERANGAN -->
                        <div>
                            <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                                Judul/Keterangan Singkat *
                            </label>
                            <input type="text" 
                                   id="judul" 
                                   name="judul" 
                                   placeholder="Contoh: Ucapan Hari Pers, Optimalisasi Infrastruktur" 
                                   required
                                   class="w-full px-4 py-2 border @error('judul') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   value="{{ old('judul', $postingan->judul) }}">
                            @error('judul')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- JENIS KONTEN -->
                        <div>
                            <label for="jenis_konten_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Konten *
                            </label>
                            <select id="jenis_konten_id" 
                                    name="jenis_konten_id" 
                                    required
                                    class="w-full px-4 py-2 border @error('jenis_konten_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Pilih Jenis Konten --</option>
                                @foreach($jenisKonten as $jenis)
                                    <option value="{{ $jenis->id }}" @selected(old('jenis_konten_id', $postingan->jenis_konten_id) == $jenis->id)>
                                        {{ $jenis->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_konten_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- SUMBER KONTEN -->
                        <div>
                            <label for="sumber_konten_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Sumber Konten *
                            </label>
                            <select id="sumber_konten_id" 
                                    name="sumber_konten_id" 
                                    required
                                    class="w-full px-4 py-2 border @error('sumber_konten_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Pilih Sumber Konten --</option>
                                @foreach($sumberKonten as $sumber)
                                    <option value="{{ $sumber->id }}" @selected(old('sumber_konten_id', $postingan->sumber_konten_id) == $sumber->id)>
                                        {{ $sumber->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sumber_konten_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- HASHTAG -->
                        <div>
                            <label for="hashtag" class="block text-sm font-medium text-gray-700 mb-2">
                                Hashtag (Optional)
                            </label>
                            <input type="text" 
                                   id="hashtag" 
                                   name="hashtag" 
                                   placeholder="Contoh: #flyer, #flyover, #hari-pers" 
                                   class="w-full px-4 py-2 border @error('hashtag') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   value="{{ old('hashtag', $postingan->hashtag) }}">
                            @error('hashtag')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-xs mt-1">Pisahkan dengan koma jika ada lebih dari satu tag</p>
                        </div>

                        <!-- TOMBOL AKSI -->
                        <div class="flex gap-3 pt-4">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                                Update Data
                            </button>
                            <a href="{{ route('dashboard') }}" class="px-6 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition font-medium">
                                Batal
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>