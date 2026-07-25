@extends('layouts.app')

@section('title', 'Daftar Peserta')
@section('page-title', 'Daftar Peserta Lomba')

@section('content')
    {{-- Toast Success --}}
    @if (session('success'))
        <div id="toastSuccess"
            class="fixed top-6 right-6 z-50 bg-white border border-slate-200/80 shadow-2xl rounded-xl px-5 py-4 min-w-[320px] transition-all duration-300">
            <div class="flex items-start gap-3">
                <div class="bg-emerald-100 text-emerald-700 p-1.5 rounded-lg">
                    ✓
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-sm text-slate-800">Berhasil</h4>
                    <p class="text-slate-500 text-xs mt-0.5">{{ session('success') }}</p>
                </div>
                <button onclick="document.getElementById('toastSuccess').remove()" class="text-slate-400 hover:text-slate-600 font-bold">&times;</button>
            </div>
        </div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('toastSuccess');
                if (toast) {
                    toast.style.transform = 'translateY(-20px)';
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 300);
                }
            }, 4000);
        </script>
    @endif

    <div class="space-y-6">
        {{-- Header Card --}}
        <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6">
            <div class="flex-1 min-w-0">
                @php
                    $percentage = $lomba->max_participants > 0
                        ? ($lomba->current_participants / $lomba->max_participants) * 100
                        : 0;
                @endphp

                <h2 class="text-lg font-bold text-slate-800 tracking-tight leading-relaxed truncate">
                    {{ $lomba->title }}
                </h2>

                <div class="mt-3 flex flex-wrap gap-2">
                    {{-- Jumlah Peserta --}}
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-blue-50 border border-blue-100 text-blue-700 text-xs font-bold uppercase">
                        👥 {{ $lomba->current_participants }} / {{ $lomba->max_participants }} Peserta
                    </span>

                    {{-- Sisa Kuota --}}
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-xs font-bold uppercase border {{ $lomba->is_full ? 'bg-rose-50 border-rose-100 text-rose-700' : 'bg-emerald-50 border-emerald-100 text-emerald-700' }}">
                        {{ $lomba->is_full ? 'Kuota Penuh' : 'Sisa ' . $lomba->remaining_quota . ' Kuota' }}
                    </span>
                </div>
            </div>

            {{-- Progress bar --}}
            <div class="w-full xl:w-80 space-y-2">
                <div class="flex justify-between items-center text-xs">
                    <span class="font-semibold text-slate-500">Progress Isian Kuota</span>
                    <span class="font-bold text-slate-700">{{ round($percentage) }}%</span>
                </div>
                <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden border border-slate-200/40">
                    <div class="h-full rounded-full transition-all duration-500
                        {{ $percentage < 50 ? 'bg-emerald-500' : ($percentage < 85 ? 'bg-blue-500' : ($percentage < 100 ? 'bg-amber-500' : 'bg-rose-500')) }}"
                        style="width: {{ min($percentage, 100) }}%">
                    </div>
                </div>
            </div>

            <a href="{{ route('lomba.index') }}" class="bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-700 px-5 py-2.5 rounded-xl text-xs font-semibold transition shrink-0">
                ← Kembali
            </a>
        </div>

        {{-- Search and Filter --}}
        <div class="bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm">
            <form method="GET">
                <div class="flex flex-col xl:flex-row gap-3">
                    {{-- Search Input --}}
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama atau email peserta..." class="w-full pl-9 pr-4 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 text-xs">
                    </div>

                    {{-- Filter Dropdown --}}
                    <div class="xl:w-52">
                        <select name="status" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 bg-white">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    {{-- Action buttons --}}
                    <div class="flex flex-wrap gap-2">
                        <button class="bg-[#0B1A40] hover:bg-[#1E3A8A] text-white px-5 py-2.5 rounded-xl text-xs font-semibold transition cursor-pointer">
                            Cari
                        </button>
                        <a href="{{ route('registration.index', $lomba) }}"
                            class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-xl text-xs font-semibold transition text-center flex items-center justify-center">
                            Reset
                        </a>
                        <a href="{{ route('registration.export', [
                            'lomba' => $lomba,
                            'search' => request('search'),
                            'status' => request('status'),
                        ]) }}"
                            class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-xs font-semibold transition text-center shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export Excel
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left">
                    <thead class="bg-slate-50 border-b border-slate-200/80">
                        <tr>
                            <th class="px-6 py-4 text-slate-500 text-[11px] font-bold uppercase tracking-wider">
                                Nama Peserta / Alamat
                            </th>
                            <th class="px-6 py-4 text-slate-500 text-[11px] font-bold uppercase tracking-wider">
                                Email
                            </th>
                            <th class="px-6 py-4 text-slate-500 text-[11px] font-bold uppercase tracking-wider">
                                No HP
                            </th>
                            <th class="px-6 py-4 text-slate-500 text-[11px] font-bold uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-slate-500 text-[11px] font-bold uppercase tracking-wider text-center">
                                File Lampiran
                            </th>
                            <th class="px-6 py-4 text-slate-500 text-[11px] font-bold uppercase tracking-wider text-center">
                                Aksi Validasi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($registrations as $item)
                            <tr class="hover:bg-slate-50/80 transition duration-150">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-700 text-xs">
                                        {{ $item->name }}
                                    </div>
                                    <div class="text-[10px] text-slate-400 mt-1">
                                        📍 {{ $item->address }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-500">
                                    {{ $item->email }}
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-500">
                                    {{ $item->phone }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($item->status == 'pending')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md bg-amber-50 text-amber-700 text-[10px] font-bold uppercase border border-amber-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Pending
                                        </span>
                                    @elseif($item->status == 'approved')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase border border-emerald-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Approved
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md bg-rose-50 text-rose-700 text-[10px] font-bold uppercase border border-rose-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center text-xs">
                                    @if ($item->file)
                                        <a href="{{ asset('storage/' . $item->file) }}" target="_blank"
                                            class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 font-semibold hover:underline">
                                            Lihat Berkas
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                    @else
                                        <span class="text-slate-300 italic">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center items-center gap-1.5">
                                        {{-- Approve --}}
                                        <form action="{{ route('registration.update', $item) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button class="px-2.5 py-1.5 rounded-lg border border-emerald-100 hover:bg-emerald-100 text-emerald-700 bg-emerald-50 text-[10px] font-bold uppercase tracking-wider transition cursor-pointer">
                                                Approve
                                            </button>
                                        </form>

                                        {{-- Reject --}}
                                        <form action="{{ route('registration.update', $item) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button class="px-2.5 py-1.5 rounded-lg border border-rose-100 hover:bg-rose-100 text-rose-700 bg-rose-50 text-[10px] font-bold uppercase tracking-wider transition cursor-pointer">
                                                Reject
                                            </button>
                                        </form>

                                        {{-- Reset to Pending --}}
                                        @if ($item->status != 'pending')
                                            <form action="{{ route('registration.update', $item) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="pending">
                                                <button class="px-2.5 py-1.5 rounded-lg border border-amber-100 hover:bg-amber-100 text-amber-700 bg-amber-50 text-[10px] font-bold uppercase tracking-wider transition cursor-pointer">
                                                    Pending
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-12 text-slate-400 text-xs italic">
                                    Belum ada peserta yang mendaftar pada program ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $registrations->links() }}
        </div>
    </div>
@endsection
