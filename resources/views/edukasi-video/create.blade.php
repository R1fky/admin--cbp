@extends('layouts.app')

@section('title', 'Tambah Video Learning')
@section('page-title', 'Tambah Video Learning')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        {{-- Header Card --}}
        <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h3 class="text-lg font-bold text-slate-800 tracking-tight">
                    Tambah Video Edukasi Baru
                </h3>
                <p class="text-slate-500 text-xs mt-0.5">
                    Anda dapat menambahkan hingga 3 video untuk ditampilkan di halaman depan Learning.
                </p>
            </div>

            <a href="{{ route('edukasi-video.index') }}"
                class="bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 px-5 py-2 rounded-xl text-xs font-semibold transition">
                ← Kembali
            </a>
        </div>

        <form action="{{ route('edukasi-video.store') }}" method="POST" class="space-y-6">
            @csrf

            <div id="videoContainer">
                {{-- Form pertama --}}
                @include('edukasi-video.partials.video-form', ['index' => 0])
            </div>

            {{-- TEMPLATE UNTUK FORM BARU --}}
            <template id="video-template">
                @include('edukasi-video.partials.video-form', ['index' => '__INDEX__'])
            </template>

            <div class="flex items-center justify-between border-t border-slate-100 pt-6">
                <button type="button" id="btnTambahVideo"
                    class="bg-slate-100 hover:bg-slate-200 border border-slate-200 text-slate-700 px-5 py-2.5 rounded-xl text-xs font-semibold transition flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Form Video
                </button>

                <button class="bg-[#0B1A40] hover:bg-[#1E3A8A] text-white px-8 py-2.5 rounded-xl text-xs font-bold transition shadow-md cursor-pointer">
                    Simpan Video
                </button>
            </div>
        </form>
    </div>

    <script>
        const maxVideo = 3;
        const container = document.getElementById("videoContainer");
        const btnTambah = document.getElementById("btnTambahVideo");
        const template = document.getElementById("video-template");

        let index = container.querySelectorAll(".video-form").length;
        updateIndex();

        // Tambah Video
        btnTambah.addEventListener("click", function() {
            if (index >= maxVideo) return;
            const html = template.innerHTML.replaceAll("__INDEX__", index);
            container.insertAdjacentHTML("beforeend", html);
            updateIndex();
        });

        // Hapus Video
        document.addEventListener("click", function(e) {
            const btnHapus = e.target.closest(".hapusVideo");
            if (!btnHapus) return;
            btnHapus.closest(".video-form").remove();
            updateIndex();
        });

        function updateIndex() {
            const forms = container.querySelectorAll(".video-form");
            index = forms.length;

            forms.forEach((form, i) => {
                const nomor = form.querySelector(".video-number");
                if (nomor) nomor.textContent = i + 1;

                const btnHapus = form.querySelector(".hapusVideo");
                if (btnHapus) {
                    if (i === 0) {
                        btnHapus.classList.add("hidden");
                    } else {
                        btnHapus.classList.remove("hidden");
                    }
                }

                const judul = form.querySelector('input[name*="[judul]"]');
                const deskripsi = form.querySelector('textarea[name*="[deskripsi]"]');
                const link = form.querySelector('input[name*="[link]"]');

                if (judul) judul.name = `videos[${i}][judul]`;
                if (deskripsi) deskripsi.name = `videos[${i}][deskripsi]`;
                if (link) link.name = `videos[${i}][link]`;
            });

            if (index >= maxVideo) {
                btnTambah.classList.add("hidden");
            } else {
                btnTambah.classList.remove("hidden");
            }
        }
    </script>
@endsection
