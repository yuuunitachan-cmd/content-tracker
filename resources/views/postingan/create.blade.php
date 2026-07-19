<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data Konten') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('postingan.store') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <!-- Input Judul -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Judul / Keterangan Singkat</label>
                            <input type="text" name="judul" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Input Link -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Link Postingan</label>
                            <input type="url" name="link" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Grid 2 Kolom untuk Dropdown Jenis & Sumber -->
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Dropdown Jenis Konten -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis Konten</label>
                                <select name="jenis_konten_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="" disabled selected>-- Pilih Jenis --</option>
                                    <!-- Jika pakai data dinamis, loop $jenis_konten di sini -->
                                    <option value="1">Foto</option>
                                    <option value="2">Video</option>
                                    <option value="3">Infografis</option>
                                    <option value="4">Flyer</option>
                                    <option value="5">Rilis Berita</option>
                                </select>
                            </div>

                            <!-- Dropdown Sumber Konten -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Sumber Konten</label>
                                <select name="sumber_konten_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="" disabled selected>-- Pilih Sumber --</option>
                                    <option value="1">IG Discominfo</option>
                                    <option value="2">IG Pemkot</option>
                                    <option value="3">Website</option>
                                </select>
                            </div>
                        </div>

                        <!-- Input Tagar -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tagar (Hashtag)</label>
                            <input type="text" name="tagar" placeholder="Contoh: #flyover #infrastruktur" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                            <!-- TOMBOL BACK -->
                            <a href="{{ route('postingan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-300">
                                Kembali
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>