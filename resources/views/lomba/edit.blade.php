@extends('layouts.app')

@section('title', 'Edit Lomba')
@section('page-title', 'Edit Lomba')

@section('content')

    <div class="bg-white rounded-xl shadow-sm p-6">

        <h2 class="text-2xl font-bold text-[#1C3281] mb-6">
            Edit Lomba
        </h2>

        <form action="{{ route('lomba.update', $lomba->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Judul  --}}
                <div class="md:col-span-2">

                    <label class="block mb-2 font-medium">
                        Judul Lomba
                    </label>

                    <input type="text" name="title" value="{{ old('title', $lomba->title) }}"
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
                                {{ old('kategori_id', $lomba->kategori_id) == $kategori->id ? 'selected' : '' }}>
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

                {{-- Release Date --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Release Date
                    </label>

                    <input type="date" name="release_date"
                        value="{{ old('release_date', optional($lomba->release_date)->format('Y-m-d')) }}"
                        class="w-full border rounded-lg px-4 py-3
        @error('release_date') border-red-500 @enderror">

                    @error('release_date')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Thumbnail Saat Ini --}}
                <div>
                    <label class="block mb-2 font-medium">
                        Gambar Saat Ini
                    </label>

                    @if ($lomba->thumbnail)
                        <img src="{{ asset('storage/' . $lomba->thumbnail) }}"
                            class="w-full max-w-xs rounded-lg border shadow-sm">
                    @else
                        <div class="w-full h-40 border rounded-lg flex items-center justify-center text-gray-500">
                            Tidak ada gambar
                        </div>
                    @endif
                </div>

                {{-- Status --}}
                <div>
                    <label class="block mb-2 font-medium">
                        Status Lomba
                    </label>

                    <select name="status"
                        class="w-full border rounded-lg px-4 py-3
                        @error('status') border-red-500 @enderror">

                        <option value="sedang_berlangsung"
                            {{ old('status', $lomba->status) == 'sedang_berlangsung' ? 'selected' : '' }}>
                            Sedang Berlangsung
                        </option>

                        <option value="selesai" {{ old('status', $lomba->status) == 'selesai' ? 'selected' : '' }}>
                            Selesai
                        </option>

                    </select>

                    @error('status')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="md:col-span-2">

                    <label class="block mb-2 font-medium">
                        Ganti Thumbnail
                    </label>

                    <input type="file" name="thumbnail"
                        class="w-full border rounded-lg px-4 py-3
                    @error('thumbnail') border-red-500 @enderror">

                    @error('thumbnail')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="md:col-span-2">

                    <label class="block mb-2 font-medium">
                        Description
                    </label>

                    <textarea name="description" rows="4"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1C3281] focus:outline-none">{{ old('description', $lomba->description) }}
                    </textarea>

                    @error('description')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="mt-6 flex gap-3">
                <a href="{{ route('lomba.index') }}" class="px-5 py-3 bg-gray-200 rounded-lg">
                    Kembali
                </a>
                <button type="submit" class="px-6 py-3 bg-[#1C3281] text-white rounded-lg">
                    Update lomba
                </button>
            </div>
        </form>
    </div>
@endsection
