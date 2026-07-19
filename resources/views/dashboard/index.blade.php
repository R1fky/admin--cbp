@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    @if (session('success'))
        <div id="toastSuccess"
            class="fixed top-6 right-6 z-[9999] translate-x-[120%]
    rounded-2xl bg-green-500 text-white shadow-2xl px-6 py-5">

            <div class="flex items-start gap-4">

                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white/20 text-xl">

                    ✅

                </div>

                <div>

                    <h3 class="font-bold">
                        Berhasil
                    </h3>

                    <p class="text-sm text-green-100 mt-1">
                        {{ session('success') }}
                    </p>

                </div>

                <button onclick="closeToast('toastSuccess')" class="ml-3 text-xl hover:opacity-70">

                    ×

                </button>

            </div>

        </div>
    @endif

    @if ($errors->any())
        <div id="toastError"
            class="fixed top-6 right-6 z-[9999] translate-x-[120%]
    rounded-2xl bg-red-500 text-white shadow-2xl px-6 py-5">

            <div class="flex items-start gap-4">

                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white/20 text-xl">

                    ❌

                </div>

                <div>

                    <h3 class="font-bold">
                        Terjadi Kesalahan
                    </h3>

                    <ul class="mt-1 text-sm text-red-100 list-disc pl-5">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

                <button onclick="closeToast('toastError')" class="ml-3 text-xl hover:opacity-70">

                    ×

                </button>

            </div>

        </div>
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
    <div id="homeModal" class="fixed inset-0 hidden items-center justify-center bg-black/60 z-50 p-6">
        <div class="bg-white rounded-2xl w-full max-w-7xl max-h-[92vh] overflow-y-auto shadow-2xl">
            {{-- Header --}}
            <div
                class="bg-gradient-to-r from-[#1C3281] to-blue-700 text-white px-8 py-6 rounded-t-2xl flex items-center justify-between">

                <div>
                    <h2 class="text-2xl font-bold">
                        ⚙️ Pengaturan Halaman Home
                    </h2>

                    <p class="text-blue-100 mt-1 text-sm">
                        Kelola Hero Banner dan Running Text Website
                    </p>
                </div>

                <button onclick="closeHomeModal()"
                    class="w-10 h-10 rounded-full bg-white/20 hover:bg-red-500 transition flex items-center justify-center text-2xl">
                    ×
                </button>

            </div>
            <div class="p-8">

                <div class="grid xl:grid-cols-5 gap-8">

                    {{-- ========================================= --}}
                    {{-- HERO BANNER --}}
                    {{-- ========================================= --}}
                    <div class="xl:col-span-2">

                        <div class="bg-gray-50 rounded-2xl border p-6">

                            <div class="flex items-center justify-between mb-6">

                                <div>

                                    <h3 class="text-xl font-bold text-[#1C3281]">
                                        Hero Banner
                                    </h3>

                                    <p class="text-sm text-gray-500">
                                        Maksimal 3 Hero Banner
                                    </p>

                                </div>

                            </div>

                            <div class="space-y-6">

                                @for ($i = 1; $i <= 3; $i++)
                                    @php
                                        $hero = $heroes->firstWhere('sort_order', $i);
                                    @endphp

                                    <div class="overflow-hidden rounded-xl border bg-white shadow-sm">

                                        <img src="{{ $hero ? asset('storage/' . $hero->image) : 'https://placehold.co/700x350?text=Hero+' . $i }}"
                                            class="w-full h-44 object-cover">

                                        <div class="p-5">

                                            <h4 class="font-bold text-lg">
                                                Hero {{ $i }}
                                            </h4>

                                            @if ($hero)
                                                <p class="font-semibold mt-3">
                                                    {{ $hero->title }}
                                                </p>

                                                <p class="text-sm text-gray-500 mt-2 line-clamp-3">
                                                    {{ $hero->description }}
                                                </p>
                                            @else
                                                <p class="text-gray-400 mt-3">
                                                    Belum ada Hero
                                                </p>
                                            @endif

                                            <div class="flex gap-2 mt-5">

                                                @if ($hero)
                                                    <button onclick='editHero(@json($hero))'
                                                        class="flex-1 rounded-xl bg-[#1C3281] py-2 text-white hover:bg-blue-900">

                                                        ✏️ Edit

                                                    </button>

                                                    <form action="{{ route('dashboard.hero.destroy', $hero) }}"
                                                        method="POST">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button onclick="return confirm('Hapus Hero?')"
                                                            class="w-11 h-11 rounded-xl bg-red-500 text-white hover:bg-red-600">

                                                            🗑️

                                                        </button>

                                                    </form>
                                                @else
                                                    <button onclick="openHeroModal({{ $i }})"
                                                        class="w-full rounded-xl bg-[#1C3281] py-2 text-white hover:bg-blue-900">

                                                        + Tambah Hero

                                                    </button>
                                                @endif

                                            </div>

                                        </div>

                                    </div>
                                @endfor

                            </div>

                        </div>

                    </div>

                    {{-- ========================================= --}}
                    {{-- RUNNING TEXT --}}
                    {{-- ========================================= --}}
                    <div class="xl:col-span-3">

                        <div class="bg-gray-50 rounded-2xl border p-6">

                            <h3 class="text-xl font-bold text-[#1C3281]">
                                Running Text
                            </h3>

                            <p class="text-gray-500 text-sm mt-1">
                                Tambahkan teks berjalan yang akan tampil pada website.
                            </p>

                            <form action="{{ route('dashboard.runningtext.store') }}" method="POST" class="mt-6">

                                @csrf

                                <textarea name="running_text" rows="3" placeholder="Masukkan Running Text..."
                                    class="w-full rounded-xl border px-4 py-3 resize-none focus:ring-2 focus:ring-[#1C3281]">{{ old('running_text') }}</textarea>

                                <div class="mt-4 flex justify-end">

                                    <button class="rounded-xl bg-[#1C3281] px-6 py-3 text-white hover:bg-blue-900">

                                        Simpan Running Text

                                    </button>

                                </div>

                            </form>

                        </div>

                        {{-- LIST --}}
                        <div class="bg-white rounded-2xl border shadow-sm mt-8">

                            <div class="flex items-center justify-between p-5 border-b">

                                <h3 class="font-bold text-[#1C3281]">
                                    Daftar Running Text
                                </h3>

                                <span class="rounded-full bg-blue-100 px-4 py-1 text-sm font-semibold text-blue-700">

                                    {{ $setting->count() }} Data

                                </span>

                            </div>

                            <div class="max-h-[450px] overflow-y-auto p-5 space-y-4">

                                @forelse($setting as $item)
                                    <div class="rounded-xl border bg-gray-50 hover:bg-white hover:shadow transition p-5">

                                        <div class="flex justify-between gap-5">

                                            <div class="flex-1">

                                                <p class="leading-7 text-gray-700">

                                                    {{ $item->running_text }}

                                                </p>

                                                <div class="text-xs text-gray-400 mt-3">

                                                    {{ $item->created_at->format('d M Y H:i') }}

                                                </div>

                                            </div>

                                            <form action="{{ route('dashboard.runningtext.destroy', $item->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus running text ini?')">

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    class="rounded-xl bg-red-500 hover:bg-red-600 text-white px-4 py-2">

                                                    🗑️ Hapus

                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                @empty

                                    <div class="py-14 text-center text-gray-400">

                                        Belum ada Running Text.

                                    </div>
                                @endforelse

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Hero Modal -->
    <div id="heroModal" class="fixed inset-0 hidden items-center justify-center bg-black/60 z-[60] p-4">

        <div class="bg-white rounded-xl shadow-xl w-full max-w-md">

            <!-- Header -->
            <div class="flex items-center justify-between border-b px-5 py-4">

                <h2 id="heroModalTitle" class="text-lg font-bold text-[#1C3281]">
                    Tambah Hero
                </h2>

                <button onclick="closeHeroModal()" class="text-2xl text-gray-500 hover:text-red-500">
                    &times;
                </button>

            </div>

            <form id="heroForm" method="POST" enctype="multipart/form-data" class="p-5">

                @csrf

                <input type="hidden" id="hero_method" name="_method" value="POST">

                <input type="hidden" id="sort_order" name="sort_order">

                <!-- Judul -->
                <div class="mb-4">

                    <label class="block text-sm font-semibold mb-2">
                        Judul Hero
                    </label>

                    <input id="hero_title" type="text" name="title"
                        class="w-full rounded-lg border px-3 py-2 text-sm">

                </div>

                <!-- Deskripsi -->
                <div class="mb-4">

                    <label class="block text-sm font-semibold mb-2">
                        Deskripsi
                    </label>

                    <textarea id="hero_description" name="description" rows="2"
                        class="w-full rounded-lg border px-3 py-2 text-sm resize-none"></textarea>

                </div>

                <!-- Upload -->
                <div class="mb-4">

                    <label class="block text-sm font-semibold mb-2">
                        Upload Gambar
                    </label>

                    <input id="hero_image" type="file" name="image" accept="image/*" onchange="previewHero(event)"
                        class="w-full rounded-lg border border-gray-300 bg-white text-sm
           file:mr-4 file:border-0
           file:bg-[#1C3281] file:text-white
           file:px-4 file:py-2
           file:rounded-l-lg
           file:cursor-pointer
           hover:file:bg-blue-900">

                </div>

                <!-- Preview -->
                <div class="mb-5">

                    <img id="hero_preview" src="https://placehold.co/500x220?text=Preview"
                        class="w-full h-28 rounded-lg border object-cover">

                </div>

                <!-- Button -->
                <div class="flex justify-end gap-2 border-t pt-4">

                    <button type="button" onclick="closeHeroModal()" class="rounded-lg bg-gray-200 px-4 py-2 text-sm">

                        Batal

                    </button>

                    <button type="submit" class="rounded-lg bg-[#1C3281] px-4 py-2 text-sm text-white hover:bg-blue-900">

                        Simpan

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

        function openHeroModal(sort) {

            document.getElementById('heroModal').classList.remove('hidden');
            document.getElementById('heroModal').classList.add('flex');

            document.getElementById('heroModalTitle').innerHTML = "Tambah Hero";

            document.getElementById('heroForm').action =
                "{{ route('dashboard.hero.store') }}";

            document.getElementById('hero_method').value = "POST";

            document.getElementById('sort_order').value = sort;

            document.getElementById('hero_title').value = "";

            document.getElementById('hero_description').value = "";

            document.getElementById('hero_preview').src =
                "https://placehold.co/600x300?text=Preview";
        }

        function editHero(hero) {

            document.getElementById('heroModal').classList.remove('hidden');
            document.getElementById('heroModal').classList.add('flex');

            document.getElementById('heroModalTitle').innerHTML = "Edit Hero";

            document.getElementById('heroForm').action =
                "/dashboard/heroes/" + hero.id;

            document.getElementById('hero_method').value = "PUT";

            document.getElementById('sort_order').value = hero.sort_order;

            document.getElementById('hero_title').value = hero.title;

            document.getElementById('hero_description').value = hero.description ?? "";

            document.getElementById('hero_preview').src =
                "/storage/" + hero.image;
        }

        function closeHeroModal() {

            document.getElementById('heroModal').classList.remove('flex');
            document.getElementById('heroModal').classList.add('hidden');
        }

        function previewHero(event) {

            const reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('hero_preview').src = e.target.result;
            };

            reader.readAsDataURL(event.target.files[0]);
        }

        document.getElementById('heroModal').addEventListener('click', function(e) {

            if (e.target === this) {

                closeHeroModal();

            }

        });

        function showToast(id) {

            const toast = document.getElementById(id);

            if (!toast) return;

            toast.style.transition = "all .45s ease";

            setTimeout(() => {
                toast.style.transform = "translateX(-120%)";
            }, 100);

            setTimeout(() => {
                toast.style.transform = "translateX(0)";
            }, 4000);

            setTimeout(() => {
                toast.remove();
            }, 4500);

        }

        function closeToast(id) {

            const toast = document.getElementById(id);

            if (!toast) return;

            toast.style.transform = "translateX(120%)";

            toast.style.opacity = "0";

            setTimeout(() => toast.remove(), 300);

        }

        @if (session('success'))
            showToast("toastSuccess");
        @endif

        @if ($errors->any())
            showToast("toastError");
        @endif

        @if (session('openHomeModal'))
            document.addEventListener('DOMContentLoaded', function() {
                openHomeModal();
            });
        @endif
    </script>
@endsection
