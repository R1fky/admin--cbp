@extends('layouts.app')

@section('title', 'Edit Video Education')
@section('page-title', 'Edit Video Education')

@section('content')

    <div class="space-y-6">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-[#1C3281] to-[#2948a5] rounded-2xl shadow-lg p-8 text-white">

            <div class="flex justify-between items-center">

                <div class="flex items-center gap-5">

                    <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center text-3xl">
                        🎥
                    </div>

                    <div>

                        <h2 class="text-3xl font-bold">
                            Edit Video Education
                        </h2>

                        <p class="text-blue-100 mt-2">
                            Perbarui informasi video edukasi yang akan ditampilkan pada website.
                        </p>

                    </div>

                </div>

                <a href="{{ route('edukasi-video.index') }}"
                    class="bg-white/20 hover:bg-white/30 px-5 py-3 rounded-xl transition">

                    ← Kembali

                </a>

            </div>

        </div>

        <form action="{{ route('edukasi-video.update', $edukasiVideo) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

                {{-- Header Card --}}
                <div class="px-8 py-6 border-b bg-gray-50">

                    <h3 class="text-xl font-bold text-[#1C3281]">
                        Informasi Video
                    </h3>

                    <p class="text-gray-500 mt-1">
                        Lengkapi seluruh informasi video berikut.
                    </p>

                </div>

                <div class="p-8 space-y-8">

                    {{-- Judul --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-3">

                            Judul Video

                        </label>

                        <input type="text" name="judul" value="{{ old('judul', $edukasiVideo->judul) }}"
                            placeholder="Contoh : Cara Mengenali Rupiah Asli"
                            class="w-full rounded-xl border border-gray-300 px-5 py-4
                        focus:border-[#1C3281]
                        focus:ring-4
                        focus:ring-blue-100
                        transition
                        @error('judul') border-red-500 @enderror">

                        @error('judul')
                            <p class="mt-2 text-red-500 text-sm">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Deskripsi --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-3">

                            Deskripsi

                        </label>

                        <textarea rows="6" name="deskripsi" placeholder="Masukkan deskripsi singkat mengenai video..."
                            class="w-full rounded-xl border border-gray-300 px-5 py-4 resize-none
                        focus:border-[#1C3281]
                        focus:ring-4
                        focus:ring-blue-100
                        transition
                        @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $edukasiVideo->deskripsi) }}</textarea>

                        @error('deskripsi')
                            <p class="mt-2 text-red-500 text-sm">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Link --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-3">

                            Link Video

                        </label>

                        <input type="url" name="link" value="{{ old('link', $edukasiVideo->link) }}"
                            placeholder="https://youtube.com/... atau https://drive.google.com/..."
                            class="w-full rounded-xl border border-gray-300 px-5 py-4
                        focus:border-[#1C3281]
                        focus:ring-4
                        focus:ring-blue-100
                        transition
                        @error('link') border-red-500 @enderror">

                        @error('link')
                            <p class="mt-2 text-red-500 text-sm">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Preview Link --}}
                    @if ($edukasiVideo->link)
                        <div class="rounded-2xl border border-green-200 bg-green-50 p-5">

                            <div class="flex items-start gap-4">

                                <div class="text-3xl">

                                    🔗

                                </div>

                                <div>

                                    <h4 class="font-semibold text-green-700">

                                        Link Saat Ini

                                    </h4>

                                    <a href="{{ $edukasiVideo->link }}" target="_blank"
                                        class="text-blue-600 hover:underline break-all">

                                        {{ $edukasiVideo->link }}

                                    </a>

                                </div>

                            </div>

                        </div>
                    @endif

                    {{-- Helper --}}
                    <div class="rounded-2xl bg-blue-50 border border-blue-200 p-6">

                        <div class="flex gap-4">

                            <div class="text-3xl">

                                💡

                            </div>

                            <div>

                                <h4 class="font-bold text-blue-700">

                                    Link yang Didukung

                                </h4>

                                <ul class="mt-3 text-sm text-blue-600 space-y-2">

                                    <li>✅ YouTube</li>
                                    <li>✅ Google Drive</li>
                                    <li>✅ Vimeo</li>
                                    <li>✅ Website lainnya</li>

                                </ul>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-4 mt-8">

                <a href="{{ route('edukasi-video.index') }}"
                    class="px-8 py-3 rounded-xl bg-gray-200 hover:bg-gray-300 transition">

                    Batal

                </a>

                <button
                    class="px-10 py-3 rounded-xl bg-gradient-to-r from-[#1C3281] to-[#2948a5] hover:opacity-90 text-white font-semibold shadow-lg">

                    💾 Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

@endsection
