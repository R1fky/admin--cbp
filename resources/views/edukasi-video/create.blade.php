@extends('layouts.app')

@section('title', 'Tambah Video Education')
@section('page-title', 'Tambah Video Education')

@section('content')

    <div class="space-y-6">

        {{-- Header --}}
        <div class="bg-white rounded-xl shadow-sm border-l-4 border-[#CF1A25] p-6">

            <div class="flex justify-between items-center">

                <div>

                    <h3 class="text-2xl font-bold text-[#1C3281]">
                        Tambah Video Education
                    </h3>

                    <p class="text-gray-500 mt-1">
                        Anda dapat menambahkan maksimal 3 video sekaligus.
                    </p>

                </div>

                <a href="{{ route('edukasi-video.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 px-5 py-3 rounded-lg font-semibold">

                    ← Kembali

                </a>

            </div>

        </div>

        <form action="{{ route('edukasi-video.store') }}" method="POST">

            @csrf

            <div id="videoContainer">

                {{-- Form pertama --}}
                @include('edukasi-video.partials.video-form', ['index' => 0])

            </div>

            {{-- TEMPLATE UNTUK FORM BARU --}}
            <template id="video-template">
                @include('edukasi-video.partials.video-form', ['index' => '__INDEX__'])
            </template>

            <div class="flex items-center justify-between mt-6">

                <button type="button" id="btnTambahVideo"
                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg">

                    + Tambah Video

                </button>

                <button class="bg-[#1C3281] hover:bg-blue-900 text-white px-8 py-3 rounded-lg">

                    Simpan

                </button>

            </div>

        </form>

    </div>

    <script>
        const maxVideo = 3;

        const container = document.getElementById("videoContainer");
        const btnTambah = document.getElementById("btnTambahVideo");
        const template = document.getElementById("video-template");

        // Hitung jumlah form saat halaman pertama kali dibuka
        let index = container.querySelectorAll(".video-form").length;

        // Update tampilan
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

            // jumlah form sekarang
            index = forms.length;

            forms.forEach((form, i) => {

                // Nomor video
                const nomor = form.querySelector(".video-number");
                if (nomor) nomor.textContent = i + 1;

                // Tombol hapus
                const btnHapus = form.querySelector(".hapusVideo");

                if (btnHapus) {

                    if (i === 0) {
                        btnHapus.classList.add("hidden");
                        btnHapus.classList.remove("flex");
                    } else {
                        btnHapus.classList.remove("hidden");
                        btnHapus.classList.add("flex");
                    }

                }

                // Update name input
                const judul = form.querySelector('input[name*="[judul]"]');
                const deskripsi = form.querySelector('textarea[name*="[deskripsi]"]');
                const link = form.querySelector('input[name*="[link]"]');

                if (judul) judul.name = `videos[${i}][judul]`;
                if (deskripsi) deskripsi.name = `videos[${i}][deskripsi]`;
                if (link) link.name = `videos[${i}][link]`;

            });

            // Maksimal 3 video
            if (index >= maxVideo) {
                btnTambah.classList.add("hidden");
            } else {
                btnTambah.classList.remove("hidden");
            }

        }
    </script>

@endsection
