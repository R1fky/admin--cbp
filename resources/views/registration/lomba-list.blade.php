@extends('layouts.app')

@section('title', 'Daftar Peserta Lomba')
@section('page-title', 'Kelola Peserta Lomba')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($lombas as $lomba)
            <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm hover:shadow-md transition duration-150 flex flex-col justify-between overflow-hidden">
                {{-- Header --}}
                <div class="bg-gradient-to-r from-[#0B1A40] to-[#1E3A8A] p-5 text-white">
                    <h2 class="text-sm font-bold truncate leading-relaxed">
                        {{ $lomba->title }}
                    </h2>
                    <p class="text-[10px] text-[#C5A85C] uppercase tracking-wider font-semibold mt-1">
                        {{ $lomba->release_date ? \Carbon\Carbon::parse($lomba->release_date)->format('d M Y') : '-' }}
                    </p>
                </div>

                {{-- Body --}}
                <div class="p-5 flex-1 flex flex-col justify-between space-y-5">
                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-3">
                        {{ Str::limit(strip_tags($lomba->description), 120) }}
                    </p>

                    <div class="flex justify-between items-end pt-3 border-t border-slate-100">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                Terdaftar
                            </p>
                            <p class="text-2xl font-extrabold text-[#0B1A40] mt-0.5">
                                {{ $lomba->registrations_count }} <span class="text-xs font-semibold text-slate-400">Peserta</span>
                            </p>
                        </div>

                        <div>
                            @if ($lomba->status == 'ongoing')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase border border-emerald-100">
                                    Berlangsung
                                </span>
                            @elseif($lomba->status == 'upcoming')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md bg-amber-50 text-amber-700 text-[10px] font-bold uppercase border border-amber-100">
                                    Akan Datang
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md bg-rose-50 text-rose-700 text-[10px] font-bold uppercase border border-rose-100">
                                    Ditutup
                                </span>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('registration.index', $lomba) }}"
                        class="w-full inline-flex justify-center items-center gap-1.5 rounded-xl bg-[#0B1A40] hover:bg-[#1E3A8A] text-white py-2.5 text-xs font-bold transition shadow-sm">
                        Lihat Peserta
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 12h14"></path>
                        </svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-2xl border border-slate-200/60 p-12 text-center shadow-sm">
                    <p class="text-slate-400 text-xs italic">
                        Belum ada program / lomba yang tersedia saat ini.
                    </p>
                </div>
            </div>
        @endforelse
    </div>
@endsection
