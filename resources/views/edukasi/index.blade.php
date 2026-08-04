@extends('layouts.app')

@section('title', 'Learning')
@section('page-title', 'Kelola Learning')

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
                        Materi Edukasi Paham Rupiah
                    </h3>
                    <p class="text-slate-500 text-xs mt-0.5">
                        Kelola seluruh materi edukasi Cinta Bangga Paham Rupiah.
                    </p>
                </div>

                <div class="flex flex-wrap gap-2.5">
                    <a href="{{ route('edukasi-video.index') }}"
                        class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 px-5 py-2.5 rounded-xl text-xs font-semibold transition cursor-pointer">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Kelola Video
                    </a>

                    <a href="{{ route('edukasi.create') }}"
                        class="inline-flex items-center gap-2 bg-[#0B1A40] hover:bg-[#1E3A8A] text-white px-5 py-2.5 rounded-xl text-xs font-bold transition shadow-sm cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Edukasi
                    </a>
                </div>
            </div>
        </div>

        {{-- Search & Filter --}}
        <div class="bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm">
            <form method="GET" action="{{ route('edukasi.index') }}">
                <div class="flex flex-col md:flex-row gap-3">
                    {{-- Search Judul --}}
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari judul materi edukasi..."
                            class="w-full pl-9 pr-4 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 text-xs">
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex gap-2">
                        <button type="submit"
                            class="bg-[#0B1A40] hover:bg-[#1E3A8A] text-white px-5 py-2.5 rounded-xl text-xs font-semibold transition cursor-pointer">
                            Cari
                        </button>
                        <a href="{{ route('edukasi.index') }}"
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
                            <th class="px-6 py-4 text-slate-500 text-[11px] font-bold uppercase tracking-wider w-1/2">
                                Detail Edukasi
                            </th>
                            <th class="px-6 py-4 text-slate-500 text-[11px] font-bold uppercase tracking-wider">
                                File Lampiran
                            </th>
                            <th class="px-6 py-4 text-slate-500 text-[11px] font-bold uppercase tracking-wider">
                                Link Referensi
                            </th>
                            <th class="px-6 py-4 text-slate-500 text-[11px] font-bold uppercase tracking-wider text-center">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($edukasis as $edukasi)
                            <tr class="hover:bg-slate-50/80 transition duration-150">
                                <td class="px-6 py-4">
                                    <h4 class="font-bold text-slate-700 text-xs leading-relaxed max-w-lg">
                                        {{ $edukasi->judul }}
                                    </h4>
                                    <p class="text-xs text-slate-400 mt-1 max-w-lg line-clamp-2 leading-relaxed">
                                        {{ $edukasi->deskripsi }}
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
                                                class="w-16 h-16 object-cover rounded-lg border border-slate-200 shadow-sm">
                                        @elseif(strtolower($ext) == 'pdf')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 text-red-700 text-[10px] font-bold uppercase border border-red-100 rounded-md">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                PDF Dokumen
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-slate-300 text-xs italic">
                                            Tidak ada file
                                        </span>
                                    @endif
                                </td>

                                {{-- LINK --}}
                                <td class="px-6 py-4 text-xs">
                                    @if ($edukasi->link)
                                        <a href="{{ $edukasi->link }}" target="_blank" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 font-medium hover:underline">
                                            Buka Link
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
                                        {{-- Detail --}}
                                        <button
                                            onclick="openDetailModal(
                                                @js($edukasi->judul),
                                                @js($edukasi->deskripsi),
                                                @js($edukasi->link),
                                                @js($edukasi->file)
                                            )"
                                            title="Lihat Rincian"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 hover:bg-slate-100 border border-slate-200/60 text-slate-600 transition cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>

                                        {{-- Edit --}}
                                        <a href="{{ route('edukasi.edit', $edukasi) }}" title="Edit Edukasi"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 hover:bg-blue-100 border border-blue-100 text-blue-600 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </a>

                                        {{-- Hapus --}}
                                        <button
                                            onclick="openDeleteModal(
                                                '{{ $edukasi->getRouteKey() }}',
                                                '{{ $edukasi->judul }}'
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
                                <td colspan="4" class="text-center py-12 text-slate-400 text-xs italic">
                                    Belum ada data materi edukasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $edukasis->links() }}
        </div>
    </div>

    {{-- Modal Detail --}}
    <div id="detailModal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col border border-slate-100 animate-in fade-in duration-200">
            <div class="sticky top-0 bg-slate-50 border-b border-slate-150 px-6 py-4 flex justify-between items-center z-10">
                <h3 class="text-base font-bold text-slate-800 tracking-tight">
                    Rincian Edukasi
                </h3>
                <button onclick="closeDetailModal()" class="text-slate-400 hover:text-slate-600 text-2xl cursor-pointer">
                    &times;
                </button>
            </div>
            
            <div class="p-6 overflow-y-auto space-y-5 flex-1">
                <div id="previewContainer" class="mb-2"></div>
                
                <div>
                    <h2 id="detail_title" class="text-lg font-bold text-slate-800 leading-snug"></h2>
                </div>

                <div class="border-t border-slate-100 pt-4">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Materi</h4>
                    <p id="detail_deskripsi" class="text-xs text-slate-600 leading-relaxed bg-slate-50/50 p-4 border border-slate-200/60 rounded-xl whitespace-pre-line"></p>
                </div>

                {{-- Video / Link --}}
                <div id="videoSection" class="hidden border-t border-slate-100 pt-4">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Tautan & Media Referensi</h4>
                    <div id="videoPreview" class="overflow-hidden"></div>
                    <div class="mt-3">
                        <a id="detail_link" target="_blank"
                            class="inline-flex items-center gap-1.5 text-xs text-blue-600 hover:text-blue-700 font-semibold hover:underline cursor-pointer">
                            🔗 Buka Link Asli
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Detail --}}

    {{-- Modal Hapus edukasi --}}
    <div id="deleteModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 border border-slate-100">
            <h3 class="text-sm font-bold text-rose-600 uppercase tracking-wider mb-2">
                Hapus Materi Edukasi
            </h3>
            <p class="text-xs text-slate-500 leading-relaxed mb-5">
                Apakah Anda yakin ingin menghapus materi edukasi: <span id="deleteTitle" class="font-bold text-slate-700"></span>? Semua berkas terkait akan terhapus.
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
    {{-- End Modal Hapus edukasi --}}

    <script>
        function convertToEmbed(link) {
            if (!link) return null;
            // Youtube watch
            if (link.includes("youtube.com/watch?v=")) {
                try {
                    const id = new URL(link).searchParams.get("v");
                    return id ? `https://www.youtube.com/embed/${id}` : null;
                } catch(e) {
                    return null;
                }
            }
            // Youtube share
            if (link.includes("youtu.be/")) {
                const parts = link.split("youtu.be/");
                if (parts[1]) {
                    const id = parts[1].split("?")[0];
                    return `https://www.youtube.com/embed/${id}`;
                }
            }
            // Vimeo
            if (link.includes("vimeo.com/")) {
                const id = link.split("/").pop();
                return id ? `https://player.vimeo.com/video/${id}` : null;
            }
            // Google Drive
            if (link.includes("drive.google.com")) {
                const match = link.match(/\/d\/(.*?)\//);
                if (match && match[1]) {
                    return `https://drive.google.com/file/d/${match[1]}/preview`;
                }
            }
            return null;
        }

        function openDetailModal(judul, deskripsi, link, file) {
            document.getElementById('detail_title').innerText = judul;
            document.getElementById('detail_deskripsi').innerText = deskripsi ?? '-';

            const videoSection = document.getElementById("videoSection");
            const videoPreview = document.getElementById("videoPreview");
            const linkElement = document.getElementById("detail_link");

            videoSection.classList.add("hidden");
            videoPreview.innerHTML = "";

            if (link) {
                videoSection.classList.remove("hidden");
                linkElement.href = link;
                linkElement.innerHTML = `
                    <span>🔗 Buka Link Asli</span>
                    <svg class="w-3.5 h-3.5 inline ml-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                `;

                const embed = convertToEmbed(link);
                if (embed) {
                    videoPreview.innerHTML = `
                        <div class="rounded-xl overflow-hidden border border-slate-200 shadow-sm bg-black">
                            <iframe src="${embed}" class="w-full h-[280px] md:h-[320px]" allowfullscreen></iframe>
                        </div>
                    `;
                } else {
                    videoPreview.innerHTML = `
                        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4">
                            <div class="flex items-start gap-2.5">
                                <span class="text-lg">💡</span>
                                <div>
                                    <p class="font-bold text-xs text-amber-800">Preview tidak tersedia</p>
                                    <p class="text-[11px] text-amber-600 mt-1 leading-relaxed">
                                        Tautan ini tidak mendukung peninjauan langsung. Anda dapat membukanya melalui tombol tautan di bawah.
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
                        <img src="/storage/${file}" class="w-full max-h-80 object-contain rounded-xl border border-slate-200 bg-slate-50 p-2">
                    `;
                } else if (ext === 'pdf') {
                    preview.innerHTML = `
                        <div class="flex items-center gap-3 bg-red-50 border border-red-150 p-4 rounded-xl">
                            <span class="text-3xl">📄</span>
                            <div>
                                <h4 class="font-bold text-xs text-red-800 uppercase">Dokumen PDF Terlampir</h4>
                                <a href="/storage/${file}" target="_blank" class="inline-flex items-center gap-1 text-xs text-red-600 hover:text-red-700 font-semibold hover:underline mt-1">
                                    Buka Dokumen PDF
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    `;
                }
            }

            const modal = document.getElementById('detailModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
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
            document.getElementById('deleteForm').action = `/edukasi/${id}`;
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
