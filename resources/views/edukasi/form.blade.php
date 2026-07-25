{{-- Informasi Form --}}
<div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden">
    <div class="bg-gradient-to-r from-[#0B1A40] to-[#1E3A8A] px-6 py-5 text-white">
        <h3 class="text-sm font-bold tracking-wide uppercase">Informasi Materi Edukasi</h3>
        <p class="text-slate-300 text-xs mt-0.5">Lengkapi data materi edukasi yang akan dipublikasikan pada portal.</p>
    </div>

    <div class="p-6 md:p-8 space-y-6">
        {{-- Judul --}}
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                Judul Materi Edukasi
            </label>
            <input type="text" name="judul" value="{{ old('judul', $edukasi->judul ?? '') }}"
                placeholder="Contoh: Mengenal Ciri Keaslian Uang Rupiah (CIKUR)"
                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 @error('judul') border-rose-400 focus:ring-rose-200/30 @enderror">
            @error('judul')
                <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                Deskripsi Lengkap
            </label>
            <textarea name="deskripsi" rows="5" placeholder="Tuliskan deskripsi ringkas mengenai poin-poin materi edukasi yang dibahas..."
                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 resize-none @error('deskripsi') border-rose-400 focus:ring-rose-200/30 @enderror">{{ old('deskripsi', $edukasi->deskripsi ?? '') }}</textarea>
            @error('deskripsi')
                <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        {{-- Upload File --}}
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                Berkas Lampiran / Media Gambar
            </label>
            <div class="rounded-xl border border-dashed border-slate-200 p-6 bg-slate-50/50 hover:bg-slate-50 transition duration-150">
                <input type="file" name="file" accept=".jpg,.jpeg,.png,.webp,.pdf"
                    class="block w-full text-xs text-slate-500
                        file:mr-4 file:border-0 file:bg-[#0B1A40] file:text-white file:px-4 file:py-2.5 file:rounded-xl file:font-semibold hover:file:bg-[#1E3A8A] file:cursor-pointer @error('file') border-rose-400 @enderror">
                <p class="mt-3 text-[11px] text-slate-400">
                    Ekstensi yang didukung: <span class="font-semibold">JPG, JPEG, PNG, WEBP, PDF</span> (Maksimal 10 MB).
                </p>
            </div>

            {{-- Preview File Saat Ini --}}
            @if (!empty($edukasi?->file))
                @php
                    $ext = strtolower(pathinfo($edukasi->file, PATHINFO_EXTENSION));
                @endphp

                <div class="mt-4 border-t border-slate-100 pt-4">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Berkas Saat Ini</span>
                    @if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
                        <div class="inline-block rounded-xl overflow-hidden border border-slate-200 shadow-sm bg-white p-1">
                            <img src="{{ asset('storage/' . $edukasi->file) }}" class="h-28 object-cover rounded-lg">
                        </div>
                    @elseif($ext == 'pdf')
                        <div class="inline-flex items-center gap-3 rounded-xl bg-rose-50/80 border border-rose-100 p-3">
                            <span class="text-2xl">📄</span>
                            <div>
                                <p class="font-bold text-xs text-rose-800">Berkas PDF</p>
                                <a href="{{ asset('storage/' . $edukasi->file) }}" target="_blank"
                                    class="text-[11px] text-rose-600 hover:text-rose-700 font-semibold hover:underline mt-0.5 inline-block">
                                    Lihat Berkas PDF
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            @error('file')
                <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        {{-- Link --}}
        <div>
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                Tautan / Link Referensi Eksternal <span class="text-slate-400 font-normal">(Opsional)</span>
            </label>
            <input type="url" name="link" value="{{ old('link', $edukasi->link ?? '') }}"
                placeholder="Contoh: https://www.bi.go.id/id/rupiah/default.aspx"
                class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 @error('link') border-rose-400 focus:ring-rose-200/30 @enderror">
            @error('link')
                <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
            @enderror

            <div class="mt-4 rounded-xl bg-blue-50/60 border border-blue-100 p-4">
                <div class="flex gap-2.5 items-start">
                    <span class="text-sm">💡</span>
                    <div>
                        <p class="font-bold text-xs text-blue-800">Informasi Penting</p>
                        <p class="text-xs text-blue-600 mt-1 leading-relaxed">
                            Gunakan kolom tautan referensi jika Anda ingin mengarahkan pengguna ke situs web Bank Indonesia, artikel pendukung resmi, atau media video interaktif luar.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
