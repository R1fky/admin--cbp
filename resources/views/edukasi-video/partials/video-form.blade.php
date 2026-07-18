<div class="video-form bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">

    {{-- Header --}}
    <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-[#1C3281] to-[#2b4ea2]">

        <div class="flex items-center gap-3">

            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-white text-lg">
                🎥
            </div>

            <div>
                <h4 class="text-lg font-bold text-white">
                    Video <span class="video-number">1</span>
                </h4>

                <p class="text-sm text-blue-100">
                    Informasi video edukasi
                </p>
            </div>

        </div>

        <button type="button"
            class="hapusVideo hidden items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">

            🗑
            <span>Hapus</span>

        </button>

    </div>

    {{-- Body --}}
    <div class="p-6 space-y-6">

        {{-- Judul --}}
        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Judul Video
            </label>

            <input type="text" name="videos[{{ $index }}][judul]"
                placeholder="Contoh : Cara Mengenali Uang Rupiah Asli"
                class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-[#1C3281] focus:ring-4 focus:ring-blue-100 transition">

        </div>

        {{-- Deskripsi --}}
        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Deskripsi
            </label>

            <textarea rows="4" name="videos[{{ $index }}][deskripsi]" placeholder="Masukkan deskripsi singkat video..."
                class="w-full rounded-xl border border-gray-300 px-4 py-3 resize-none focus:border-[#1C3281] focus:ring-4 focus:ring-blue-100 transition"></textarea>

        </div>

        {{-- Link --}}
        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Link Video
            </label>

            <input type="url" name="videos[{{ $index }}][link]"
                placeholder="https://youtube.com/... atau https://drive.google.com/..."
                class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-[#1C3281] focus:ring-4 focus:ring-blue-100 transition">

            <div class="mt-3 rounded-xl bg-blue-50 border border-blue-100 p-4">

                <div class="flex items-start gap-3">

                    <div class="text-xl">
                        💡
                    </div>

                    <div>

                        <p class="font-semibold text-blue-700">
                            Link yang didukung
                        </p>

                        <ul class="mt-1 text-sm text-blue-600 space-y-1">
                            <li>• YouTube</li>
                            <li>• Google Drive</li>
                            <li>• Vimeo</li>
                            <li>• Website lainnya</li>
                        </ul>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
