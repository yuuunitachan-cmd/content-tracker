<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Edit Data Konten') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-cloud min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-surface border border-primary/10 shadow-xl rounded-[1.5rem] overflow-hidden">
                <div class="p-6 space-y-6">
                    <div class="rounded-3xl bg-white/95 border border-primary/10 p-6 shadow-sm">
                        <h3 class="text-lg font-bold text-primary">Form Edit Konten</h3>
                        <p class="mt-2 text-sm text-primary/70">Perbarui detail publikasi konten yang sudah tersimpan.</p>
                    </div>

                    <form action="{{ route('postingan.update', $postingan->id) }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div class="space-y-1">
                            <label class="text-sm font-medium text-primary/80">Judul / Keterangan Singkat</label>
                            <input type="text" name="judul" value="{{ old('judul', $postingan->judul) }}" required class="w-full rounded-2xl border border-primary/20 bg-white px-4 py-3 text-sm text-primary shadow-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                            @error('judul')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="space-y-1">
                            <label class="text-sm font-medium text-primary/80">Link Postingan</label>
                            <input type="url" name="link" value="{{ old('link', $postingan->link) }}" required class="w-full rounded-2xl border border-primary/20 bg-white px-4 py-3 text-sm text-primary shadow-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                            @error('link')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-primary/80">Jenis Konten</label>
                                <select name="jenis_konten_id" required class="w-full rounded-2xl border border-primary/20 bg-white px-4 py-3 text-sm text-primary shadow-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                                    @foreach ($jenisKonten as $jenis)
                                        <option value="{{ $jenis->id }}" {{ old('jenis_konten_id', $postingan->jenis_konten_id) == $jenis->id ? 'selected' : '' }}>{{ $jenis->nama }}</option>
                                    @endforeach
                                </select>
                                @error('jenis_konten_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="space-y-1">
                                <label class="text-sm font-medium text-primary/80">Sumber Konten</label>
                                <select name="sumber_konten_id" required class="w-full rounded-2xl border border-primary/20 bg-white px-4 py-3 text-sm text-primary shadow-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                                    @foreach ($sumberKonten as $sumber)
                                        <option value="{{ $sumber->id }}" {{ old('sumber_konten_id', $postingan->sumber_konten_id) == $sumber->id ? 'selected' : '' }}>{{ $sumber->nama }}</option>
                                    @endforeach
                                </select>
                                @error('sumber_konten_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-sm font-medium text-primary/80">Tagar (Hashtag)</label>
                            <input type="text" name="tagar" value="{{ old('tagar', $postingan->tagar) }}" class="w-full rounded-2xl border border-primary/20 bg-white px-4 py-3 text-sm text-primary shadow-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                            @error('tagar')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                            <a href="{{ route('postingan.index') }}" class="inline-flex items-center justify-center rounded-full border border-primary/20 bg-white px-5 py-3 text-sm font-semibold text-primary transition hover:bg-primary/5">
                                Batal / Kembali
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center rounded-full bg-primary px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-primary/10 transition hover:bg-primary/90">
                                Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
