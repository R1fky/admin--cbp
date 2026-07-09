<div class="mb-4">
    <label class="block mb-2 font-semibold">
        Judul
    </label>

    <input type="text" name="judul" value="{{ old('judul', $edukasi->judul ?? '') }}"
        class="w-full border rounded-lg px-4 py-2">

    @error('judul')
        <p class="text-red-500 text-sm mt-1">
            {{ $message }}
        </p>
    @enderror
</div>

<div class="mb-4">
    <label class="block mb-2 font-semibold">
        Deskripsi
    </label>

    <textarea name="deskripsi" rows="5" class="w-full border rounded-lg px-4 py-2">{{ old('deskripsi', $edukasi->deskripsi ?? '') }}</textarea>

    @error('deskripsi')
        <p class="text-red-500 text-sm mt-1">
            {{ $message }}
        </p>
    @enderror
</div>

<div class="mb-4">
    <label class="block mb-2 font-semibold">
        Content
    </label>

    <textarea id="contentEditor" name="content">
        {{ old('content', $edukasi->content ?? '') }}
    </textarea>

    @error('content')
        <p class="text-red-500 text-sm mt-1">
            {{ $message }}
        </p>
    @enderror
</div>

<div class="mb-4">
    <label class="block mb-2 font-semibold">
        Upload File
    </label>

    <input type="file" name="file" accept=".jpg,.jpeg,.png,.webp,.pdf" class="w-full border rounded-lg px-4 py-2">

    <p class="text-sm text-gray-500 mt-2">
        Format yang diperbolehkan:
        JPG, JPEG, PNG, WEBP, PDF.
    </p>

    @if (!empty($edukasi?->file))
        @php
            $ext = strtolower(pathinfo($edukasi->file, PATHINFO_EXTENSION));
        @endphp

        <div class="mt-3">

            @if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
                <img src="{{ asset('storage/' . $edukasi->file) }}" class="w-40 rounded-lg border">
            @elseif($ext == 'pdf')
                <a href="{{ asset('storage/' . $edukasi->file) }}" target="_blank" class="text-red-600 underline">
                    📄 Lihat PDF
                </a>
            @endif

        </div>
    @endif

    @error('file')
        <p class="text-red-500 text-sm mt-1">
            {{ $message }}
        </p>
    @enderror
</div>

<div class="mb-6">
    <label class="block mb-2 font-semibold">
        Link (Opsional)
    </label>

    <input type="url" name="link" value="{{ old('link', $edukasi->link ?? '') }}"
        placeholder="https://youtube.com/... atau https://www.bi.go.id/..." class="w-full border rounded-lg px-4 py-2">

    @error('link')
        <p class="text-red-500 text-sm mt-1">
            {{ $message }}
        </p>
    @enderror
</div>
