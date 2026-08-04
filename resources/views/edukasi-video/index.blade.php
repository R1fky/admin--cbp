@extends('layouts.app')

@section('title', 'Video Learning')
@section('page-title', 'Kelola Video Learning')

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

    {{-- Toast Error --}}
    @if (session('error'))
        <div id="toastError"
            class="fixed top-6 right-6 z-50 bg-white border border-slate-200/80 shadow-2xl rounded-xl px-5 py-4 min-w-[320px] transition-all duration-300">
            <div class="flex items-start gap-3">
                <div class="bg-rose-100 text-rose-700 p-1.5 rounded-lg">
                    ✕
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-sm text-slate-800">Gagal</h4>
                    <p class="text-slate-500 text-xs mt-0.5">{{ session('error') }}</p>
                </div>
                <button onclick="document.getElementById('toastError').remove()" class="text-slate-400 hover:text-slate-600 font-bold">&times;</button>
            </div>
        </div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('toastError');
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
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-800 tracking-tight">
                        Publikasi Video Edukasi
                    </h3>
                    <p class="text-slate-500 text-xs mt-0.5">
                        Kelola tautan video YouTube interaktif. Maksimal hanya <b>3 video</b> yang ditampilkan pada beranda Learning.
                    </p>
                </div>

                <div class="flex gap-2.5">
                    <a href="{{ route('edukasi.index') }}"
                        class="bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 px-5 py-2.5 rounded-xl text-xs font-semibold transition flex items-center justify-center">
                        ← Kembali
                    </a>

                    @if ($videos->count() < 3)
                        <a href="{{ route('edukasi-video.create') }}"
                            class="inline-flex items-center gap-2 bg-[#0B1A40] hover:bg-[#1E3A8A] text-white px-5 py-2.5 rounded-xl text-xs font-bold transition shadow-sm cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Video
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Statistik Video --}}
        <div class="bg-white rounded-2xl border border-slate-200/60 p-5 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h4 class="font-bold text-sm text-slate-800">
                    Kuota Penayangan Video
                </h4>
                <p class="text-slate-500 text-xs mt-0.5">
                    Saat ini terpasang: <span class="font-semibold text-slate-700">{{ $videos->count() }} / 3 Video</span>
                </p>
            </div>

            <div>
                @if ($videos->count() >= 3)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-50 border border-rose-100 text-rose-700 text-xs font-bold rounded-lg uppercase">
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                        Kuota Penuh
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 border border-emerald-100 text-emerald-700 text-xs font-bold rounded-lg uppercase">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Tersedia Slot Tambahan
                    </span>
                @endif
            </div>
        </div>

        {{-- Video Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($videos as $video)
                <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm hover:shadow-md transition duration-150 flex flex-col justify-between overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex px-2.5 py-0.5 bg-purple-50 text-purple-700 rounded-md text-[10px] font-bold uppercase border border-purple-100">
                                YouTube Player
                            </span>
                        </div>

                        <h3 class="font-bold text-sm text-slate-800 mt-4 leading-snug line-clamp-2">
                            {{ $video->judul }}
                        </h3>

                        <p class="text-slate-500 mt-2 text-xs leading-relaxed line-clamp-3">
                            {{ $video->deskripsi }}
                        </p>

                        <div class="mt-4 pt-4 border-t border-slate-50">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Tautan URL</p>
                            <a href="{{ $video->link }}" target="_blank" class="text-xs text-blue-600 hover:text-blue-700 font-semibold hover:underline break-all inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Buka Video
                            </a>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 bg-slate-50/50 p-4 flex gap-2">
                        <a href="{{ route('edukasi-video.edit', $video) }}"
                            class="flex-1 bg-blue-50 border border-blue-100 hover:bg-blue-100 text-blue-600 text-center py-2 rounded-xl text-xs font-semibold transition">
                            Edit Video
                        </a>

                        <button
                            onclick="openDeleteModal(
                                '{{ $video->id }}',
                                '{{ $video->judul }}'
                            )"
                            class="flex-1 bg-rose-50 border border-rose-100 hover:bg-rose-100 text-rose-600 py-2 rounded-xl text-xs font-semibold transition cursor-pointer">
                            Hapus Video
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl border border-slate-200/60 p-12 text-center">
                    <div class="w-16 h-16 mx-auto rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center text-3xl mb-4">
                        🎥
                    </div>
                    <h3 class="font-bold text-sm text-slate-800">Belum Ada Video Edukasi</h3>
                    <p class="text-slate-400 text-xs mt-1 max-w-sm mx-auto leading-relaxed">
                        Tambahkan tautan video YouTube edukatif baru untuk dipublikasikan pada halaman muka modul Learning.
                    </p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Modal Delete --}}
    <div id="deleteModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm justify-center items-center z-50 p-4 animate-in fade-in duration-150">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 border border-slate-100">
            <h3 class="text-sm font-bold text-rose-600 uppercase tracking-wider mb-2">
                Hapus Video Edukasi
            </h3>
            <p class="text-xs text-slate-500 leading-relaxed mb-5">
                Apakah Anda yakin ingin menghapus video: <span id="deleteTitle" class="font-bold text-slate-700"></span>?
            </p>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-2 border-t border-slate-100 pt-4">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 rounded-lg border text-xs font-semibold text-slate-600 bg-slate-50 hover:bg-slate-100 transition cursor-pointer">
                        Batal
                    </button>
                    <button class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-semibold transition cursor-pointer">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openDeleteModal(id, title) {
            document.getElementById('deleteTitle').innerText = title;
            document.getElementById('deleteForm').action = `/edukasi-video/${id}`;
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
