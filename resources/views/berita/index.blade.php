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
                <button onclick="document.getElementById('createModal').classList.remove('hidden')"
                    class="bg-[#1C3281] hover:bg-blue-900 text-white px-4 py-2 md:px-5 md:py-3 rounded-lg font-semibold transition">
                    + Tambah Berita
                </button>

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
                            Content
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
                                <h4 class="font-semibold text-gray-800">
                                    {{ $berita->content }}
                                </h4>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    {{-- Detail Modal  --}}
                                    <button
                                        onclick="openDetailModal(
                                            @js($berita->title),
                                            @js($berita->kategori?->name),
                                            @js($berita->content),
                                            '{{ $berita->image ? asset('storage/' . $berita->image) : '' }}',
                                            '{{ $berita->published_at ? \Carbon\Carbon::parse($berita->published_at)->format('d M Y') : '-' }}'
                                        )"
                                        class="bg-green-100 text-green-700 px-3 py-2 rounded-lg hover:bg-green-200">
                                        Detail
                                    </button>
                                    {{-- edit berita --}}
                                    <button
                                        onclick="openEditModal(
                                            '{{ $berita->id }}',
                                            @js($berita->title),
                                            @js($berita->content),
                                            '{{ $berita->kategori_id }}',
                                            '{{ $berita->published_at ? \Carbon\Carbon::parse($berita->published_at)->format('Y-m-d') : '' }}'
                                        )"
                                        class="bg-blue-100 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-200">
                                        Edit
                                    </button>
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

    {{-- Modal Tambah berita --}}
    <div id="createModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl w-full max-w-md md:max-w-lg max-h-[90vh] overflow-y-auto p-5 shadow-xl">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-xl font-bold text-[#1C3281]">
                    Tambah Berita
                </h3>
                <button onclick="document.getElementById('createModal').classList.add('hidden')">
                    ✕
                </button>
            </div>

            <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block mb-2 font-medium">
                            Judul Berita
                        </label>
                        <input type="text" name="title"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1C3281] focus:outline-none">
                    </div>
                    <div>
                        <label class="block mb-2 font-medium">
                            image
                        </label>
                        <input type="file" name="image" class="w-full border rounded-lg px-4 py-3">
                    </div>
                    <div>
                        <label class="block mb-2 font-medium">
                            Published at
                        </label>
                        <input type="date" name="published_at" class="w-full border rounded-lg px-4 py-3">
                    </div>
                    <div>
                        <label class="block mb-2 font-medium">
                            Kategori
                        </label>

                        <select name="kategori_id" class="w-full border border-gray-300 rounded-lg px-4 py-3">

                            <option value="">
                                Pilih Kategori
                            </option>

                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">
                                    {{ $kategori->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 font-medium">
                            Isi Berita
                        </label>
                        <textarea name="content" rows="4"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1C3281] focus:outline-none"></textarea>
                    </div>
                    <button type="submit"
                        class="w-full bg-[#CF1A25] hover:bg-red-700 text-white py-2.5 rounded-lg font-semibold transition">
                        Simpan berita
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div id="editModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl w-full max-w-md md:max-w-lg max-h-[90vh] overflow-y-auto p-5 shadow-xl">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-xl font-bold text-[#1C3281]">
                    Edit Berita
                </h3>
                <button onclick="closeEditModal()">
                    ✕
                </button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block mb-2 font-medium">
                            Judul Berita
                        </label>
                        <input id="edit_title" type="text" name="title"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5">
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">
                            Image Baru
                        </label>

                        <input type="file" name="image" class="w-full border rounded-lg px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">
                            Published At
                        </label>

                        <input id="edit_published_at" type="date" name="published_at"
                            class="w-full border rounded-lg px-4 py-3">
                    </div>
                    <div>
                        <label class="block mb-2 font-medium">
                            Kategori
                        </label>

                        <select id="edit_kategori_id" name="kategori_id"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3">

                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">
                                    {{ $kategori->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 font-medium">
                            Content
                        </label>
                        <textarea id="edit_content" name="content" rows="4" class="w-full border rounded-lg px-4 py-3"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-[#1C3281] text-white py-3 rounded-lg">
                        Update Berita
                    </button>
                </div>
            </form>
        </div>
    </div>
    {{-- End Modal Edit --}}

    {{-- Modal Detail --}}
    <div id="detailModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">

        <div class="bg-white rounded-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6">

            <div class="flex justify-between items-center mb-5">

                <h3 class="text-xl font-bold text-[#1C3281]">
                    Detail Berita
                </h3>

                <button onclick="closeDetailModal()">
                    ✕
                </button>

            </div>

            <img id="detail_image" class="w-full h-64 object-cover rounded-lg mb-5">

            <h2 id="detail_title" class="text-2xl font-bold text-[#1C3281] mb-2">
            </h2>

            <div class="flex gap-3 mb-4">

                <span id="detail_kategori" class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
                </span>

                <span id="detail_tanggal" class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                </span>

            </div>

            <div id="detail_content" class="prose max-w-none text-gray-700">
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
            content,
            image,
            published_at
        ) {
            document.getElementById('detail_title').innerText = title;

            document.getElementById('detail_kategori').innerText =
                kategori ?? '-';

            document.getElementById('detail_tanggal').innerText =
                published_at;

            document.getElementById('detail_content').innerText =
                content;

            document.getElementById('detail_image').src =
                image;

            document.getElementById('detailModal')
                .classList.remove('hidden');
        }
        function closeDetailModal() {
            document.getElementById('detailModal')
                .classList.add('hidden');
        }
        // edit modal
        function openEditModal(
            id,
            title,
            content,
            kategori_id,
            published_at
        ) {
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_content').value = content;
            document.getElementById('edit_kategori_id').value = kategori_id;
            document.getElementById('edit_published_at').value = published_at;
            document.getElementById('editForm').action =
                `/berita/${id}`;
            document.getElementById('editModal')
                .classList.remove('hidden');
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
