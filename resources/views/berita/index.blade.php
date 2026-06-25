@extends('layouts.app')

@section('title', 'Kelola Berita')
@section('page-title', 'Kelola Berita')

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
                        Kelola Berita
                    </h3>

                    <p class="text-gray-500 mt-1">
                        Kelola seluruh data berita dan kompetisi Bank Indonesia.
                    </p>
                </div>
                <a href="{{ route('berita.create') }}"
                    class="bg-[#1C3281] hover:bg-blue-900 text-white px-4 py-2 md:px-5 md:py-3 rounded-lg font-semibold transition">
                    + Tambah Berita
                </a>

            </div>

        </div>

        {{-- Search & Filter --}}
        <div class="bg-white rounded-xl shadow-sm p-4">
            <form method="GET" action="{{ route('berita.index') }}">

                <div class="flex flex-col md:flex-row gap-3">

                    {{-- Search Judul --}}
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari judul berita..."
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
                    <a href="{{ route('berita.index') }}"
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
                            image
                        </th>
                        <th class="px-6 py-4 text-left">
                            Title
                        </th>
                        <th class="px-6 py-4 text-left">
                            Kategori
                        </th>
                        <th class="px-6 py-4 text-left">
                            Published At
                        </th>
                        <th class="px-6 py-4 text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($beritas as $berita)
                        <tr class="border-b hover:bg-slate-50">
                            <td class="px-6 py-4">
                                @if ($berita->image)
                                    <img src="{{ asset('storage/' . $berita->image) }}"
                                        class="w-20 h-12 object-cover rounded">
                                @else
                                    <div class="w-20 h-12 bg-gray-200 rounded"></div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <h4 class="font-semibold text-gray-800">
                                    {{ $berita->title }}
                                </h4>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                                    {{ $berita->kategori->name ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $berita->published_at ? \Carbon\Carbon::parse($berita->published_at)->format('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <button
                                        onclick="openDetailModal(
                                            @js($berita->title),
                                            @js($berita->kategori?->name),
                                            @js($berita->excerpt),
                                            @js($berita->content),
                                            @js($berita->author),
                                            @js($berita->source),
                                            '{{ $berita->image ? asset('storage/' . $berita->image) : '' }}',
                                            '{{ $berita->published_at ? \Carbon\Carbon::parse($berita->published_at)->format('d M Y') : '-' }}'
                                        )"
                                        class="bg-green-100 text-green-700 px-3 py-2 rounded-lg hover:bg-green-200">
                                        Detail
                                    </button>
                                    {{-- edit berita --}}
                                    <a href="{{ route('berita.edit', $berita->id) }}"
                                        class="bg-blue-100 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-200">
                                        Edit
                                    </a>
                                    {{-- hapus berita --}}
                                    <button
                                        onclick="openDeleteModal(
                                            '{{ $berita->id }}',
                                            '{{ $berita->title }}'
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
                                Belum ada data berita
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div>
            {{ $beritas->links() }}
        </div>

    </div>

    {{-- Modal Detail --}}
    <div id="detailModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl w-full max-w-4xl max-h-[95vh] overflow-y-auto shadow-2xl">
            <!-- Header -->
            <div class="sticky top-0 bg-white border-b p-5 flex justify-between items-center z-10">
                <h3 class="text-2xl font-bold text-[#1C3281]">
                    Detail Berita
                </h3>
                <button onclick="closeDetailModal()" class="text-gray-500 hover:text-red-500 text-2xl">
                    ✕
                </button>
            </div>
            <div class="p-6">
                <!-- Gambar -->
                <img id="detail_image" class="w-full h-[350px] object-cover rounded-xl mb-6">
                <!-- Kategori -->
                <div class="mb-3">
                    <span id="detail_kategori" class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                    </span>
                </div>
                <!-- Judul -->
                <h1 id="detail_title" class="text-3xl font-bold text-[#1C3281] mb-4 leading-tight">
                </h1>
                <!-- Metadata -->
                <div class="flex flex-wrap gap-4 text-sm text-gray-500 border-b pb-4 mb-5">
                    <div>
                        ✍️ <span id="detail_author"></span>
                    </div>
                    <div>
                        📅 <span id="detail_tanggal"></span>
                    </div>
                    <div>
                        🌐 <span id="detail_source"></span>
                    </div>
                </div>
                <!-- Ringkasan -->
                <div class="bg-slate-50 border-l-4 border-[#1C3281] p-4 rounded-lg mb-6">
                    <h4 class="font-semibold text-[#1C3281] mb-2">
                        Ringkasan
                    </h4>
                    <p id="detail_excerpt" class="text-gray-700 italic">
                    </p>
                </div>
                <!-- Isi Berita -->
                <div id="detail_content" class="prose prose-lg max-w-none leading-8">
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Detail --}}

    {{-- Modal Hapus Berita --}}
    <div id="deleteModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <h3 class="text-xl font-bold text-[#CF1A25] mb-3">
                Hapus Berita
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
    {{-- End Modal Hapus Berita --}}

    <script>
        // detail modal
        function openDetailModal(
            title,
            kategori,
            excerpt,
            content,
            author,
            source,
            image,
            published_at
        ) {

            document.getElementById('detail_title').innerText =
                title;

            document.getElementById('detail_kategori').innerText =
                kategori || '-';

            document.getElementById('detail_excerpt').innerText =
                excerpt || '-';

            document.getElementById('detail_author').innerText =
                author || 'Admin';

            document.getElementById('detail_source').innerText =
                source || '-';

            document.getElementById('detail_tanggal').innerText =
                published_at;

            document.getElementById('detail_content').innerHTML =
                content;

            const img =
                document.getElementById('detail_image');

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
                `/berita/${id}`;

            document.getElementById('deleteModal')
                .classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal')
                .classList.add('hidden');
        }
    </script>
@endsection
