<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Konten') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('postingan.update', $postingan->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Judul / Keterangan Singkat</label>
                            <input type="text" name="judul" value="{{ $postingan->judul }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Link Postingan</label>
                            <input type="url" name="link" value="{{ $postingan->link }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis Konten</label>
                                <select name="jenis_konten_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="1" {{ $postingan->jenis_konten_id == 1 ? 'selected' : '' }}>Foto</option>
                                    <option value="2" {{ $postingan->jenis_konten_id == 2 ? 'selected' : '' }}>Video</option>
                                    <option value="3" {{ $postingan->jenis_konten_id == 3 ? 'selected' : '' }}>Infografis</option>
                                    <option value="4" {{ $postingan->jenis_konten_id == 4 ? 'selected' : '' }}>Flyer</option>
                                    <option value="5" {{ $postingan->jenis_konten_id == 5 ? 'selected' : '' }}>Rilis Berita</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Sumber Konten</label>
                                <select name="sumber_konten_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="1" {{ $postingan->sumber_konten_id == 1 ? 'selected' : '' }}>IG Discominfo</option>
                                    <option value="2" {{ $postingan->sumber_konten_id == 2 ? 'selected' : '' }}>IG Pemkot</option>
                                    <option value="3" {{ $postingan->sumber_konten_id == 3 ? 'selected' : '' }}>Website</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tagar (Hashtag)</label>
                            <input type="text" name="tagar" value="{{ $postingan->tagar }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                            <!-- TOMBOL BACK -->
                            <a href="{{ route('postingan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-300">
                                Batal / Kembali
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">
                                Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>