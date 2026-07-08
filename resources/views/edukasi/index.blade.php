@extends('layouts.app')

@section('title', 'Education')
@section('page-title', 'Kelola Education')

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
                        Kelola Education
                    </h3>

                    <p class="text-gray-500 mt-1">
                        Kelola seluruh data Education dan kompetisi Bank Indonesia.
                    </p>
                </div>
                <a href="{{ route('edukasi.create') }}"
                    class="bg-[#1C3281] hover:bg-blue-900 text-white px-4 py-2 md:px-5 md:py-3 rounded-lg font-semibold transition">
                    + Tambah edukasi
                </a>

            </div>

        </div>

        {{-- Search & Filter --}}
        <div class="bg-white rounded-xl shadow-sm p-4">
            <form method="GET" action="{{ route('edukasi.index') }}">

                <div class="flex flex-col md:flex-row gap-3">

                    {{-- Search Judul --}}
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari judul edukasi..."
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#1C3281] focus:outline-none">
                    </div>

                    {{-- Tombol Cari --}}
                    <button type="submit"
                        class="bg-[#1C3281] hover:bg-blue-900 text-white px-6 py-3 rounded-lg font-semibold transition">
                        Cari
                    </button>
                    {{-- Tombol Reset --}}
                    <a href="{{ route('edukasi.index') }}"
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
                            Judul
                        </th>
                        <th class="px-6 py-4 text-left">
                            file
                        </th>
                        <th class="px-6 py-4 text-left">
                            Link
                        </th>
                        <th class="px-6 py-4 text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($edukasis as $edukasi)
                        <tr class="border-b hover:bg-slate-50">
                            <td class="px-6 py-4">
                                <h4 class="font-semibold">
                                    {{ $edukasi->judul }}
                                </h4>

                                <p class="text-sm text-gray-500 mt-1">
                                    {{ Str::limit($edukasi->deskripsi, 80) }}
                                </p>
                            </td>

                            {{-- FILE ATAU PHOTO --}}
                            <td class="px-6 py-4">
                                @if ($edukasi->file)
                                    @php
                                        $ext = pathinfo($edukasi->file, PATHINFO_EXTENSION);
                                    @endphp

                                    @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']))
                                        <img src="{{ asset('storage/' . $edukasi->file) }}"
                                            class="w-20 h-20 object-cover rounded">
                                    @elseif($ext == 'pdf')
                                        <span class="bg-red-100 text-red-600 px-3 py-2 rounded-lg">
                                            📄 PDF
                                        </span>
                                    @endif
                                @else
                                    <span class="text-gray-400">
                                        Tidak ada file
                                    </span>
                                @endif
                            </td>
                            {{-- LINK  --}}
                            <td class="px-6 py-4">

                                @if ($edukasi->link)
                                    <a href="{{ $edukasi->link }}" target="_blank" class="text-blue-600 hover:underline">
                                        Buka Link
                                    </a>
                                @else
                                    -
                                @endif

                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <button
                                        onclick="openDetailModal(
                                            @js($edukasi->judul),
                                            @js($edukasi->deskripsi),
                                            @js($edukasi->link),
                                            @js($edukasi->file)
                                        )"
                                        class="bg-green-100 text-green-700 px-3 py-2 rounded-lg hover:bg-green-200">
                                        Detail
                                    </button>
                                    {{-- edit edukasi --}}
                                    <a href="{{ route('edukasi.edit', $edukasi->id) }}"
                                        class="bg-blue-100 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-200">
                                        Edit
                                    </a>
                                    {{-- hapus edukasi --}}
                                    <button
                                        onclick="openDeleteModal(
                                            '{{ $edukasi->id }}',
                                            '{{ $edukasi->judul }}'
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
                                Belum ada data edukasi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div>
            {{ $edukasis->links() }}
        </div>

    </div>

    {{-- Modal Detail --}}
    <div id="detailModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl w-full max-w-3xl shadow-xl">
            <div class="border-b p-5 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-[#1C3281]">
                    Detail Edukasi
                </h3>
                <button onclick="closeDetailModal()" class="text-2xl text-gray-500 hover:text-red-500">
                    ✕
                </button>
            </div>
            <div class="p-6">
                <div id="previewContainer" class="mb-5"></div>
                <h2 id="detail_title" class="text-2xl font-bold text-[#1C3281] mb-4">
                </h2>
                <div class="mb-5">
                    <h4 class="font-semibold mb-2">
                        Deskripsi
                    </h4>
                    <p id="detail_deskripsi" class="text-gray-700 leading-7">
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold mb-2">
                        Link
                    </h4>
                    <a id="detail_link" target="_blank" class="text-blue-600 hover:underline break-all">
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Detail --}}

    {{-- Modal Hapus edukasi --}}
    <div id="deleteModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <h3 class="text-xl font-bold text-[#CF1A25] mb-3">
                Hapus edukasi
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
    {{-- End Modal Hapus edukasi --}}

    <script>
        // detail modal
        function openDetailModal(
            judul,
            deskripsi,
            link,
            file
        ) {

            document.getElementById('detail_title').innerText = judul;

            document.getElementById('detail_deskripsi').innerText =
                deskripsi ?? '-';

            const linkElement = document.getElementById('detail_link');

            if (link) {

                linkElement.href = link;
                linkElement.innerText = link;
                linkElement.classList.remove('hidden');

            } else {

                linkElement.innerText = '-';
                linkElement.removeAttribute('href');

            }

            const preview = document.getElementById('previewContainer');

            preview.innerHTML = '';

            if (file) {

                const ext = file.split('.').pop().toLowerCase();

                if (['jpg', 'jpeg', 'png', 'webp'].includes(ext)) {

                    preview.innerHTML = `
                <img
                    src="/storage/${file}"
                    class="w-full max-h-96 object-contain rounded-lg border">
            `;

                } else if (ext === 'pdf') {

                    preview.innerHTML = `
                <a
                    href="/storage/${file}"
                    target="_blank"
                    class="inline-block bg-red-500 text-white px-4 py-2 rounded-lg">
                    📄 Lihat PDF
                </a>
            `;
                }
            }

            document
                .getElementById('detailModal')
                .classList.remove('hidden');
        }

        function closeDetailModal() {
            document
                .getElementById('detailModal')
                .classList.add('hidden');
        }

        // Delete
        function openDeleteModal(id, title) {
            document.getElementById('deleteTitle').innerText = title;

            document.getElementById('deleteForm').action =
                `/edukasi/${id}`;

            document.getElementById('deleteModal')
                .classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal')
                .classList.add('hidden');
        }
    </script>
@endsection
