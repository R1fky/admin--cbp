<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use App\Models\KategoriLomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LombaController extends Controller
{
    public function index(Request $request)
    {
        $query = Lomba::with('kategori');

        if ($request->filled('search')) {
            $query->where(
                'title',
                'like',
                '%' . $request->search . '%'
            );
        }

        if ($request->filled('kategori_id')) {
            $query->where(
                'kategori_id',
                $request->kategori_id
            );
        }

        $lombas = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $kategoris = KategoriLomba::all();

        return view(
            'lomba.index',
            compact('lombas', 'kategoris')
        );
    }

    # add data to database
    public function create()
    {
        $kategoris = KategoriLomba::all();

        return view(
            'lomba.create',
            compact('kategoris')
        );
    }
    public function store(Request $request)
    {
        $thumbnailPath = null;

        $request->validate(
            [
                'title' => 'required|unique:lombas,title',
                'kategori_id' => 'required|exists:kategori_lombas,id',
                'description' => 'required',
                'release_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:release_date',
                'location_type' => 'required|in:online,offline',
                'location' => 'required|string|max:255',
                'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:10240'
            ],
            [
                'title.required' => 'Judul lomba wajib diisi.',
                'title.unique' => 'Judul lomba sudah digunakan.',

                'kategori_id.required' => 'Kategori wajib dipilih.',
                'kategori_id.exists' => 'Kategori tidak ditemukan.',

                'description.required' => 'Deskripsi wajib diisi.',

                'release_date.required' => 'Tanggal mulai wajib diisi.',
                'release_date.date' => 'Format tanggal mulai tidak valid.',

                'end_date.required' => 'Tanggal berakhir wajib diisi.',
                'end_date.date' => 'Format tanggal berakhir tidak valid.',
                'end_date.after_or_equal' => 'Tanggal berakhir tidak boleh lebih awal dari tanggal mulai.',

                'location_type.required' => 'Tipe lokasi wajib dipilih.',
                'location_type.in' => 'Tipe lokasi tidak valid.',

                'location.required' => 'Lokasi wajib diisi.',

                'thumbnail.image' => 'File harus berupa gambar.',
                'thumbnail.mimes' => 'Format gambar harus JPG, JPEG atau PNG.',
                'thumbnail.max' => 'Ukuran gambar maksimal 2 MB.',
            ]
        );

        // Upload thumbnail jika ada
        if ($request->hasFile('thumbnail')) {

            $thumbnailPath = $request
                ->file('thumbnail')
                ->store('lomba', 'public');
        }

        $lomba = Lomba::create([
            'title' => $request->title,
            'kategori_id' => $request->kategori_id,
            'description' => $request->description,
            'thumbnail' => $thumbnailPath,
            'release_date' => $request->release_date,
            'end_date' => $request->end_date,
            'location_type' => $request->location_type,
            'location' => $request->location
        ]);

        return redirect()
            ->route('lomba.index')
            ->with('success', 'Data lomba berhasil ditambahkan.');
    }

    // update lomba
    public function edit(Lomba $lomba)
    {
        $kategoris = KategoriLomba::all();

        return view(
            'lomba.edit',
            compact(
                'lomba',
                'kategoris'
            )
        );
    }

    public function update(Request $request, Lomba $lomba)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255|unique:lombas,title,' . $lomba->id,
                'description' => 'required',
                'kategori_id' => 'required|exists:kategori_lombas,id',
                'release_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:release_date',
                'location_type' => 'required|in:online,offline',
                'location' => 'required|string|max:255',
                'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            ],
            [
                'title.required' => 'Judul lomba wajib diisi.',
                'title.unique' => 'Judul lomba sudah digunakan.',

                'kategori_id.required' => 'Kategori wajib dipilih.',
                'kategori_id.exists' => 'Kategori tidak ditemukan.',

                'description.required' => 'Deskripsi wajib diisi.',

                'release_date.required' => 'Tanggal mulai wajib diisi.',
                'release_date.date' => 'Format tanggal mulai tidak valid.',

                'end_date.required' => 'Tanggal berakhir wajib diisi.',
                'end_date.date' => 'Format tanggal berakhir tidak valid.',
                'end_date.after_or_equal' => 'Tanggal berakhir tidak boleh lebih awal dari tanggal mulai.',

                'location_type.required' => 'Tipe lokasi wajib dipilih.',
                'location_type.in' => 'Tipe lokasi tidak valid.',

                'location.required' => 'Lokasi wajib diisi.',

                'thumbnail.image' => 'File harus berupa gambar.',
                'thumbnail.mimes' => 'Format gambar harus JPG, JPEG atau PNG.',
                'thumbnail.max' => 'Ukuran gambar maksimal 2 MB.',
            ]
        );

        $thumbnailPath = $lomba->thumbnail;

        if ($request->hasFile('thumbnail')) {

            // hapus thumbnail lama
            if (
                $lomba->thumbnail &&
                Storage::disk('public')->exists($lomba->thumbnail)
            ) {
                Storage::disk('public')->delete($lomba->thumbnail);
            }

            // upload thumbnail baru
            $thumbnailPath = $request
                ->file('thumbnail')
                ->store('lomba', 'public');
        }

        $lomba->update([
            'title' => $request->title,
            'kategori_id' => $request->kategori_id,
            'description' => $request->description,
            'thumbnail' => $thumbnailPath,
            'release_date' => $request->release_date,
            'end_date' => $request->end_date,
            'location_type' => $request->location_type,
            'location' => $request->location,
        ]);

        return redirect()
            ->route('lomba.index')
            ->with('success', 'Data lomba berhasil diperbarui.');
    }

    #menghapus Lomba    
    public function destroy(Lomba $lomba)
    {
        // hapus file thumbnail jika ada
        if ($lomba->thumbnail && Storage::disk('public')->exists($lomba->thumbnail)) {

            Storage::disk('public')->delete($lomba->thumbnail);
        }

        // hapus data lomba
        $lomba->delete();

        return redirect()
            ->route('lomba.index')
            ->with('success', 'Data lomba berhasil dihapus.');
    }
}
