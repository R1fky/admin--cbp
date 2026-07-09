<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::with('kategori');

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

        $beritas = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $kategoris = KategoriBerita::all();

        return view(
            'berita.index',
            compact('beritas', 'kategoris')
        );
    }

    # menambahkan data berita
    public function create()
    {
        $kategoris = KategoriBerita::all();

        return view(
            'berita.create',
            compact('kategoris')
        );
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:beritas,title',
            'excerpt' => 'required|string|max:500',
            'content' => 'required',
            'kategori_id' => 'required|exists:kategori_beritas,id',
            'author' => 'required|string|max:100',
            'source' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'published_at' => 'required|date'
        ], [
            'title.required' => 'Judul berita wajib diisi.',
            'title.unique' => 'Judul berita sudah digunakan.',
            'excerpt.required' => 'Ringkasan berita wajib diisi.',
            'content.required' => 'Isi berita wajib diisi.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'author.required' => 'Penulis wajib diisi.',
            'published_at.required' => 'Tanggal publish wajib diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPG, JPEG atau PNG.',
            'image.max' => 'Ukuran gambar maksimal 2 MB.'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {

            $imagePath = $request
                ->file('image')
                ->store('berita', 'public');
        }

        Berita::create([
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'kategori_id' => $request->kategori_id,
            'author' => $request->author,
            'source' => $request->source,
            'image' => $imagePath,
            'published_at' => $request->published_at
        ]);

        return redirect()
            ->route('berita.index')
            ->with('success', 'Berita berhasil ditambahkan');
    }

    // update Berita
    public function edit(Berita $berita)
    {
        $kategoris = KategoriBerita::all();

        return view(
            'berita.edit',
            compact(
                'berita',
                'kategoris'
            )
        );
    }

    public function update(Request $request, Berita $berita)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255|unique:beritas,title,' . $berita->id,
                'excerpt' => 'required|string|max:500',
                'content' => 'required',
                'kategori_id' => 'required|exists:kategori_beritas,id',
                'author' => 'required|string|max:100',
                'source' => 'nullable|string|max:255',
                'published_at' => 'required|date',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:10240'
            ],
            [
                'title.required' => 'Judul berita wajib diisi.',
                'title.unique' => 'Judul berita sudah digunakan.',
                'excerpt.required' => 'Ringkasan berita wajib diisi.',
                'content.required' => 'Isi berita wajib diisi.',
                'kategori_id.required' => 'Kategori wajib dipilih.',
                'author.required' => 'Penulis wajib diisi.',
                'published_at.required' => 'Tanggal publish wajib diisi.',
                'image.image' => 'File harus berupa gambar.',
                'image.mimes' => 'Format gambar harus JPG, JPEG atau PNG.',
                'image.max' => 'Ukuran gambar maksimal 2 MB.'
            ]
        );

        $imagePath = $berita->image;

        if ($request->hasFile('image')) {

            // hapus image lama
            if (
                $berita->image &&
                Storage::disk('public')->exists($berita->image)
            ) {
                Storage::disk('public')->delete($berita->image);
            }

            // upload image baru
            $imagePath = $request
                ->file('image')
                ->store('berita', 'public');
        }

        $berita->update([
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'kategori_id' => $request->kategori_id,
            'author' => $request->author,
            'source' => $request->source,
            'image' => $imagePath,
            'published_at' => $request->published_at,
        ]);

        return redirect()
            ->route('berita.index')
            ->with('success', 'Data berita berhasil diperbarui.');
    }

    // menghapus berita
    public function destroy(Berita $berita)
    {
        // hapus file image jika ada
        if ($berita->image && Storage::disk('public')->exists($berita->image)) {

            Storage::disk('public')->delete($berita->image);
        }

        // hapus data berita
        $berita->delete();

        return redirect()
            ->route('berita.index')
            ->with('success', 'Data berita berhasil dihapus.');
    }
}
