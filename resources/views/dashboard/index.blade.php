@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

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

    @if ($errors->any())
        <div id="toastError"
            class="fixed top-5 right-5 z-50 bg-white border-l-4 border-red-500 shadow-xl rounded-xl px-5 py-4 min-w-[320px] max-w-md">

            <div class="flex items-start gap-3">

                <div class="bg-red-100 p-2 rounded-full">
                    ❌
                </div>

                <div class="flex-1">
                    <h4 class="font-semibold text-gray-800">
                        Terjadi Kesalahan
                    </h4>
                    <ul class="text-gray-600 text-sm mt-1 list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
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
            }, 5000);
        </script>
    @endif

    {{-- Header --}}
    <div class="bg-white rounded-xl shadow-sm border-l-4 border-[#CF1A25] p-6 mb-6">
        <h2 class="text-2xl font-bold text-[#1C3281]">
            Dashboard Admin
        </h2>
        <p class="text-gray-500 mt-2">
            Selamat datang kembali, {{ Auth::user()->name }}
        </p>
    </div>

    {{-- Upload Image to Next --}}
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-[#1C3281]">
                    Pengaturan Halaman Home
                </h2>
                <p class="text-gray-500 mt-1">
                    Kelola Hero Banner dan Video Youtube yang tampil pada website.
                </p>
            </div>
            <button onclick="openHomeModal()"
                class="w-12 h-12 flex items-center justify-center rounded-full bg-[#1C3281] hover:bg-blue-900 text-white shadow-lg transition duration-200"
                title="Pengaturan Home">
                ⚙️
            </button>
        </div>
    </div>

    {{-- Search --}}
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <form action="{{ route('dashboard') }}" method="GET">
            <div class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berita atau lomba..."
                    class="w-full flex-1 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#1C3281]">
                <button type="submit"
                    class="w-full sm:w-auto bg-[#1C3281] text-white px-5 py-3 rounded-lg hover:bg-blue-900">
                    Cari
                </button>

                @if (request('search'))
                    <a href="{{ route('dashboard') }}"
                        class="w-full sm:w-auto text-center bg-gray-200 px-4 py-3 rounded-lg">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>
    {{-- Alert Hasil Pencarian --}}
    @if (request('search'))
        <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded-xl shadow-sm">
            <div class="flex items-center gap-2">
                <span class="text-lg">🔍</span>
                <div>
                    <p class="font-semibold">
                        Hasil Pencarian
                    </p>
                    <p>
                        Menampilkan data dengan kata kunci:
                        <strong>"{{ request('search') }}"</strong>
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-6 mb-8">
        {{-- total lomba --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-[#1C3281]">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500">
                        Total Lomba
                    </p>
                    <h2 class="text-4xl font-bold text-[#1C3281] mt-2">
                        {{ $totalLomba }}
                    </h2>
                </div>
                <div class="text-4xl">
                    🏆
                </div>
            </div>
        </div>

        {{-- total berita --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500">
                        Total Berita
                    </p>
                    <h2 class="text-4xl font-bold text-green-600 mt-2">
                        {{ $totalBerita }}
                    </h2>
                </div>
                <div class="text-4xl">
                    📰
                </div>
            </div>

        </div>

        {{-- akan di buka --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-400">
            <div class="flex justify-between items-center">

                <div>
                    <p class="text-gray-500">
                        Akan Dibuka
                    </p>

                    <h2 class="text-4xl font-bold text-yellow-500 mt-2">
                        {{ $lombaAkanDibuka }}
                    </h2>
                </div>

                <div class="text-4xl">
                    📅
                </div>

            </div>
        </div>

        {{-- lomba berlangsung --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex justify-between items-center">

                <div>
                    <p class="text-gray-500">
                        Sedang Berlangsung
                    </p>

                    <h2 class="text-4xl font-bold text-green-600 mt-2">
                        {{ $lombaBerlangsung }}
                    </h2>
                </div>

                <div class="text-4xl">
                    🏆
                </div>

            </div>
        </div>
        {{-- lomba selesai --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
            <div class="flex justify-between items-center">

                <div>
                    <p class="text-gray-500">
                        Pendaftaran Selesai
                    </p>

                    <h2 class="text-4xl font-bold text-red-500 mt-2">
                        {{ $lombaSelesai }}
                    </h2>
                </div>

                <div class="text-4xl">
                    🔒
                </div>

            </div>
        </div>
    </div>

    {{-- Aktivitas --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Berita --}}
        <div class="bg-white rounded-xl shadow-sm p-6">

            <h3 class="font-bold text-xl mb-4 text-[#1C3281]">
                Berita Terbaru
            </h3>

            @forelse($beritaTerbaru as $berita)
                <div class="border-b py-3">

                    <p class="font-semibold">
                        {{ $berita->title }}
                    </p>

                    <p class="text-sm text-gray-500">
                        {{ $berita->created_at->format('d M Y') }}
                    </p>

                </div>

            @empty

                <p class="text-gray-500">
                    Belum ada berita
                </p>
            @endforelse

        </div>

        {{-- Lomba --}}
        <div class="bg-white rounded-xl shadow-sm p-6">

            <h3 class="font-bold text-xl mb-4 text-[#1C3281]">
                Lomba Terbaru
            </h3>

            @forelse($lombaTerbaru as $lomba)
                <div class="border-b py-4">

                    <div class="flex justify-between items-center">

                        <div>

                            <p class="font-semibold">
                                {{ $lomba->title }}
                            </p>

                            <p class="text-sm text-gray-500">
                                {{ $lomba->release_date->format('d M Y') }}
                            </p>

                        </div>

                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $lomba->status_color }}">
                            {{ $lomba->status_label }}
                        </span>

                    </div>

                </div>

            @empty
                <p class="text-gray-500">
                    Belum ada lomba
                </p>
            @endforelse

        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">

            <h3 class="font-bold text-xl mb-4 text-[#1C3281]">
                Aktivitas Pendaftaran
            </h3>

            @forelse($pendaftaranTerbaru as $item)
                <div class="border-b py-4">

                    <div class="flex justify-between">

                        <div>

                            <p class="font-semibold">

                                {{ $item->name }}

                            </p>

                            <p class="text-sm text-gray-500">

                                {{ $item->lomba->title }}

                            </p>

                            <p class="text-xs text-gray-400 mt-1">

                                {{ $item->created_at->diffForHumans() }}

                            </p>

                        </div>

                        @if ($item->status == 'approved')
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">

                                Approved

                            </span>
                        @elseif($item->status == 'pending')
                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">

                                Pending

                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">

                                Rejected

                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-500">
                    Belum ada peserta mendaftar.
                </p>
            @endforelse
        </div>
    </div>


    {{-- Modal Upload Image to Next --}}
    <!-- Overlay -->
    <div id="homeModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50 p-4">

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">

            <div class="flex justify-between items-center p-6 border-b">

                <h2 class="text-2xl font-bold text-[#1C3281]">
                    Pengaturan Home
                </h2>

                <button onclick="closeHomeModal()" class="text-gray-500 hover:text-red-500 text-2xl">

                    &times;

                </button>

            </div>

            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('dashboard.home.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6">

                @csrf

                <div class="grid md:grid-cols-2 gap-6">

                    {{-- Judul --}}
                    <div>
                        <label class="font-medium">
                            Judul Hero
                        </label>

                        <input type="text" name="hero_title" value="{{ old('hero_title') }}"
                            class="mt-2 w-full border rounded-lg px-4 py-3">
                    </div>

                    {{-- Youtube --}}
                    <div>
                        <label class="font-medium">
                            Link Youtube
                        </label>

                        <input type="url" name="youtube_url" value="{{ old('youtube_url') }}"
                            class="mt-2 w-full border rounded-lg px-4 py-3">
                    </div>

                    {{-- Deskripsi --}}
                    <div class="md:col-span-2">
                        <label class="font-medium">
                            Deskripsi Hero
                        </label>

                        <textarea rows="4" name="hero_description" class="mt-2 w-full border rounded-lg px-4 py-3">{{ old('hero_description') }}</textarea>
                    </div>

                    {{-- Upload --}}
                    <div>

                        <label class="font-medium">
                            Upload Gambar Hero
                        </label>

                        <input id="heroImage" type="file" name="hero_image" accept="image/*"
                            onchange="previewHeroImage(event)" class="mt-2 w-full border rounded-lg p-2">

                        <p class="text-sm text-gray-500 mt-2">
                            JPG, PNG, WEBP
                        </p>

                    </div>

                    {{-- Preview --}}
                    <div>

                        <label class="font-medium">
                            Preview
                        </label>

                        <div class="mt-2">

                            <img id="previewImage" src="https://placehold.co/600x300?text=Preview"
                                class="rounded-xl border h-52 w-full object-cover">

                        </div>

                    </div>

                </div>

                <div class="flex justify-end gap-3 mt-8">

                    <button type="button" onclick="closeHomeModal()" class="px-5 py-3 rounded-lg bg-gray-200">

                        Batal

                    </button>

                    <button class="px-5 py-3 rounded-lg bg-[#1C3281] text-white">

                        Simpan Pengaturan

                    </button>

                </div>

            </form>

        </div>

    </div>

    <script>
        function openHomeModal() {

            document.getElementById('homeModal').classList.remove('hidden');
            document.getElementById('homeModal').classList.add('flex');

        }

        function closeHomeModal() {

            document.getElementById('homeModal').classList.remove('flex');
            document.getElementById('homeModal').classList.add('hidden');

        }

        function previewHeroImage(event) {

            const reader = new FileReader();

            reader.onload = function() {

                document.getElementById('previewImage').src = reader.result;

            }

            reader.readAsDataURL(event.target.files[0]);

        }

        // Klik luar modal untuk menutup
        document.getElementById('homeModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeHomeModal();
            }
        });
    </script>
@endsection
