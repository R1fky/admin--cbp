@extends('layouts.app')

@section('title', 'Kelola Sharing')
@section('page-title', 'Kelola Sharing')

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
        <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-800 tracking-tight">
                        Artikel & Publikasi Sharing
                    </h3>
                    <p class="text-slate-500 text-xs mt-0.5">
                        Kelola seluruh data Sharing, berita, publikasi, dan artikel Bank Indonesia.
                    </p>
                </div>
                <a href="{{ route('berita.create') }}"
                    class="inline-flex items-center gap-2 bg-[#0B1A40] hover:bg-[#1E3A8A] text-white px-5 py-2.5 rounded-xl text-xs font-bold transition shadow-sm cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Artikel
                </a>
            </div>
        </div>

        {{-- Search & Filter --}}
        <div class="bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm">
            <form method="GET" action="{{ route('berita.index') }}">
                <div class="flex flex-col md:flex-row gap-3">
                    {{-- Search Judul --}}
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari judul berita atau artikel..."
                            class="w-full pl-9 pr-4 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 text-xs">
                    </div>

                    {{-- Filter Kategori --}}
                    <div class="md:w-60">
                        <select name="kategori_id"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 text-xs bg-white">
                            <option value="">Semua Kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}"
                                    {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex gap-2">
                        <button type="submit"
                            class="bg-[#0B1A40] hover:bg-[#1E3A8A] text-white px-5 py-2.5 rounded-xl text-xs font-semibold transition cursor-pointer">
                            Cari
                        </button>
                        <a href="{{ route('berita.index') }}"
                            class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-xl text-xs font-semibold transition text-center flex items-center justify-center">
                            Reset
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
                                Image
                            </th>
                            <th class="px-6 py-4 text-slate-500 text-[11px] font-bold uppercase tracking-wider">
                                Title / Judul
                            </th>
                            <th class="px-6 py-4 text-slate-500 text-[11px] font-bold uppercase tracking-wider">
                                Kategori
                            </th>
                            <th class="px-6 py-4 text-slate-500 text-[11px] font-bold uppercase tracking-wider">
                                Published At
                            </th>
                            <th class="px-6 py-4 text-slate-500 text-[11px] font-bold uppercase tracking-wider text-center">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($beritas as $berita)
                            <tr class="hover:bg-slate-50/80 transition duration-150">
                                <td class="px-6 py-4">
                                    @if ($berita->image)
                                        <img src="{{ asset('storage/' . $berita->image) }}"
                                            class="w-16 h-10 object-cover rounded-lg border border-slate-100">
                                    @else
                                        <div class="w-16 h-10 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400 text-xs">
                                            No Image
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <h4 class="font-bold text-slate-700 text-xs leading-relaxed max-w-sm">
                                        {{ $berita->title }}
                                    </h4>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2.5 py-0.5 bg-blue-50 text-blue-700 rounded-md text-[10px] font-bold uppercase border border-blue-100">
                                        {{ $berita->kategori->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-500">
                                    {{ $berita->published_at ? \Carbon\Carbon::parse($berita->published_at)->format('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center items-center gap-1.5">
                                        {{-- Detail --}}
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
                                            title="Lihat Detail"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 hover:bg-slate-100 border border-slate-200/60 text-slate-600 transition cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>

                                        {{-- Edit --}}
                                        <a href="{{ route('berita.edit', $berita->id) }}" title="Edit Artikel"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 hover:bg-blue-100 border border-blue-100 text-blue-600 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </a>

                                        {{-- Hapus --}}
                                        <button
                                            onclick="openDeleteModal(
                                                '{{ $berita->id }}',
                                                '{{ $berita->title }}'
                                            )"
                                            title="Hapus"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-rose-50 hover:bg-rose-100 border border-rose-100 text-rose-600 transition cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-12 text-slate-400 text-xs italic">
                                    Belum ada data berita / artikel.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $beritas->links() }}
        </div>
    </div>

    {{-- Modal Detail --}}
    <div id="detailModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 z-50 animate-in fade-in duration-200">
        <div class="bg-white rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto shadow-2xl flex flex-col border border-slate-100">
            <!-- Header -->
            <div class="sticky top-0 bg-slate-50 border-b border-slate-150 px-6 py-4 flex justify-between items-center z-10">
                <h3 class="text-base font-bold text-slate-800 tracking-tight">
                    Rincian Artikel & Berita
                </h3>
                <button onclick="closeDetailModal()" class="text-slate-400 hover:text-slate-600 text-2xl cursor-pointer">
                    &times;
                </button>
            </div>
            
            <div class="p-6 space-y-6">
                <!-- Gambar -->
                <img id="detail_image" class="w-full h-80 object-cover rounded-xl border border-slate-200 shadow-inner">
                
                <!-- Kategori & Judul -->
                <div>
                    <span id="detail_kategori" class="inline-flex px-2.5 py-0.5 bg-blue-50 text-blue-700 rounded-md text-[10px] font-bold uppercase border border-blue-100"></span>
                    <h1 id="detail_title" class="text-xl font-bold text-slate-800 mt-2 leading-snug"></h1>
                </div>

                <!-- Metadata -->
                <div class="flex flex-wrap gap-4 text-xs text-slate-500 border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-1">
                        <span>✍️</span> Author: <span id="detail_author" class="font-semibold text-slate-700"></span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span>📅</span> Tanggal: <span id="detail_tanggal" class="font-semibold text-slate-700"></span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span>🌐</span> Sumber: <span id="detail_source" class="font-semibold text-slate-700"></span>
                    </div>
                </div>

                <!-- Ringkasan Excerpt -->
                <div class="bg-slate-50 border-l-4 border-[#0B1A40] p-4 rounded-r-xl">
                    <h4 class="font-bold text-xs text-[#0B1A40] uppercase tracking-wider mb-1">Ringkasan Ringkas</h4>
                    <p id="detail_excerpt" class="text-xs text-slate-600 italic leading-relaxed"></p>
                </div>

                <!-- Isi Berita -->
                <div class="border-t border-slate-100 pt-5">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Konten Lengkap</h4>
                    <div id="detail_content" class="text-xs text-slate-600 leading-relaxed whitespace-pre-wrap bg-slate-50/50 p-4 border border-slate-200/60 rounded-xl"></div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Detail --}}

    {{-- Modal Hapus Berita --}}
    <div id="deleteModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 border border-slate-100">
            <h3 class="text-sm font-bold text-rose-600 uppercase tracking-wider mb-2">
                Hapus Artikel
            </h3>
            <p class="text-xs text-slate-500 leading-relaxed mb-5">
                Apakah Anda yakin ingin menghapus artikel: <span id="deleteTitle" class="font-bold text-slate-700"></span>? Tindakan ini tidak dapat dibatalkan.
            </p>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-2 border-t border-slate-100 pt-4">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 rounded-lg border text-xs font-semibold text-slate-600 bg-slate-50 hover:bg-slate-100 transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-semibold transition cursor-pointer">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
    {{-- End Modal Hapus Berita --}}

    <script>
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
            document.getElementById('detail_title').innerText = title;
            document.getElementById('detail_kategori').innerText = kategori || '-';
            document.getElementById('detail_excerpt').innerText = excerpt || '-';
            document.getElementById('detail_author').innerText = author || 'Admin';
            document.getElementById('detail_source').innerText = source || '-';
            document.getElementById('detail_tanggal').innerText = published_at;
            document.getElementById('detail_content').innerHTML = content;

            const img = document.getElementById('detail_image');
            if (image) {
                img.src = image;
                img.classList.remove('hidden');
            } else {
                img.classList.add('hidden');
            }

            document.getElementById('detailModal').classList.remove('hidden');
            document.getElementById('detailModal').classList.add('flex');
        }

        function closeDetailModal() {
            const modal = document.getElementById('detailModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetailModal();
            }
        });

        function openDeleteModal(id, title) {
            document.getElementById('deleteTitle').innerText = title;
            document.getElementById('deleteForm').action = `/berita/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
@endsection
