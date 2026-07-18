{{-- Judul --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

    <div class="bg-gradient-to-r from-[#1C3281] to-[#2b4ea2] px-6 py-5">
        <h3 class="text-xl font-bold text-white">
            Informasi Education
        </h3>
        <p class="text-blue-100 text-sm mt-1">
            Lengkapi informasi materi edukasi yang akan ditampilkan pada website.
        </p>
    </div>

    <div class="p-8 space-y-7">

        {{-- Judul --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Judul Education
            </label>

            <input type="text" name="judul" value="{{ old('judul', $edukasi->judul ?? '') }}"
                placeholder="Contoh : Mengenal Ciri Keaslian Uang Rupiah"
                class="w-full rounded-xl border border-gray-300 px-4 py-3 transition focus:border-[#1C3281] focus:ring-4 focus:ring-blue-100 @error('judul') border-red-500 focus:ring-red-100 @enderror">

            @error('judul')
                <p class="text-red-500 text-sm mt-2">
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Deskripsi
            </label>

            <textarea name="deskripsi" rows="5" placeholder="Masukkan deskripsi singkat mengenai materi edukasi..."
                class="w-full rounded-xl border border-gray-300 px-4 py-3 resize-none transition focus:border-[#1C3281] focus:ring-4 focus:ring-blue-100 @error('deskripsi') border-red-500 focus:ring-red-100 @enderror">{{ old('deskripsi', $edukasi->deskripsi ?? '') }}</textarea>

            @error('deskripsi')
                <p class="text-red-500 text-sm mt-2">
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Upload File --}}
        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-3">
                Upload File
            </label>

            <div
                class="rounded-2xl border-2 border-dashed border-gray-300 hover:border-[#1C3281] transition p-6 bg-gray-50">

                <input type="file" name="file" accept=".jpg,.jpeg,.png,.webp,.pdf"
                    class="block w-full text-sm text-gray-600
                        file:mr-4
                        file:rounded-xl
                        file:border-0
                        file:bg-[#1C3281]
                        file:px-5
                        file:py-3
                        file:text-white
                        file:font-semibold
                        hover:file:bg-blue-900
                        cursor-pointer">

                <p class="mt-4 text-sm text-gray-500">
                    Format yang didukung:
                    <span class="font-medium">JPG, JPEG, PNG, WEBP, PDF</span>
                    <br>
                    Maksimal ukuran file <span class="font-semibold">10 MB</span>.
                </p>

            </div>

            {{-- Preview --}}
            @if (!empty($edukasi?->file))

                @php
                    $ext = strtolower(pathinfo($edukasi->file, PATHINFO_EXTENSION));
                @endphp

                <div class="mt-5">

                    <p class="text-sm font-semibold text-gray-700 mb-3">
                        File Saat Ini
                    </p>

                    @if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
                        <div class="inline-block rounded-2xl overflow-hidden border shadow-sm">
                            <img src="{{ asset('storage/' . $edukasi->file) }}" class="w-52 object-cover">
                        </div>
                    @elseif($ext == 'pdf')
                        <div class="flex items-center gap-3 rounded-xl bg-red-50 border border-red-100 p-4">

                            <div class="text-3xl">
                                📄
                            </div>

                            <div>

                                <p class="font-semibold text-red-700">
                                    File PDF
                                </p>

                                <a href="{{ asset('storage/' . $edukasi->file) }}" target="_blank"
                                    class="text-red-600 hover:underline">

                                    Lihat PDF

                                </a>

                            </div>

                        </div>
                    @endif

                </div>

            @endif

            @error('file')
                <p class="text-red-500 text-sm mt-2">
                    {{ $message }}
                </p>
            @enderror

        </div>

        {{-- Link --}}
        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Link Referensi <span class="text-gray-400">(Opsional)</span>
            </label>

            <input type="url" name="link" value="{{ old('link', $edukasi->link ?? '') }}"
                placeholder="https://www.bi.go.id/ atau https://..."
                class="w-full rounded-xl border border-gray-300 px-4 py-3 transition focus:border-[#1C3281] focus:ring-4 focus:ring-blue-100 @error('link') border-red-500 focus:ring-red-100 @enderror">

            @error('link')
                <p class="text-red-500 text-sm mt-2">
                    {{ $message }}
                </p>
            @enderror

            <div class="mt-4 rounded-xl bg-blue-50 border border-blue-100 p-4">

                <div class="flex gap-3">

                    <div class="text-xl">
                        💡
                    </div>

                    <div>

                        <p class="font-semibold text-blue-700">
                            Informasi
                        </p>

                        <p class="text-sm text-blue-600 mt-1 leading-6">
                            Link bersifat opsional. Gunakan jika ingin mengarahkan pengguna
                            ke website resmi, artikel pendukung, atau sumber informasi lainnya.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
