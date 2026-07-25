@extends('layouts.app')

@section('title', 'Edit Engagement')
@section('page-title', 'Edit Engagement')

@section('content')
    <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden max-w-4xl mx-auto">
        {{-- Form Header --}}
        <div class="bg-gradient-to-r from-[#0B1A40] to-[#1E3A8A] px-6 py-5 text-white">
            <h3 class="text-base font-bold tracking-tight">Edit Program Engagement</h3>
            <p class="text-slate-300 text-xs mt-0.5">Perbarui rincian program kerja, lomba, atau kegiatan yang dipublikasikan.</p>
        </div>

        <form action="{{ route('lomba.update', $lomba) }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Judul --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                        Judul Lomba / Kegiatan
                    </label>
                    <input type="text" name="title" value="{{ old('title', $lomba->title) }}" placeholder="Contoh: Kompetisi Video Edukasi CBP Rupiah"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 @error('title') border-rose-400 focus:ring-rose-200/30 @enderror">
                    @error('title')
                        <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                        Kategori Program
                    </label>
                    <select name="kategori_id"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 bg-white @error('kategori_id') border-rose-400 focus:ring-rose-200/30 @enderror">
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id', $lomba->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Location Type --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                        Tipe Pelaksanaan
                    </label>
                    <select name="location_type"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 bg-white @error('location_type') border-rose-400 focus:ring-rose-200/30 @enderror">
                        <option value="online" {{ old('location_type', $lomba->location_type) == 'online' ? 'selected' : '' }}>Online</option>
                        <option value="offline" {{ old('location_type', $lomba->location_type) == 'offline' ? 'selected' : '' }}>Offline</option>
                    </select>
                    @error('location_type')
                        <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Location --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                        Detail Lokasi / Tautan Kegiatan
                    </label>
                    <input type="text" name="location" value="{{ old('location', $lomba->location) }}" placeholder="Contoh: Zoom Meeting, atau Gedung BI Lt. 3"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 @error('location') border-rose-400 focus:ring-rose-200/30 @enderror">
                    @error('location')
                        <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kuota Peserta --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                        Kuota Maksimal Peserta
                    </label>
                    <input type="number" min="1" name="max_participants" value="{{ old('max_participants', $lomba->max_participants) }}" placeholder="Kosongkan jika tidak dibatasi"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30">
                </div>

                {{-- Release Date --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                        Tanggal Mulai Program
                    </label>
                    <input type="date" name="release_date" value="{{ old('release_date', optional($lomba->release_date)->format('Y-m-d')) }}"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 @error('release_date') border-rose-400 focus:ring-rose-200/30 @enderror">
                    @error('release_date')
                        <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- End Date --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                        Tanggal Berakhir Pendaftaran
                    </label>
                    <input type="date" name="end_date" value="{{ old('end_date', optional($lomba->end_date)->format('Y-m-d')) }}"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 @error('end_date') border-rose-400 focus:ring-rose-200/30 @enderror">
                    @error('end_date')
                        <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Thumbnail Saat Ini --}}
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-4 gap-4 items-end border-t border-slate-100 pt-4">
                    <div class="md:col-span-1">
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">
                            Thumbnail Saat Ini
                        </label>
                        @if ($lomba->thumbnail)
                            <img src="{{ asset('storage/' . $lomba->thumbnail) }}"
                                class="w-full h-24 object-cover rounded-xl border border-slate-200 shadow-sm">
                        @else
                            <div class="w-full h-24 bg-slate-100 rounded-xl border border-slate-200 border-dashed flex items-center justify-center text-slate-400 text-xs">
                                No Thumbnail
                            </div>
                        @endif
                    </div>
                    
                    <div class="md:col-span-3">
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                            Ganti Gambar Thumbnail
                        </label>
                        <input type="file" name="thumbnail" accept="image/*"
                            class="w-full text-xs text-slate-500 border border-slate-200 rounded-xl bg-white
                            file:mr-4 file:border-0 file:bg-[#0B1A40] file:text-white file:px-4 file:py-2.5 file:rounded-l-xl file:font-semibold hover:file:bg-[#1E3A8A] file:cursor-pointer @error('thumbnail') border-rose-400 @enderror">
                        @error('thumbnail')
                            <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Description --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                        Deskripsi & Ketentuan Kegiatan
                    </label>
                    <textarea name="description" rows="5" placeholder="Tuliskan detail pelaksanaan, hadiah, syarat pendaftaran, dan ketentuan lainnya..."
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 resize-none @error('description') border-rose-400 focus:ring-rose-200/30 @enderror">{{ old('description', $lomba->description) }}</textarea>
                    @error('description')
                        <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex gap-3 border-t border-slate-100 pt-6">
                <a href="{{ route('lomba.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 hover:bg-slate-200 rounded-xl text-xs font-semibold transition">
                    Kembali
                </a>
                <button type="submit" class="px-5 py-2.5 bg-[#0B1A40] hover:bg-[#1E3A8A] text-white rounded-xl text-xs font-semibold transition cursor-pointer">
                    Perbarui Program
                </button>
            </div>
        </form>
    </div>
@endsection
