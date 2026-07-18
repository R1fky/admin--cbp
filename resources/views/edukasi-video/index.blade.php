@extends('layouts.app')

@section('title', 'Video Education')
@section('page-title', 'Kelola Video Education')

@section('content')

    {{-- Toast Success --}}
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


    {{-- Toast Error --}}
    @if (session('error'))
        <div id="toastError"
            class="fixed top-5 right-5 z-50 bg-white border-l-4 border-red-500 shadow-xl rounded-xl px-5 py-4 min-w-[320px]">
            <div class="flex items-start gap-3">
                <div class="bg-red-100 p-2 rounded-full">
                    ❌
                </div>

                <div class="flex-1">
                    <h4 class="font-semibold text-gray-800">
                        Gagal
                    </h4>

                    <p class="text-gray-600 text-sm">
                        {{ session('error') }}
                    </p>
                </div>

                <button onclick="document.getElementById('toastError').remove()" class="text-gray-400 hover:text-gray-600">
                    ✕
                </button>
            </div>
        </div>

        <script>
            setTimeout(() => {
                const toast = document.getElementById('toastError');

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

            <div class="flex flex-col md:flex-row justify-between items-center gap-4">

                <div>

                    <h3 class="text-2xl font-bold text-[#1C3281]">
                        Kelola Video Education
                    </h3>

                    <p class="text-gray-500 mt-1">
                        Maksimal hanya <b>3 video</b> yang ditampilkan pada halaman Education.
                    </p>

                </div>

                <div class="flex gap-3">

                    <a href="{{ route('edukasi.index') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-3 rounded-lg font-semibold transition">
                        ← Kembali
                    </a>

                    @if ($videos->count() < 3)
                        <a href="{{ route('edukasi-video.create') }}"
                            class="bg-[#1C3281] hover:bg-blue-900 text-white px-5 py-3 rounded-lg font-semibold transition">
                            + Tambah Video
                        </a>
                    @endif

                </div>

            </div>

        </div>


        {{-- Statistik --}}
        <div class="bg-white rounded-xl shadow-sm p-5 flex justify-between items-center">

            <div>

                <h4 class="font-semibold text-lg text-[#1C3281]">
                    Total Video
                </h4>

                <p class="text-gray-500">
                    {{ $videos->count() }} / 3 Video
                </p>

            </div>

            <div>

                @if ($videos->count() >= 3)
                    <span class="bg-red-100 text-red-600 px-4 py-2 rounded-lg font-semibold">
                        Kuota Video Penuh
                    </span>
                @else
                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-lg font-semibold">
                        Masih Bisa Menambah
                    </span>
                @endif

            </div>

        </div>


        {{-- Card --}}
        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">

            @forelse($videos as $video)
                <div class="bg-white rounded-xl shadow-sm border hover:shadow-lg transition">

                    <div class="p-6">

                        <div class="flex items-center justify-between">

                            <span class="bg-[#1C3281] text-white text-xs px-3 py-1 rounded-full">
                                Video Education
                            </span>

                        </div>

                        <h3 class="font-bold text-xl text-[#1C3281] mt-5">
                            {{ $video->judul }}
                        </h3>

                        <p class="text-gray-500 mt-3 leading-7">
                            {{ Str::limit($video->deskripsi, 120) }}
                        </p>

                        <div class="mt-5">

                            <p class="text-sm text-gray-500 mb-2">
                                Link Video
                            </p>

                            <a href="{{ $video->link }}" target="_blank" class="text-blue-600 hover:underline break-all">

                                {{ $video->link }}

                            </a>

                        </div>

                    </div>

                    <div class="border-t p-4 flex gap-2">

                        <a href="{{ route('edukasi-video.edit', $video) }}"
                            class="flex-1 bg-blue-100 hover:bg-blue-200 text-blue-700 text-center py-2 rounded-lg">

                            Edit

                        </a>

                        <button
                            onclick="openDeleteModal(
                                '{{ $video->id }}',
                                '{{ $video->judul }}'
                            )"
                            class="flex-1 bg-red-100 hover:bg-red-200 text-red-700 py-2 rounded-lg">

                            Hapus

                        </button>

                    </div>

                </div>

            @empty

                <div class="col-span-full bg-white rounded-xl p-12 shadow text-center">

                    <div class="text-5xl mb-3">
                        🎥
                    </div>

                    <h3 class="font-bold text-xl text-[#1C3281]">
                        Belum Ada Video
                    </h3>

                    <p class="text-gray-500 mt-2">
                        Tambahkan video education untuk ditampilkan pada halaman frontend.
                    </p>

                </div>
            @endforelse

        </div>

    </div>



    {{-- Modal Delete --}}
    <div id="deleteModal" class="hidden fixed inset-0 bg-black/50 flex justify-center items-center z-50 p-4">

        <div class="bg-white rounded-xl w-full max-w-md p-6">

            <h3 class="text-xl font-bold text-[#CF1A25]">
                Hapus Video
            </h3>

            <p class="mt-4 text-gray-600">

                Apakah yakin ingin menghapus

                <span id="deleteTitle" class="font-semibold text-gray-800">
                </span> ?

            </p>

            <form id="deleteForm" method="POST">

                @csrf
                @method('DELETE')

                <div class="flex justify-end gap-3 mt-6">

                    <button type="button" onclick="closeDeleteModal()" class="border px-4 py-2 rounded-lg">

                        Batal

                    </button>

                    <button class="bg-[#CF1A25] text-white px-4 py-2 rounded-lg">

                        Ya, Hapus

                    </button>

                </div>

            </form>

        </div>

    </div>


    <script>
        function openDeleteModal(id, title) {

            document.getElementById('deleteTitle').innerText = title;

            document.getElementById('deleteForm').action =
                `/edukasi-video/${id}`;

            document.getElementById('deleteModal')
                .classList.remove('hidden');

        }

        function closeDeleteModal() {

            document.getElementById('deleteModal')
                .classList.add('hidden');

        }
    </script>

@endsection
