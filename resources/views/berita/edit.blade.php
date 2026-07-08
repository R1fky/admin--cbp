@extends('layouts.app')

@section('title', 'Edit Entertainment')
@section('page-title', 'Edit Entertainment')

@section('content')

    <div class="bg-white rounded-xl shadow-sm p-6">

        <h2 class="text-2xl font-bold text-[#1C3281] mb-6">
            Edit Entertainment
        </h2>

        <form action="{{ route('berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Judul  --}}
                <div class="md:col-span-2">

                    <label class="block mb-2 font-medium">
                        Judul Berita
                    </label>

                    <input type="text" name="title" value="{{ old('title', $berita->title) }}"
                        class="w-full border rounded-lg px-4 py-3 @error('title') border-red-500 @enderror">

                    @error('title')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block mb-2 font-medium">
                        Kategori
                    </label>
                    <select name="kategori_id"
                        class="w-full border rounded-lg px-4 py-3
                            @error('kategori_id') border-red-500 @enderror">
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}"
                                {{ old('kategori_id', $berita->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Publish --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Published At
                    </label>

                    <input type="date" name="published_at"
                        value="{{ old('published_at', optional($berita->published_at)->format('Y-m-d')) }}"
                        class="w-full border rounded-lg px-4 py-3
        @error('published_at') border-red-500 @enderror">

                    @error('published_at')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Author --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Penulis
                    </label>

                    <input type="text" name="author" value="{{ old('author', $berita->author) }}"
                        class="w-full border rounded-lg px-4 py-3">

                </div>

                {{-- Source --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Sumber
                    </label>

                    <input type="text" name="source" value="{{ old('source', $berita->source) }}"
                        class="w-full border rounded-lg px-4 py-3">

                </div>

                {{-- Image --}}
                <div class="md:col-span-2">

                    <label class="block mb-2 font-medium">
                        Gambar Saat Ini
                    </label>

                    @if ($berita->image)
                        <img src="{{ asset('storage/' . $berita->image) }}" class="w-64 rounded-lg border">
                    @else
                        <p class="text-gray-500">
                            Tidak ada gambar
                        </p>
                    @endif

                </div>

                <div class="md:col-span-2">

                    <label class="block mb-2 font-medium">
                        Ganti Thumbnail
                    </label>

                    <input type="file" name="image"
                        class="w-full border rounded-lg px-4 py-3
        @error('image') border-red-500 @enderror">

                    @error('image')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Excerpt --}}
                <div class="md:col-span-2">

                    <label class="block mb-2 font-medium">
                        Ringkasan Berita
                    </label>

                    <textarea name="excerpt" rows="3" class="w-full border rounded-lg px-4 py-3">{{ old('excerpt', $berita->excerpt) }}</textarea>

                    @error('excerpt')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Content --}}
                <div class="md:col-span-2">

                    <label class="block mb-2 font-medium">
                        Isi Berita
                    </label>

                    <textarea id="contentEditor" name="content">
                        {{ old('content', $berita->content) }}
                    </textarea>

                    @error('content')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="mt-6 flex gap-3">
                <a href="{{ route('berita.index') }}" class="px-5 py-3 bg-gray-200 rounded-lg">
                    Kembali
                </a>
                <button type="submit" class="px-6 py-3 bg-[#1C3281] text-white rounded-lg">
                    Update Berita
                </button>
            </div>

        </form>

    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#contentEditor'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
