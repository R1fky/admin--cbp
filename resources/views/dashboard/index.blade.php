@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    {{-- Toast Success --}}
    @if (session('success'))
        <div id="toastSuccess"
            class="fixed top-6 right-6 z-[9999] translate-x-[120%] transition-all duration-300
            rounded-xl bg-emerald-500 text-white shadow-2xl px-5 py-4 border border-emerald-400/20">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/20 text-lg">
                    ✓
                </div>
                <div>
                    <h3 class="font-bold text-sm">Berhasil</h3>
                    <p class="text-xs text-emerald-100 mt-0.5">{{ session('success') }}</p>
                </div>
                <button onclick="closeToast('toastSuccess')" class="ml-4 text-white/70 hover:text-white text-lg font-bold">
                    &times;
                </button>
            </div>
        </div>
    @endif

    {{-- Toast Error --}}
    @if ($errors->any())
        <div id="toastError"
            class="fixed top-6 right-6 z-[9999] translate-x-[120%] transition-all duration-300
            rounded-xl bg-rose-500 text-white shadow-2xl px-5 py-4 border border-rose-400/20">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/20 text-lg">
                    ✕
                </div>
                <div>
                    <h3 class="font-bold text-sm">Terjadi Kesalahan</h3>
                    <ul class="text-xs text-rose-100 mt-0.5 list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button onclick="closeToast('toastError')" class="ml-4 text-white/70 hover:text-white text-lg font-bold">
                    &times;
                </button>
            </div>
        </div>
    @endif

    {{-- Header --}}
    <div class="bg-white rounded-2xl border border-slate-200/60 p-6 mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight">
                Ringkasan Data Panel
            </h2>
            <p class="text-sm text-slate-500 mt-0.5">
                Selamat datang kembali, <span class="font-semibold text-slate-700">{{ Auth::user()->name }}</span>. Kelola seluruh aktivitas media di sini.
            </p>
        </div>
        <div class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-slate-100 text-slate-600 border border-slate-200/40">
            WIB: {{ date('H:i') }}
        </div>
    </div>

    {{-- Settings Banner --}}
    <div class="bg-gradient-to-r from-[#0B1A40] to-[#1E3A8A] rounded-2xl p-6 mb-8 text-white shadow-md relative overflow-hidden">
        <div class="absolute right-0 bottom-0 translate-y-6 translate-x-6 w-48 h-48 rounded-full bg-white/5 pointer-events-none"></div>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 relative z-10">
            <div>
                <h2 class="text-lg font-bold tracking-tight text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#C5A85C]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Konfigurasi Halaman Depan
                </h2>
                <p class="text-xs text-slate-200/90 mt-1 max-w-xl">
                    Kelola Hero Banner utama dan teks berjalan (running text) yang dipublikasikan pada halaman muka portal CBP.
                </p>
            </div>
            <button onclick="openHomeModal()"
                class="flex items-center gap-2 px-5 py-2.5 bg-white text-[#0B1A40] hover:bg-[#C5A85C] hover:text-white rounded-xl text-sm font-bold shadow-md transition-all duration-200 cursor-pointer">
                Buka Pengaturan
            </button>
        </div>
    </div>

    {{-- Search --}}
    <div class="bg-white rounded-2xl border border-slate-200/60 p-4 mb-6">
        <form action="{{ route('dashboard') }}" method="GET">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berita, pengumuman, atau program..."
                        class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 focus:border-[#0B1A40] transition text-sm">
                </div>
                <button type="submit"
                    class="w-full sm:w-auto bg-[#0B1A40] hover:bg-[#1E3A8A] text-white px-6 py-3 rounded-xl text-sm font-semibold transition cursor-pointer">
                    Cari Data
                </button>

                @if (request('search'))
                    <a href="{{ route('dashboard') }}"
                        class="w-full sm:w-auto text-center bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-3 rounded-xl text-sm font-medium transition flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Alert Hasil Pencarian --}}
    @if (request('search'))
        <div class="mb-6 bg-blue-50 border border-blue-100 text-blue-800 p-4 rounded-xl">
            <div class="flex items-center gap-3">
                <span class="text-lg">🔍</span>
                <div class="text-sm">
                    <p class="font-bold">Hasil Pencarian</p>
                    <p class="text-slate-600 mt-0.5">Menampilkan data dengan kata kunci: <strong class="text-blue-900">"{{ request('search') }}"</strong></p>
                </div>
            </div>
        </div>
    @endif

    {{-- Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-6 mb-8">
        {{-- total lomba --}}
        <div class="bg-white rounded-2xl border border-slate-200/60 p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                        Total Lomba
                    </p>
                    <h2 class="text-3xl font-extrabold text-slate-800 mt-2">
                        {{ $totalLomba }}
                    </h2>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v5m-3 0h6M4 6h16M4 6a4 4 0 004 4h8a4 4 0 004-4M4 6v2a6 6 0 0012 0V6"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- total berita --}}
        <div class="bg-white rounded-2xl border border-slate-200/60 p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                        Total Berita
                    </p>
                    <h2 class="text-3xl font-extrabold text-emerald-600 mt-2">
                        {{ $totalBerita }}
                    </h2>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- akan di buka --}}
        <div class="bg-white rounded-2xl border border-slate-200/60 p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                        Akan Dibuka
                    </p>
                    <h2 class="text-3xl font-extrabold text-amber-500 mt-2">
                        {{ $lombaAkanDibuka }}
                    </h2>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- lomba berlangsung --}}
        <div class="bg-white rounded-2xl border border-slate-200/60 p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                        Berlangsung
                    </p>
                    <h2 class="text-3xl font-extrabold text-indigo-600 mt-2">
                        {{ $lombaBerlangsung }}
                    </h2>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- lomba selesai --}}
        <div class="bg-white rounded-2xl border border-slate-200/60 p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                        Selesai
                    </p>
                    <h2 class="text-3xl font-extrabold text-rose-500 mt-2">
                        {{ $lombaSelesai }}
                    </h2>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center border border-rose-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Aktivitas --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">
        {{-- Berita --}}
        <div class="bg-white rounded-2xl border border-slate-200/60 p-5 shadow-sm">
            <h3 class="font-bold text-slate-800 text-base mb-4 flex items-center gap-2 pb-3 border-b border-slate-100">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                Berita & Sharing
            </h3>
            <div class="space-y-4">
                @forelse($beritaTerbaru as $berita)
                    <div class="group flex flex-col hover:bg-slate-50 p-2.5 rounded-xl transition duration-150">
                        <p class="font-semibold text-slate-700 text-sm group-hover:text-[#0B1A40] transition line-clamp-2 leading-relaxed">
                            {{ $berita->title }}
                        </p>
                        <p class="text-[10px] text-slate-400 mt-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $berita->created_at->format('d M Y') }}
                        </p>
                    </div>
                @empty
                    <p class="text-slate-400 text-sm text-center py-6">
                        Belum ada berita terbaru
                    </p>
                @endforelse
            </div>
        </div>

        {{-- Lomba --}}
        <div class="bg-white rounded-2xl border border-slate-200/60 p-5 shadow-sm">
            <h3 class="font-bold text-slate-800 text-base mb-4 flex items-center gap-2 pb-3 border-b border-slate-100">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v5m-3 0h6M4 6h16M4 6a4 4 0 004 4h8a4 4 0 004-4M4 6v2a6 6 0 0012 0V6"></path>
                </svg>
                Lomba & Moving
            </h3>
            <div class="space-y-4">
                @forelse($lombaTerbaru as $lomba)
                    <div class="flex items-center justify-between gap-3 hover:bg-slate-50 p-2.5 rounded-xl transition duration-150">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-slate-700 text-sm truncate">
                                {{ $lomba->title }}
                            </p>
                            <p class="text-[10px] text-slate-400 mt-1 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $lomba->release_date->format('d M Y') }}
                            </p>
                        </div>
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold tracking-wider uppercase {{ $lomba->status_color }}">
                            {{ $lomba->status_label }}
                        </span>
                    </div>
                @empty
                    <p class="text-slate-400 text-sm text-center py-6">
                        Belum ada lomba terbaru
                    </p>
                @endforelse
            </div>
        </div>

        {{-- Pendaftaran --}}
        <div class="bg-white rounded-2xl border border-slate-200/60 p-5 shadow-sm">
            <h3 class="font-bold text-slate-800 text-base mb-4 flex items-center gap-2 pb-3 border-b border-slate-100">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Registrasi Lomba Terbaru
            </h3>
            <div class="space-y-4">
                @forelse($pendaftaranTerbaru as $item)
                    <div class="flex items-start justify-between gap-3 hover:bg-slate-50 p-2.5 rounded-xl transition duration-150">
                        <div class="min-w-0">
                            <p class="font-semibold text-slate-700 text-sm truncate">
                                {{ $item->name }}
                            </p>
                            <p class="text-xs text-slate-500 truncate mt-0.5">
                                {{ $item->lomba->title }}
                            </p>
                            <p class="text-[10px] text-slate-400 mt-1 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $item->created_at->diffForHumans() }}
                            </p>
                        </div>
                        @if ($item->status == 'approved')
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Approved
                            </span>
                        @elseif($item->status == 'pending')
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-amber-50 text-amber-700 text-[10px] font-bold uppercase border border-amber-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Pending
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-rose-50 text-rose-700 text-[10px] font-bold uppercase border border-rose-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                Rejected
                            </span>
                        @endif
                    </div>
                @empty
                    <p class="text-slate-400 text-sm text-center py-6">
                        Belum ada pendaftaran terbaru
                    </p>
                @endforelse
            </div>
        </div>
    </div>


    {{-- Modal Pengaturan Halaman Home --}}
    <div id="homeModal" class="fixed inset-0 hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm z-50 p-4 md:p-6 transition-all duration-300">
        <div class="bg-white rounded-2xl w-full max-w-7xl max-h-[92vh] overflow-y-auto shadow-2xl flex flex-col border border-slate-100 animate-in fade-in-50 zoom-in-95 duration-200">
            {{-- Header --}}
            <div class="bg-[#0B1A40] text-white px-8 py-5 flex items-center justify-between sticky top-0 z-10">
                <div>
                    <h2 class="text-lg font-bold tracking-tight">⚙️ Pengaturan Halaman Utama</h2>
                    <p class="text-slate-300 text-xs mt-0.5">Kelola Hero Banner dan Running Text Website</p>
                </div>
                <button onclick="closeHomeModal()"
                    class="w-8 h-8 rounded-lg bg-white/10 hover:bg-rose-600 transition flex items-center justify-center text-xl cursor-pointer">
                    &times;
                </button>
            </div>

            <div class="p-6 md:p-8 space-y-8 flex-1">
                <div class="grid grid-cols-1 xl:grid-cols-5 gap-8">
                    {{-- HERO BANNER --}}
                    <div class="xl:col-span-2 space-y-6">
                        <div class="bg-slate-50 border border-slate-200/60 rounded-2xl p-5">
                            <h3 class="text-base font-bold text-slate-800 pb-2 border-b border-slate-200">Hero Banner</h3>
                            <p class="text-xs text-slate-400 mt-1 mb-4">Maksimal 3 banner utama dipublikasikan secara bergantian.</p>

                            <div class="space-y-5">
                                @for ($i = 1; $i <= 3; $i++)
                                    @php
                                        $hero = $heroes->firstWhere('sort_order', $i);
                                    @endphp

                                    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                                        <img src="{{ $hero ? asset('storage/' . $hero->image) : 'https://placehold.co/700x350?text=Hero+' . $i }}"
                                            class="w-full h-32 object-cover">

                                        <div class="p-4">
                                            <h4 class="font-bold text-sm text-slate-800">Banner {{ $i }}</h4>

                                            @if ($hero)
                                                <p class="font-semibold text-xs text-slate-600 mt-2 truncate">{{ $hero->title }}</p>
                                                <p class="text-[11px] text-slate-400 mt-1 line-clamp-2 leading-relaxed">{{ $hero->description }}</p>
                                            @else
                                                <p class="text-xs text-slate-300 mt-2 italic">Belum ada konten banner</p>
                                            @endif

                                            <div class="flex gap-2 mt-4">
                                                @if ($hero)
                                                    <button onclick='editHero(@json($hero))'
                                                        class="flex-1 rounded-lg bg-[#0B1A40] hover:bg-[#1E3A8A] text-xs font-semibold py-2 text-white transition cursor-pointer">
                                                        Edit Konten
                                                    </button>

                                                    <form action="{{ route('dashboard.hero.destroy', $hero) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button onclick="return confirm('Hapus banner ini?')"
                                                            class="px-3 py-2 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-100 transition cursor-pointer"
                                                            title="Hapus">
                                                            🗑️
                                                        </button>
                                                    </form>
                                                @else
                                                    <button onclick="openHeroModal({{ $i }})"
                                                        class="w-full rounded-lg bg-[#0B1A40] hover:bg-[#1E3A8A] text-xs font-semibold py-2 text-white transition cursor-pointer">
                                                        + Tambah Konten
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    {{-- RUNNING TEXT --}}
                    <div class="xl:col-span-3 space-y-6">
                        <div class="bg-slate-50 border border-slate-200/60 rounded-2xl p-5">
                            <h3 class="text-base font-bold text-slate-800 pb-2 border-b border-slate-200">Running Text</h3>
                            <p class="text-xs text-slate-400 mt-1 mb-4">Tambahkan informasi teks berjalan di bagian bawah menu utama portal.</p>

                            <form action="{{ route('dashboard.runningtext.store') }}" method="POST">
                                @csrf
                                <textarea name="running_text" rows="3" placeholder="Tulis pengumuman atau teks penting di sini..."
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 resize-none">{{ old('running_text') }}</textarea>

                                <div class="mt-3 flex justify-end">
                                    <button class="rounded-xl bg-[#0B1A40] hover:bg-[#1E3A8A] px-5 py-2.5 text-xs font-semibold text-white transition cursor-pointer">
                                        Simpan Running Text
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- LIST RUNNING TEXT --}}
                        <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden">
                            <div class="flex items-center justify-between p-4 bg-slate-50 border-b">
                                <h3 class="font-bold text-sm text-slate-800">Daftar Teks Berjalan</h3>
                                <span class="rounded-full bg-blue-50 border border-blue-100 px-3 py-0.5 text-xs font-bold text-blue-700">
                                    {{ $setting->count() }} Data
                                </span>
                            </div>

                            <div class="max-h-[350px] overflow-y-auto p-4 space-y-3 divide-y divide-slate-100">
                                @forelse($setting as $item)
                                    <div class="pt-3 first:pt-0 flex justify-between items-start gap-4">
                                        <div class="flex-1">
                                            <p class="text-sm text-slate-600 leading-relaxed">{{ $item->running_text }}</p>
                                            <span class="text-[10px] text-slate-400 block mt-1.5">{{ $item->created_at->format('d M Y H:i') }} WIB</span>
                                        </div>
                                        <form action="{{ route('dashboard.runningtext.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus teks ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="rounded-lg text-xs bg-rose-50 border border-rose-100 hover:bg-rose-100 text-rose-600 px-3 py-1.5 transition cursor-pointer">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                @empty
                                    <div class="py-10 text-center text-slate-400 text-xs italic">
                                        Belum ada data Running Text.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Input Modal -->
    <div id="heroModal" class="fixed inset-0 hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm z-[60] p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-slate-100 animate-in fade-in-50 zoom-in-95 duration-200">
            <!-- Header -->
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 bg-slate-50">
                <h2 id="heroModalTitle" class="text-sm font-bold text-slate-800">Tambah Hero</h2>
                <button onclick="closeHeroModal()" class="text-2xl text-slate-400 hover:text-slate-600 cursor-pointer">&times;</button>
            </div>

            <form id="heroForm" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
                @csrf
                <input type="hidden" id="hero_method" name="_method" value="POST">
                <input type="hidden" id="sort_order" name="sort_order">

                <!-- Judul -->
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Judul Hero</label>
                    <input id="hero_title" type="text" name="title" required
                        class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Deskripsi</label>
                    <textarea id="hero_description" name="description" rows="3" required
                        class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 resize-none"></textarea>
                </div>

                <!-- Upload -->
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Upload Gambar Banner</label>
                    <input id="hero_image" type="file" name="image" accept="image/*" onchange="previewHero(event)"
                        class="w-full text-xs text-slate-500 border border-slate-200 rounded-xl bg-white
                        file:mr-4 file:border-0 file:bg-[#0B1A40] file:text-white file:px-4 file:py-2.5 file:rounded-l-xl file:font-semibold hover:file:bg-[#1E3A8A] file:cursor-pointer">
                </div>

                <!-- Preview -->
                <div>
                    <span class="block text-[10px] font-semibold text-slate-400 uppercase mb-2">Preview Gambar</span>
                    <img id="hero_preview" src="https://placehold.co/500x220?text=Preview" class="w-full h-28 rounded-xl border object-cover">
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-2 border-t border-slate-100 pt-4">
                    <button type="button" onclick="closeHeroModal()" class="rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 px-4 py-2 text-xs font-semibold cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="rounded-xl bg-[#0B1A40] hover:bg-[#1E3A8A] px-4 py-2 text-xs font-semibold text-white transition cursor-pointer">
                        Simpan Konten
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openHomeModal() {
            const modal = document.getElementById('homeModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeHomeModal() {
            const modal = document.getElementById('homeModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        // Close on click outside for homeModal
        document.getElementById('homeModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeHomeModal();
            }
        });

        // Close on click outside for heroModal
        document.getElementById('heroModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeHeroModal();
            }
        });

        function openHeroModal(sort) {
            document.getElementById('heroModal').classList.remove('hidden');
            document.getElementById('heroModal').classList.add('flex');
            document.getElementById('heroModalTitle').innerHTML = "Tambah Banner Baru";
            document.getElementById('heroForm').action = "{{ route('dashboard.hero.store') }}";
            document.getElementById('hero_method').value = "POST";
            document.getElementById('sort_order').value = sort;
            document.getElementById('hero_title').value = "";
            document.getElementById('hero_description').value = "";
            document.getElementById('hero_image').required = true;
            document.getElementById('hero_preview').src = "https://placehold.co/600x300?text=Preview";
        }

        function editHero(hero) {
            document.getElementById('heroModal').classList.remove('hidden');
            document.getElementById('heroModal').classList.add('flex');
            document.getElementById('heroModalTitle').innerHTML = "Edit Banner Konten";
            document.getElementById('heroForm').action = "/dashboard/heroes/" + hero.id;
            document.getElementById('hero_method').value = "PUT";
            document.getElementById('sort_order').value = hero.sort_order;
            document.getElementById('hero_title').value = hero.title;
            document.getElementById('hero_description').value = hero.description ?? "";
            document.getElementById('hero_image').required = false;
            document.getElementById('hero_preview').src = "/storage/" + hero.image;
        }

        function closeHeroModal() {
            document.getElementById('heroModal').classList.remove('flex');
            document.getElementById('heroModal').classList.add('hidden');
        }

        function previewHero(event) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('hero_preview').src = e.target.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function showToast(id) {
            const toast = document.getElementById(id);
            if (!toast) return;
            setTimeout(() => {
                toast.style.transform = "translateX(0)";
            }, 100);
            setTimeout(() => {
                closeToast(id);
            }, 5000);
        }

        function closeToast(id) {
            const toast = document.getElementById(id);
            if (!toast) return;
            toast.style.transform = "translateX(120%)";
            toast.style.opacity = "0";
            setTimeout(() => toast.remove(), 300);
        }

        @if (session('success'))
            showToast("toastSuccess");
        @endif

        @if ($errors->any())
            showToast("toastError");
        @endif

        @if (session('openHomeModal'))
            document.addEventListener('DOMContentLoaded', function() {
                openHomeModal();
            });
        @endif
    </script>
@endsection
