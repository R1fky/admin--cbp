@extends('layouts.app')

@section('title', 'Daftar Peserta')
@section('page-title', 'Daftar Peserta Lomba')

@section('content')
    @if (session('success'))
        <div id="toastSuccess"
            class="fixed top-5 right-5 z-50 bg-white border-l-4 border-green-500 shadow-xl rounded-xl px-5 py-4 min-w-[320px]">
            <div class="flex items-start gap-3">
                <div class="bg-green-100 p-2 rounded-full">
                    ✅
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-800">
                        Berhasil
                    </h4>
                    <p class="text-gray-600 text-sm">
                        {{ session('success') }}
                    </p>
                </div>
                <button onclick="document.getElementById('toastSuccess').remove()" class="text-gray-400 hover:text-gray-600">
                    ✕
                </button>
            </div>
        </div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('toastSuccess');
                if (toast) {
                    toast.style.transition = 'all .4s';
                    toast.style.transform = 'translateX(120%)';
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 400);

                }
            }, 4000);
        </script>
    @endif
    <div class="bg-white rounded-xl shadow">
        <!-- Header -->
        <div class="border-b p-6 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    {{ $lomba->title }}
                </h2>
                <p class="text-gray-500 mt-1">
                    Total Peserta :
                    <span class="font-semibold">
                        {{ $registrations->total() }}
                    </span>
                </p>
            </div>
            <a href="{{ route('registration.lomba') }}" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">
                ← Kembali
            </a>
        </div>

        {{-- Search and Filter --}}
        <div class="bg-white rounded-xl shadow-sm p-4 mb-5">
            <form method="GET">
                <div class="flex flex-col md:flex-row gap-3">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama atau email..." class="w-full border rounded-lg px-4 py-3">
                    </div>
                    <div class="md:w-52">
                        <select name="status" class="w-full border rounded-lg px-4 py-3">
                            <option value="">
                                Semua Status
                            </option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                Approved
                            </option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                Rejected
                            </option>
                        </select>
                    </div>
                    <button class="bg-[#1C3281] hover:bg-blue-900 text-white px-6 rounded-lg">
                        Cari
                    </button>
                    <a href="{{ route('registration.index', $lomba) }}"
                        class="bg-gray-200 hover:bg-gray-300 px-6 rounded-lg flex items-center">
                        Reset
                    </a>
                    
                    <a href="{{ route('registration.export', [
                        'lomba' => $lomba->id,
                        'search' => request('search'),
                        'status' => request('status'),
                    ]) }}"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 rounded-lg flex items-center">
                        Export Excel
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            Nama
                        </th>
                        <th class="px-6 py-3 text-left">
                            Email
                        </th>
                        <th class="px-6 py-3 text-left">
                            No HP
                        </th>
                        <th class="px-6 py-3 text-left">
                            Status
                        </th>
                        <th class="px-6 py-3 text-center">
                            File
                        </th>
                        <th class="px-6 py-3 text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-semibold">
                                    {{ $item->name }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $item->address }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->email }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->phone }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($item->status == 'pending')
                                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm">
                                        Pending
                                    </span>
                                @elseif($item->status == 'approved')
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                                        Approved
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">
                                        Rejected
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($item->file)
                                    <a href="{{ asset('storage/' . $item->file) }}" target="_blank"
                                        class="text-blue-600 hover:underline">
                                        Lihat File
                                    </a>
                                @else
                                    <span class="text-gray-400">
                                        -
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">

                                <div class="flex gap-2">

                                    <form action="{{ route('registration.update', $item) }}" method="POST">

                                        @csrf
                                        @method('PATCH')

                                        <input type="hidden" name="status" value="approved">

                                        <button
                                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-sm">

                                            Approve

                                        </button>

                                    </form>

                                    <form action="{{ route('registration.update', $item) }}" method="POST">

                                        @csrf
                                        @method('PATCH')

                                        <input type="hidden" name="status" value="rejected">

                                        <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-sm">

                                            Reject

                                        </button>

                                    </form>

                                    @if ($item->status != 'pending')
                                        <form action="{{ route('registration.update', $item) }}" method="POST">

                                            @csrf
                                            @method('PATCH')

                                            <input type="hidden" name="status" value="pending">

                                            <button
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg text-sm">

                                                Pending

                                            </button>

                                        </form>
                                    @endif

                                </div>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-500">
                                Belum ada peserta yang mendaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-6">
        {{ $registrations->links() }}
    </div>
@endsection
