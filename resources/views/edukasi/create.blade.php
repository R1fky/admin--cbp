@extends('layouts.app')

@section('title', 'Tambah Edukasi')
@section('page-title', 'Tambah Edukasi')

@section('content')
    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('edukasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('edukasi.form', ['edukasi' => null])
            <div class="mt-6 flex gap-3">
                <a href="{{ route('edukasi.index') }}" class="px-5 py-3 bg-gray-200 rounded-lg">
                    Kembali
                </a>
                <button type="submit" class="px-6 py-3 bg-[#CF1A25] text-white rounded-lg">
                    Simpan Edukasi
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
