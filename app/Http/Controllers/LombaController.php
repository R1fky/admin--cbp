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
                'status' => 'required|in:sedang_berlangsung,selesai',
                'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
            ],
            [
                'title.required' => 'Judul Lomba Wajib diisi.',
                'title.unique' => 'Judul Lomba Sudah digunakan.',
                'description.required' => 'Isi Deskripsi wajib diisi.',
                'kategori_id.required' => 'Kategori wajib dipilih.',
                'release_date.required' => 'Tanggal Release wajib diisi.',
                'status.required' => 'Status harus dipilih',
                'thumbnail.image' => 'File harus berupa gambar.',
                'thumbnail.mimes' => 'Format gambar harus JPG, JPEG atau PNG.',
                'thumbnail.max' => 'Ukuran gambar maksimal 2 MB.'
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
            'status' => $request->status
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
                'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'status' => 'required|in:sedang_berlangsung,selesai',
            ],
            [
                'title.required' => 'Judul Lomba Wajib diisi.',
                'title.unique' => 'Judul Lomba Sudah digunakan.',
                'description.required' => 'Isi Deskripsi wajib diisi.',
                'kategori_id.required' => 'Kategori wajib dipilih.',
                'release_date.required' => 'Tanggal Release wajib diisi.',
                'status.required' => 'Status harus dipilih',
                'thumbnail.image' => 'File harus berupa gambar.',
                'thumbnail.mimes' => 'Format gambar harus JPG, JPEG atau PNG.',
                'thumbnail.max' => 'Ukuran gambar maksimal 2 MB.'
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
            'status' => $request->status
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
