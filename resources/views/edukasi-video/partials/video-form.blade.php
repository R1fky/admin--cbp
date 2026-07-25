<div class="video-form bg-white rounded-2xl border border-slate-200/60 overflow-hidden mb-6 shadow-sm">
    {{-- Header --}}
    <div class="flex items-center justify-between px-6 py-4 bg-slate-50 border-b border-slate-200">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center font-bold text-sm">
                #<span class="video-number">{{ is_numeric($index) ? $index + 1 : 1 }}</span>
            </div>
            <div>
                <h4 class="text-sm font-bold text-slate-800">
                    Video Konten Edukasi
                </h4>
            </div>
        </div>

        <button type="button"
            class="hapusVideo hidden items-center gap-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 px-3 py-1.5 border border-rose-100 rounded-lg text-xs font-semibold transition cursor-pointer">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            <span>Hapus Video</span>
        </button>
    </div>

    {{-- Body --}}
    <div class="p-6 space-y-5">
        {{-- Judul --}}
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                Judul Video
            </label>
            <input type="text" name="videos[{{ $index }}][judul]" required
                placeholder="Contoh: Cara Mengenali Ciri Keaslian Uang Rupiah"
                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 transition">
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                Deskripsi Singkat Video
            </label>
            <textarea rows="3" name="videos[{{ $index }}][deskripsi]" required placeholder="Tuliskan keterangan isi video edukatif ini..."
                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 transition"></textarea>
        </div>

        {{-- Link --}}
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                Tautan / URL Video YouTube
            </label>
            <input type="url" name="videos[{{ $index }}][link]" required
                placeholder="https://www.youtube.com/watch?v=..."
                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 transition">

            <div class="mt-4 rounded-xl bg-blue-50/60 border border-blue-100 p-4">
                <div class="flex items-start gap-2.5">
                    <span class="text-sm">💡</span>
                    <div>
                        <p class="font-bold text-xs text-blue-800">Media yang didukung</p>
                        <p class="text-xs text-blue-600 mt-1 leading-relaxed">
                            Kami merekomendasikan tautan langsung YouTube, Google Drive, Vimeo, atau media lain yang terpublikasikan secara publik agar dapat langsung diputar.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
