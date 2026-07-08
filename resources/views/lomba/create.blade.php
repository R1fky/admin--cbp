@extends('layouts.app')

@section('title', 'Tambah Engagement')
@section('page-title', 'Tambah Engagement')

@section('content')

    <div class="bg-white rounded-xl shadow-sm p-6">

        <h2 class="text-2xl font-bold text-[#1C3281] mb-6">
            Tambah Engagement
        </h2>

        <form action="{{ route('lomba.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Judul --}}
                <div class="md:col-span-2">

                    <label class="block mb-2 font-medium">
                        Judul Lomba
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

                {{-- Location Type --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Location Type
                    </label>

                    <select name="location_type"
                        class="w-full border rounded-lg px-4 py-3 @error('location_type') border-red-500 @enderror">

                        <option value="online">
                            Online
                        </option>

                        <option value="offline">
                            Offline
                        </option>
                    </select>

                    @error('location_type')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Location --}}
                <div>
                    <label class="block mb-2 font-medium">
                        Location
                    </label>

                    <input type="text" name="location"
                        class="w-full border rounded-lg px-4 py-3 @error('location') border-red-500 @enderror">

                    @error('location')
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

                    <input type="date" name="release_date" value="{{ old('release_date') }}"
                        class="w-full border rounded-lg px-4 py-3 @error('release_date') border-red-500 @enderror">

                    @error('release_date')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- End Date --}}
                <div>
                    <label class="block mb-2 font-medium">
                        End Date
                    </label>

                    <input type="date" name="end_date" value="{{ old('end_date') }}"
                        class="w-full border rounded-lg px-4 py-3 @error('end_date') border-red-500 @enderror">

                    @error('end_date')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Thumb Nail --}}
                <div>
                    <label class="block mb-2 font-medium">
                        Thumbnail
                    </label>

                    <input type="file" name="thumbnail" class="w-full border rounded-lg px-4 py-3">

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
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1C3281] focus:outline-none"></textarea>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <a href="{{ route('lomba.index') }}" class="px-5 py-3 bg-gray-200 rounded-lg">
                    Kembali
                </a>
                <button type="submit" class="px-6 py-3 bg-[#CF1A25] text-white rounded-lg">
                    Simpan lomba
                </button>
            </div>
        </form>
    </div>

@endsection
