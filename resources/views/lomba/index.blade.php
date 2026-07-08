@extends('layouts.app')

@section('title', 'Kelola Engagement')
@section('page-title', 'Kelola Engagement')

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
                    toast.style.transition = 'all .5s ease';
                    toast.style.transform = 'translateX(100%)';
                    toast.style.opacity = '0';

                    setTimeout(() => toast.remove(), 500);
                }
            }, 4000);
        </script>
    @endif

    <div class="space-y-6">
        {{-- Header --}}
        <div class="bg-white rounded-xl shadow-sm border-l-4 border-[#CF1A25] p-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-[#1C3281]">
                        Kelola Engagement
                    </h3>

                    <p class="text-gray-500 mt-1">
                        Kelola seluruh data Engagement dan kompetisi Bank Indonesia.
                    </p>
                </div>
                <a href="{{ route('lomba.create') }}"
                    class="bg-[#1C3281] hover:bg-blue-900 text-white px-4 py-2 md:px-5 md:py-3 rounded-lg font-semibold transition">
                    + Tambah Engagement
                </a>
            </div>
        </div>

        {{-- Search & Filter --}}
        <div class="bg-white rounded-xl shadow-sm p-4">
            <form method="GET" action="{{ route('lomba.index') }}">

                <div class="flex flex-col md:flex-row gap-3">

                    {{-- Search Judul --}}
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari judul lomba..."
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#1C3281] focus:outline-none">
                    </div>

                    {{-- Filter Kategori --}}
                    <div class="md:w-60">
                        <select name="kategori_id"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#1C3281] focus:outline-none">

                            <option value="">
                                Semua Kategori
                            </option>

                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}"
                                    {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tombol Cari --}}
                    <button type="submit"
                        class="bg-[#1C3281] hover:bg-blue-900 text-white px-6 py-3 rounded-lg font-semibold transition">
                        Cari
                    </button>
                    {{-- Tombol Reset --}}
                    <a href="{{ route('lomba.index') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold transition text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow-sm overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#1C3281] text-white">
                    <tr>
                        <th class="px-6 py-4 text-left">
                            Thumbnail
                        </th>
                        <th class="px-6 py-4 text-left">
                            Judul
                        </th>
                        <th class="px-6 py-4 text-left">
                            Kategori
                        </th>
                        <th class="px-6 py-4 text-left">
                            Tanggal Rilis
                        </th>
                        <th class="px-6 py-4 text-left">
                            Tanggal Berakhir
                        </th>
                        <th class="px-6 py-4 text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lombas as $lomba)
                        <tr class="border-b hover:bg-slate-50">
                            <td class="px-6 py-4">
                                @if ($lomba->thumbnail)
                                    <img src="{{ asset('storage/' . $lomba->thumbnail) }}"
                                        class="w-20 h-12 object-cover rounded">
                                @else
                                    <div class="w-20 h-12 bg-gray-200 rounded"></div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <h4 class="font-semibold text-gray-800">
                                    {{ $lomba->title }}
                                </h4>
                            </td>
                            <td>
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                                    {{ $lomba->kategori->name ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $lomba->release_date ? \Carbon\Carbon::parse($lomba->release_date)->format('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $lomba->end_date ? \Carbon\Carbon::parse($lomba->end_date)->format('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <button
                                        onclick="openDetailModal(
                                            @js($lomba->title),
                                            @js($lomba->kategori?->name),
                                            @js($lomba->description),
                                            @js($lomba->location_type),
                                            @js($lomba->location),
                                            '{{ $lomba->thumbnail ? asset('storage/' . $lomba->thumbnail) : '' }}',
                                            '{{ $lomba->release_date?->format('d M Y') }}',
                                            '{{ $lomba->end_date?->format('d M Y') }}',
                                            @js($lomba->status_label),
                                            @js($lomba->status_color)
                                        )"
                                        class="bg-green-100 text-green-700 px-3 py-2 rounded-lg hover:bg-green-200">
                                        Detail
                                    </button>
                                    {{-- edit lomba --}}
                                    <a href="{{ route('lomba.edit', $lomba->id) }}"
                                        class="bg-blue-100 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-200">
                                        Edit
                                    </a>
                                    {{-- hapus lomba --}}
                                    <button
                                        onclick="openDeleteModal(
                                            '{{ $lomba->id }}',
                                            '{{ $lomba->title }}'
                                        )"
                                        class="bg-red-100 text-red-700 px-3 py-2 rounded-lg hover:bg-red-200">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-gray-500">
                                Belum ada data lomba
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div>
            {{ $lombas->links() }}
        </div>

    </div>

    {{-- Modal Detail Lomba --}}
    <div id="detailModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center p-4 z-50">

        <div class="bg-white rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto shadow-2xl">

            {{-- Header --}}
            <div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center rounded-t-2xl">

                <h3 class="text-2xl font-bold text-[#1C3281]">
                    Detail Lomba
                </h3>

                <button onclick="closeDetailModal()" class="text-2xl text-gray-500 hover:text-red-500">
                    ✕
                </button>

            </div>

            <div class="p-6">

                {{-- Thumbnail --}}
                <img id="detail_image" class="w-full h-72 object-cover rounded-xl border mb-6">

                {{-- Judul --}}
                <h2 id="detail_title" class="text-3xl font-bold text-[#1C3281] mb-4">
                </h2>

                {{-- Kategori --}}
                <div class="mb-5">
                    <span id="detail_kategori"
                        class="inline-block bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">
                    </span>

                    {{-- <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $lomba->status_color }}">
                        {{ $lomba->status_label }}
                    </span> --}}
                    <span id="detail_status" class="px-3 py-1 rounded-full text-sm font-semibold">
                    </span>
                </div>

                {{-- Informasi --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

                    <div class="bg-slate-50 rounded-xl p-4 border">
                        <p class="text-sm text-gray-500">
                            📅 Tanggal Mulai
                        </p>

                        <p id="detail_release" class="font-semibold">
                        </p>
                    </div>

                    <div class="bg-slate-50 rounded-xl p-4 border">
                        <p class="text-sm text-gray-500">
                            🏁 Tanggal Berakhir
                        </p>

                        <p id="detail_end" class="font-semibold">
                        </p>
                    </div>

                    <div class="bg-slate-50 rounded-xl p-4 border">
                        <p class="text-sm text-gray-500">
                            🌐 Tipe Lomba
                        </p>

                        <p id="detail_location_type" class="font-semibold capitalize">
                        </p>
                    </div>

                    <div class="bg-slate-50 rounded-xl p-4 border">
                        <p class="text-sm text-gray-500">
                            📍 Lokasi
                        </p>

                        <p id="detail_location" class="font-semibold">
                        </p>
                    </div>

                </div>

                {{-- Deskripsi --}}
                <div>

                    <h4 class="text-xl font-semibold text-[#1C3281] mb-3">
                        Deskripsi Lomba
                    </h4>

                    <div id="detail_description" class="border rounded-xl p-5 leading-8 bg-gray-50 whitespace-pre-line">
                    </div>

                </div>

            </div>

        </div>

    </div>
    {{-- End Modal Detail --}}

    {{-- Modal Hapus --}}
    <div id="deleteModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <h3 class="text-xl font-bold text-[#CF1A25] mb-3">
                Hapus Lomba
            </h3>
            <p class="text-gray-600 mb-5">
                Apakah Anda yakin ingin menghapus:
                <span id="deleteTitle" class="font-semibold text-gray-800"></span>?
            </p>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 rounded-lg border">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-[#CF1A25] text-white rounded-lg hover:bg-red-700">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
    {{-- End Modal Hapus --}}
    <script>
        // detail Modal
        function openDetailModal(
            title,
            kategori,
            description,
            locationType,
            location,
            image,
            releaseDate,
            endDate,
            statusLabel,
            statusColor
        ) {
            const status = document.getElementById('detail_status');

            status.innerText = statusLabel;
            status.className =
                `px-3 py-1 rounded-full text-sm font-semibold ${statusColor}`;

            document.getElementById('detail_title').innerText = title;

            document.getElementById('detail_kategori').innerText =
                kategori ?? '-';

            document.getElementById('detail_description').innerText =
                description ?? '-';

            document.getElementById('detail_location_type').innerText =
                locationType ?? '-';

            document.getElementById('detail_location').innerText =
                location ?? '-';

            document.getElementById('detail_release').innerText =
                releaseDate ?? '-';

            document.getElementById('detail_end').innerText =
                endDate ?? '-';

            const img = document.getElementById('detail_image');

            if (image) {
                img.src = image;
                img.classList.remove('hidden');
            } else {
                img.classList.add('hidden');
            }

            document.getElementById('detailModal')
                .classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('detailModal')
                .classList.add('hidden');
        }

        // Delete
        function openDeleteModal(id, title) {
            document.getElementById('deleteTitle').innerText = title;

            document.getElementById('deleteForm').action =
                `/lomba/${id}`;

            document.getElementById('deleteModal')
                .classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal')
                .classList.add('hidden');
        }
    </script>
@endsection
