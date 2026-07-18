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
                        Kelola seluruh data Education Bank Indonesia.
                    </p>
                </div>

                <div class="flex gap-3">

                    <a href="{{ route('edukasi-video.index') }}"
                        class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-3 rounded-lg font-semibold transition">
                        🎥 Kelola Video
                    </a>

                    <a href="{{ route('edukasi.create') }}"
                        class="bg-[#1C3281] hover:bg-blue-900 text-white px-5 py-3 rounded-lg font-semibold transition">
                        + Tambah Edukasi
                    </a>

                </div>

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
                                    <a href="{{ route('edukasi.edit', $edukasi) }}"
                                        class="bg-blue-100 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-200">
                                        Edit
                                    </a>
                                    {{-- hapus edukasi --}}
                                    <button
                                        onclick="openDeleteModal(
                                            '{{ $edukasi->getRouteKey() }}',
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
    <div id="detailModal" class="hidden fixed inset-0 z-50 bg-black/60 flex items-center justify-center p-4">

        <div
            class="bg-white rounded-2xl shadow-2xl
               w-full max-w-2xl
               max-h-[90vh]
               overflow-hidden">

            <div class="border-b p-5 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-[#1C3281]">
                    Detail Edukasi
                </h3>
                <button onclick="closeDetailModal()" class="text-2xl text-gray-500 hover:text-red-500">
                    ✕
                </button>
            </div>
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-80px)]">
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
                {{-- Video / Link --}}
                <div id="videoSection" class="hidden mt-6">

                    <h4 class="font-semibold mb-3">
                        Video / Link
                    </h4>

                    <div id="videoPreview"></div>

                    <a id="detail_link" target="_blank"
                        class="inline-flex items-center gap-2 mt-4 text-blue-600 hover:text-blue-700 hover:underline break-all">

                        🔗 Buka Link

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
        // helper
        function convertToEmbed(link) {

            if (!link) return null;

            // Youtube
            if (link.includes("youtube.com/watch?v=")) {

                const id = new URL(link).searchParams.get("v");

                return id ?
                    `https://www.youtube.com/embed/${id}` :
                    null;

            }

            if (link.includes("youtu.be/")) {

                const id = link.split("youtu.be/")[1].split("?")[0];

                return `https://www.youtube.com/embed/${id}`;

            }

            // Vimeo
            if (link.includes("vimeo.com/")) {

                const id = link.split("/").pop();

                return `https://player.vimeo.com/video/${id}`;

            }

            // Google Drive
            if (link.includes("drive.google.com")) {

                const match = link.match(/\/d\/(.*?)\//);

                if (match) {

                    return `https://drive.google.com/file/d/${match[1]}/preview`;

                }

            }

            return null;

        }

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

            const videoSection = document.getElementById("videoSection");
            const videoPreview = document.getElementById("videoPreview");
            const linkElement = document.getElementById("detail_link");

            videoSection.classList.add("hidden");
            videoPreview.innerHTML = "";

            if (link) {

                videoSection.classList.remove("hidden");

                linkElement.href = link;
                linkElement.innerHTML = "🔗 Buka Link Asli";

                const embed = convertToEmbed(link);

                if (embed) {

                    videoPreview.innerHTML = `
                        <div class="rounded-xl overflow-hidden border shadow">

                            <iframe
                                src="${embed}"
                                class="w-full h-[280px] md:h-[320px]"
                                allowfullscreen>
                            </iframe>

                        </div>
                    `;

                } else {

                    videoPreview.innerHTML = `
            <div class="rounded-xl border border-yellow-200 bg-yellow-50 p-5">

                <div class="flex items-start gap-3">

                    <div class="text-2xl">
                        🔗
                    </div>

                    <div>

                        <p class="font-semibold text-yellow-700">
                            Preview tidak tersedia
                        </p>

                        <p class="text-sm text-yellow-600 mt-1">
                            Link ini tidak mendukung preview.
                            Silakan klik tombol di bawah untuk membuka halaman.
                        </p>

                    </div>

                </div>

            </div>
        `;

                }

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
                .getElementById('detailModal')x
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
