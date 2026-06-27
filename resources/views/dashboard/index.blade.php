@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

    {{-- Header --}}
    <div class="bg-white rounded-xl shadow-sm border-l-4 border-[#CF1A25] p-6 mb-6">
        <h2 class="text-2xl font-bold text-[#1C3281]">
            Dashboard Admin
        </h2>

        <p class="text-gray-500 mt-2">
            Selamat datang kembali, {{ Auth::user()->name }}
        </p>
    </div>

    {{-- Search --}}
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <form action="{{ route('dashboard') }}" method="GET">
            <div class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berita atau lomba..."
                    class="flex-1 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#1C3281]">
                <button type="submit" class="bg-[#1C3281] text-white px-5 rounded-lg hover:bg-blue-900">
                    Cari
                </button>

                @if (request('search'))
                    <a href="{{ route('dashboard') }}" class="bg-gray-200 px-4 py-3 rounded-lg">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>
    {{-- Alert Hasil Pencarian --}}
    @if (request('search'))
        <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded-xl shadow-sm">
            <div class="flex items-center gap-2">
                <span class="text-lg">🔍</span>
                <div>
                    <p class="font-semibold">
                        Hasil Pencarian
                    </p>
                    <p>
                        Menampilkan data dengan kata kunci:
                        <strong>"{{ request('search') }}"</strong>
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6 mb-8">
        {{-- total lomba --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-[#1C3281]">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500">
                        Total Lomba
                    </p>
                    <h2 class="text-4xl font-bold text-[#1C3281] mt-2">
                        {{ $totalLomba }}
                    </h2>
                </div>
                <div class="text-4xl">
                    🏆
                </div>
            </div>
        </div>

        {{-- total berita --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500">
                        Total Berita
                    </p>
                    <h2 class="text-4xl font-bold text-green-600 mt-2">
                        {{ $totalBerita }}
                    </h2>
                </div>
                <div class="text-4xl">
                    📰
                </div>
            </div>

        </div>

        {{-- akan di buka --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-400">
            <div class="flex justify-between items-center">

                <div>
                    <p class="text-gray-500">
                        Akan Dibuka
                    </p>

                    <h2 class="text-4xl font-bold text-yellow-500 mt-2">
                        {{ $lombaAkanDibuka }}
                    </h2>
                </div>

                <div class="text-4xl">
                    📅
                </div>

            </div>
        </div>

        {{-- lomba berlangsung --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex justify-between items-center">

                <div>
                    <p class="text-gray-500">
                        Sedang Berlangsung
                    </p>

                    <h2 class="text-4xl font-bold text-green-600 mt-2">
                        {{ $lombaBerlangsung }}
                    </h2>
                </div>

                <div class="text-4xl">
                    🏆
                </div>

            </div>
        </div>
        {{-- <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500">
                        Lomba Berlangsung
                    </p>

                    <h2 class="text-4xl font-bold text-yellow-500 mt-2">
                        {{ $lombaBerlangsung }}
                    </h2>
                </div>
                <div class="text-4xl">
                    ⏳
                </div>
            </div>
        </div> --}}
        {{-- lomba selesai --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
            <div class="flex justify-between items-center">

                <div>
                    <p class="text-gray-500">
                        Pendaftaran Selesai
                    </p>

                    <h2 class="text-4xl font-bold text-red-500 mt-2">
                        {{ $lombaSelesai }}
                    </h2>
                </div>

                <div class="text-4xl">
                    🔒
                </div>

            </div>
        </div>
        {{-- <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500">
                        Lomba Selesai
                    </p>

                    <h2 class="text-4xl font-bold text-red-500 mt-2">
                        {{ $lombaSelesai }}
                    </h2>
                </div>
                <div class="text-4xl">
                    ✅
                </div>
            </div>
        </div> --}}

    </div>

    {{-- Aktivitas --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Berita --}}
        <div class="bg-white rounded-xl shadow-sm p-6">

            <h3 class="font-bold text-xl mb-4 text-[#1C3281]">
                Berita Terbaru
            </h3>

            @forelse($beritaTerbaru as $berita)
                <div class="border-b py-3">

                    <p class="font-semibold">
                        {{ $berita->title }}
                    </p>

                    <p class="text-sm text-gray-500">
                        {{ $berita->created_at->format('d M Y') }}
                    </p>

                </div>

            @empty

                <p class="text-gray-500">
                    Belum ada berita
                </p>
            @endforelse

        </div>

        {{-- Lomba --}}
        <div class="bg-white rounded-xl shadow-sm p-6">

            <h3 class="font-bold text-xl mb-4 text-[#1C3281]">
                Lomba Terbaru
            </h3>

            @forelse($lombaTerbaru as $lomba)
                <div class="border-b py-4">

                    <div class="flex justify-between items-center">

                        <div>

                            <p class="font-semibold">
                                {{ $lomba->title }}
                            </p>

                            <p class="text-sm text-gray-500">
                                {{ $lomba->release_date->format('d M Y') }}
                            </p>

                        </div>

                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $lomba->status_color }}">
                            {{ $lomba->status_label }}
                        </span>

                    </div>

                </div>

            @empty

                <p class="text-gray-500">
                    Belum ada lomba
                </p>
            @endforelse

        </div>

    </div>

@endsection
