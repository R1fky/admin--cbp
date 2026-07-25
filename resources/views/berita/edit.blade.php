@extends('layouts.app')

@section('title', 'Edit Entertainment')
@section('page-title', 'Edit Entertainment')

@section('content')
    <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden max-w-4xl mx-auto">
        {{-- Form Header --}}
        <div class="bg-gradient-to-r from-[#0B1A40] to-[#1E3A8A] px-6 py-5 text-white">
            <h3 class="text-base font-bold tracking-tight">Edit Artikel & Berita</h3>
            <p class="text-slate-300 text-xs mt-0.5">Perbarui rincian artikel publikasi atau berita entertainment di portal CBP Rupiah.</p>
        </div>

        <form action="{{ route('berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Judul --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                        Judul Berita / Artikel
                    </label>
                    <input type="text" name="title" value="{{ old('title', $berita->title) }}" placeholder="Contoh: Cinta Bangga Paham Rupiah Hadir di Festival Digifest"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 @error('title') border-rose-400 focus:ring-rose-200/30 @enderror">
                    @error('title')
                        <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                        Kategori Artikel
                    </label>
                    <select name="kategori_id"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 bg-white @error('kategori_id') border-rose-400 focus:ring-rose-200/30 @enderror">
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id', $berita->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Publish --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                        Tanggal Publikasi
                    </label>
                    <input type="date" name="published_at" value="{{ old('published_at', optional($berita->published_at)->format('Y-m-d')) }}"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 @error('published_at') border-rose-400 focus:ring-rose-200/30 @enderror">
                    @error('published_at')
                        <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Author --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                        Nama Penulis
                    </label>
                    <input type="text" name="author" value="{{ old('author', $berita->author) }}"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30">
                </div>

                {{-- Source --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                        Sumber Informasi
                    </label>
                    <input type="text" name="source" value="{{ old('source', $berita->source) }}"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30">
                </div>

                {{-- Current Image & Change Image --}}
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-4 gap-4 items-end border-t border-slate-100 pt-4">
                    <div class="md:col-span-1">
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">
                            Gambar Saat Ini
                        </label>
                        @if ($berita->image)
                            <img src="{{ asset('storage/' . $berita->image) }}"
                                class="w-full h-24 object-cover rounded-xl border border-slate-200 shadow-sm">
                        @else
                            <div class="w-full h-24 bg-slate-100 rounded-xl border border-slate-200 border-dashed flex items-center justify-center text-slate-400 text-xs">
                                No Thumbnail
                            </div>
                        @endif
                    </div>
                    
                    <div class="md:col-span-3">
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                            Ganti Gambar Banner
                        </label>
                        <input type="file" name="image" accept="image/*"
                            class="w-full text-xs text-slate-500 border border-slate-200 rounded-xl bg-white
                            file:mr-4 file:border-0 file:bg-[#0B1A40] file:text-white file:px-4 file:py-2.5 file:rounded-l-xl file:font-semibold hover:file:bg-[#1E3A8A] file:cursor-pointer @error('image') border-rose-400 @enderror">
                        @error('image')
                            <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Excerpt --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                        Ringkasan Artikel (Excerpt)
                    </label>
                    <textarea name="excerpt" rows="2" placeholder="Tuliskan ringkasan singkat isi artikel..."
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0B1A40]/30 resize-none @error('excerpt') border-rose-400 focus:ring-rose-200/30 @enderror">{{ old('excerpt', $berita->excerpt) }}</textarea>
                    @error('excerpt')
                        <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Content --}}
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                        Isi Konten Artikel Lengkap
                    </label>
                    <div class="overflow-hidden border border-slate-200 rounded-xl">
                        <textarea id="contentEditor" name="content" class="w-full">{{ old('content', $berita->content) }}</textarea>
                    </div>
                    @error('content')
                        <p class="mt-1.5 text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex gap-3 border-t border-slate-100 pt-6">
                <a href="{{ route('berita.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 hover:bg-slate-200 rounded-xl text-xs font-semibold transition">
                    Kembali
                </a>
                <button type="submit" class="px-5 py-2.5 bg-[#0B1A40] hover:bg-[#1E3A8A] text-white rounded-xl text-xs font-semibold transition cursor-pointer">
                    Perbarui Artikel
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#contentEditor'), {
                toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo' ]
            })
            .then(editor => {
                const height = window.innerWidth < 768 ? '250px' : '400px';
                editor.editing.view.change(writer => {
                    writer.setStyle('min-height', height, editor.editing.view.document.getRoot());
                });
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
