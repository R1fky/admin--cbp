@extends('layouts.app')

@section('title', 'Kelola Lomba')
@section('page-title', 'Kelola Lomba')

@section('content')
    @if (session('success'))
        <div id="toastSuccess"
            class="fixed top-5 right-5 z-50 bg-white border-l-4 border-green-500 shadow-xl rounded-xl px-5 py-4 min-w-[320px]">
            <div class="flex items-start gap-3">
                <div class="bg-green-100 p-2 rounded-full">
                    ✅
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold text-gray-800">
                        Berhasil
                    </h4>
                    <p class="text-gray-600 text-sm">
                        {{ session('success') }}
                    </p>
                </div>
                <button onclick="document.getElementById('toastSuccess').remove()" class="text-gray-400 hover:text-gray-600">
                    ✕
                </button>
            </div>
        </div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('toastSuccess');

                if (toast) {
                    toast.style.transition = 'all .5s ease';
                    toast.style.transform = 'translateX(100%)';
                    toast.style.opacity = '0';

                    setTimeout(() => toast.remove(), 500);
                }
            }, 4000);
        </script>
    @endif

    <div class="space-y-6">
        {{-- Header --}}
        <div class="bg-white rounded-xl shadow-sm border-l-4 border-[#CF1A25] p-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-[#1C3281]">
                        Kelola Lomba
                    </h3>

                    <p class="text-gray-500 mt-1">
                        Kelola seluruh data lomba dan kompetisi Bank Indonesia.
                    </p>
                </div>
                <button onclick="document.getElementById('createModal').classList.remove('hidden')"
                    class="bg-[#1C3281] hover:bg-blue-900 text-white px-4 py-2 md:px-5 md:py-3 rounded-lg font-semibold transition">
                    + Tambah Lomba
                </button>

            </div>

        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow-sm overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#1C3281] text-white">
                    <tr>
                        <th class="px-6 py-4 text-left">
                            Thumbnail
                        </th>
                        <th class="px-6 py-4 text-left">
                            Judul
                        </th>
                        <th class="px-6 py-4 text-left">
                            Tanggal Rilis
                        </th>
                        <th class="px-6 py-4 text-center">
                            Status
                        </th>
                        <th class="px-6 py-4 text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lombas as $lomba)
                        <tr class="border-b hover:bg-slate-50">
                            <td class="px-6 py-4">
                                @if ($lomba->thumbnail)
                                    <img src="{{ asset('storage/' . $lomba->thumbnail) }}"
                                        class="w-20 h-12 object-cover rounded">
                                @else
                                    <div class="w-20 h-12 bg-gray-200 rounded"></div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <h4 class="font-semibold text-gray-800">
                                    {{ $lomba->title }}
                                </h4>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $lomba->release_date ? \Carbon\Carbon::parse($lomba->release_date)->format('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($lomba->status == 'sedang_berlangsung')
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                                        Sedang Berlangsung
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">
                                        Selesai
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    {{-- edit lomba --}}
                                    <button
                                        onclick="openEditModal(
                                            '{{ $lomba->id }}',
                                            @js($lomba->title),
                                            @js($lomba->description),
                                            '{{ $lomba->release_date }}',
                                            '{{ $lomba->status }}'
                                        )"
                                        class="bg-blue-100 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-200">
                                        Edit
                                    </button>
                                    {{-- hapus lomba --}}
                                    <button
                                        onclick="openDeleteModal(
                                            '{{ $lomba->id }}',
                                            '{{ $lomba->title }}'
                                        )"
                                        class="bg-red-100 text-red-700 px-3 py-2 rounded-lg hover:bg-red-200">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-gray-500">
                                Belum ada data lomba
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div>
            {{ $lombas->links() }}
        </div>

    </div>

    {{-- Modal Tambah Lomba --}}
    <div id="createModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl w-full max-w-md md:max-w-lg max-h-[90vh] overflow-y-auto p-5 shadow-xl">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-xl font-bold text-[#1C3281]">
                    Tambah Lomba
                </h3>
                <button onclick="document.getElementById('createModal').classList.add('hidden')">
                    ✕
                </button>
            </div>

            <form action="{{ route('lomba.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block mb-2 font-medium">
                            Judul Lomba
                        </label>
                        <input type="text" name="title"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1C3281] focus:outline-none">
                    </div>
                    <div>
                        <label class="block mb-2 font-medium">
                            Thumbnail
                        </label>
                        <input type="file" name="thumbnail" class="w-full border rounded-lg px-4 py-3">
                    </div>
                    <div>
                        <label class="block mb-2 font-medium">
                            Tanggal Rilis
                        </label>
                        <input type="date" name="release_date" class="w-full border rounded-lg px-4 py-3">
                    </div>

                    <div>

                        <label class="block mb-2 font-medium">
                            Status
                        </label>
                        <select name="status"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1C3281] focus:outline-none">

                            <option value="sedang_berlangsung">
                                Sedang Berlangsung
                            </option>

                            <option value="selesai">
                                Selesai
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 font-medium">
                            Deskripsi
                        </label>
                        <textarea name="description" rows="4"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1C3281] focus:outline-none"></textarea>
                    </div>
                    <button type="submit"
                        class="w-full bg-[#CF1A25] hover:bg-red-700 text-white py-2.5 rounded-lg font-semibold transition">
                        Simpan Lomba
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div id="editModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl w-full max-w-md md:max-w-lg max-h-[90vh] overflow-y-auto p-5 shadow-xl">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-xl font-bold text-[#1C3281]">
                    Edit Lomba
                </h3>
                <button onclick="closeEditModal()">
                    ✕
                </button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block mb-2 font-medium">
                            Judul Lomba
                        </label>
                        <input id="edit_title" type="text" name="title"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5">
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">
                            Thumbnail Baru
                        </label>

                        <input type="file" name="thumbnail" class="w-full border rounded-lg px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">
                            Tanggal Rilis
                        </label>

                        <input id="edit_release_date" type="date" name="release_date"
                            class="w-full border rounded-lg px-4 py-3">
                    </div>
                    <div>
                        <label class="block mb-2 font-medium">
                            Status
                        </label>
                        <select id="edit_status" name="status" class="w-full border rounded-lg px-4 py-3">
                            <option value="sedang_berlangsung">
                                Sedang Berlangsung
                            </option>
                            <option value="selesai">
                                Selesai
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 font-medium">
                            Deskripsi
                        </label>
                        <textarea id="edit_description" name="description" rows="4" class="w-full border rounded-lg px-4 py-3"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-[#1C3281] text-white py-3 rounded-lg">
                        Update Lomba
                    </button>
                </div>
            </form>
        </div>
    </div>
    {{-- End Modal Edit --}}

    {{-- Modal Hapus --}}
    <div id="deleteModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <h3 class="text-xl font-bold text-[#CF1A25] mb-3">
                Hapus Lomba
            </h3>
            <p class="text-gray-600 mb-5">
                Apakah Anda yakin ingin menghapus:
                <span id="deleteTitle" class="font-semibold text-gray-800"></span>?
            </p>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 rounded-lg border">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-[#CF1A25] text-white rounded-lg hover:bg-red-700">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
    {{-- End Modal Hapus --}}
    <script>
        // Edit
        function openEditModal(id, title, description, releaseDate, status) {
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_description').value = description;
            document.getElementById('edit_release_date').value = releaseDate;
            document.getElementById('edit_status').value = status;

            document.getElementById('editForm').action =
                `/lomba/${id}`;

            document.getElementById('editModal')
                .classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal')
                .classList.add('hidden');
        }

        // Delete
        function openDeleteModal(id, title) {
            document.getElementById('deleteTitle').innerText = title;

            document.getElementById('deleteForm').action =
                `/lomba/${id}`;

            document.getElementById('deleteModal')
                .classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal')
                .classList.add('hidden');
        }
    </script>
@endsection
