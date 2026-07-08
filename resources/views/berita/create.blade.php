@extends('layouts.app')

@section('title', 'Tambah Entertainment')
@section('page-title', 'Tambah Entertainment')

@section('content')

    <div class="bg-white rounded-xl shadow-sm p-6">

        <h2 class="text-2xl font-bold text-[#1C3281] mb-6">
            Tambah Entertainment
        </h2>

        <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Judul --}}
                <div class="md:col-span-2">

                    <label class="block mb-2 font-medium">
                        Judul Berita
                    </label>

                    <input type="text" name="title" value="{{ old('title') }}"
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
                        class="w-full border rounded-lg px-4 py-3 @error('kategori_id') border-red-500 @enderror">

                        <option value="">
                            Pilih Kategori
                        </option>

                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>

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

                    <input type="date" name="published_at" value="{{ old('published_at') }}"
                        class="w-full border rounded-lg px-4 py-3 @error('published_at') border-red-500 @enderror">

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

                    <input type="text" name="author" value="{{ old('author', 'Admin') }}"
                        class="w-full border rounded-lg px-4 py-3">

                </div>

                {{-- Source --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Sumber
                    </label>

                    <input type="text" name="source" placeholder="Bank Indonesia"
                        value="{{ old('source', 'Bank Indonesia') }}" class="w-full border rounded-lg px-4 py-3">

                </div>

                {{-- Image --}}
                <div class="md:col-span-2">

                    <label class="block mb-2 font-medium">
                        Thumbnail
                    </label>

                    <input type="file" name="image" class="w-full border rounded-lg px-4 py-3">

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

                    <textarea name="excerpt" rows="3" class="w-full border rounded-lg px-4 py-3">{{ old('excerpt') }}</textarea>

                    @error('excerpt')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Content --}}
                <div class="col-span-1 md:col-span-2">

                    <label class="block mb-2 font-medium">
                        Isi Berita
                    </label>

                    <div class="overflow-x-auto">
                        <textarea id="contentEditor" name="content" class="w-full">{{ old('content') }}</textarea>
                    </div>

                    @error('content')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

            <div class="mt-6 flex gap-3">

                <a href="{{ route('berita.index') }}" class="px-5 py-3 bg-gray-200 rounded-lg">

                    Kembali

                </a>

                <button type="submit" class="px-6 py-3 bg-[#CF1A25] text-white rounded-lg">

                    Simpan Berita

                </button>

            </div>

        </form>

    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#contentEditor'))
            .then(editor => {

                const height = window.innerWidth < 768 ? '300px' : '500px';

                editor.editing.view.change(writer => {
                    writer.setStyle(
                        'min-height',
                        height,
                        editor.editing.view.document.getRoot()
                    );
                });

            })
            .catch(error => {
                console.error(error);
            });
    </script>

@endsection
