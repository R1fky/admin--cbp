@extends('layouts.app')

@section('title', 'Edit Video Education')
@section('page-title', 'Edit Video Education')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        {{-- Header Card --}}
        <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h3 class="text-lg font-bold text-slate-800 tracking-tight">
                    Edit Video Edukasi
                </h3>
                <p class="text-slate-500 text-xs mt-0.5">
                    Perbarui informasi video edukatif yang ditayangkan pada halaman muka portal.
                </p>
            </div>

            <a href="{{ route('edukasi-video.index') }}"
                class="bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 px-5 py-2.5 rounded-xl text-xs font-semibold transition">
                ← Kembali
            </a>
        </div>

        <form action="{{ route('edukasi-video.update', $edukasiVideo) }}" method="POST" class="bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden p-6 md:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                {{-- Judul --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                        Judul Video
                    </label>
                    <input type="text" name="judul" value="{{ old('judul', $edukasiVideo->judul) }}" placeholder="Contoh: Cara Mengenali Uang Rupiah Asli"
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 @error('judul') border-rose-400 focus:ring-rose-200/30 @enderror">
                    @error('judul')
                        <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                        Deskripsi Singkat Video
                    </label>
                    <textarea rows="4" name="deskripsi" placeholder="Tuliskan keterangan isi video edukatif ini..."
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 @error('deskripsi') border-rose-400 focus:ring-rose-200/30 @enderror">{{ old('deskripsi', $edukasiVideo->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Link --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                        Tautan / URL Video YouTube
                    </label>
                    <input type="url" name="link" value="{{ old('link', $edukasiVideo->link) }}" placeholder="https://www.youtube.com/watch?v=..."
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 @error('link') border-rose-400 focus:ring-rose-200/30 @enderror">
                    @error('link')
                        <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Preview Link Saat Ini --}}
                @if ($edukasiVideo->link)
                    <div class="rounded-xl border border-emerald-100 bg-emerald-50/50 p-4">
                        <div class="flex items-start gap-3">
                            <span class="text-xl">🔗</span>
                            <div>
                                <h4 class="font-bold text-xs text-emerald-800">Tautan Terpasang Saat Ini</h4>
                                <a href="{{ $edukasiVideo->link }}" target="_blank"
                                    class="text-xs text-blue-600 hover:text-blue-700 hover:underline break-all mt-1 inline-block">
                                    {{ $edukasiVideo->link }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Helper / Tips --}}
                <div class="rounded-xl bg-blue-50/60 border border-blue-100 p-5">
                    <div class="flex gap-3 items-start">
                        <span class="text-xl">💡</span>
                        <div>
                            <h4 class="font-bold text-xs text-blue-800">Tautan Yang Didukung</h4>
                            <p class="text-xs text-blue-600 mt-1 leading-relaxed">
                                Silakan gunakan tautan yang valid dan dapat diakses publik. YouTube, Google Drive file preview, dan Vimeo didukung oleh peninjau media.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="mt-6 flex justify-end gap-3 border-t border-slate-100 pt-6">
                <a href="{{ route('edukasi-video.index') }}"
                    class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition">
                    Batal
                </a>

                <button class="px-6 py-2.5 rounded-xl bg-[#0B1A40] hover:bg-[#1E3A8A] text-white text-xs font-bold transition shadow-md cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
