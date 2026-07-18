@extends('layouts.app')

@section('title', 'Edit Engagement')
@section('page-title', 'Edit Engagement')

@section('content')

    <div class="bg-white rounded-xl shadow-sm p-6">

        <h2 class="text-2xl font-bold text-[#1C3281] mb-6">
            Edit Engagement
        </h2>

        <form action="{{ route('lomba.update', $lomba) }}" method="POST" enctype="multipart/form-data">
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

                {{-- End Date --}}
                <div>
                    <label class="block mb-2 font-medium">
                        End Date
                    </label>

                    <input type="date" name="end_date"
                        value="{{ old('end_date', optional($lomba->end_date)->format('Y-m-d')) }}"
                        class="w-full border rounded-lg px-4 py-3
                        @error('end_date') border-red-500 @enderror">

                    @error('end_date')
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

                {{-- Ganti Thumbnail --}}
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

                {{-- location_type --}}
                <div>
                    <label class="block mb-2 font-medium">
                        Tipe Lokasi Lomba
                    </label>

                    <select name="location_type"
                        class="w-full border rounded-lg px-4 py-3
                        @error('location_type') border-red-500 @enderror">

                        <option value="online"
                            {{ old('location_type', $lomba->location_type) == 'online' ? 'selected' : '' }}>
                            online
                        </option>

                        <option value="offline"
                            {{ old('location_type', $lomba->location_type) == 'offline' ? 'selected' : '' }}>
                            offline
                        </option>

                    </select>

                    @error('location_type')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Location  --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Lokasi Lomba
                    </label>

                    <input type="text" name="location" value="{{ old('location', $lomba->location) }}"
                        class="w-full border rounded-lg px-4 py-3 @error('location') border-red-500 @enderror">

                    @error('location')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Kuota Peserta --}}
                <div>
                    <label class="block text-sm font-medium mb-2">
                        Kuota Peserta
                    </label>

                    <input type="number" min="1" name="max_participants"
                        value="{{ old('max_participants', $lomba->max_participants) }}" class="w-full border rounded-xl px-4 py-3">
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
