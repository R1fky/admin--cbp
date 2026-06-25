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

    # menambahkan data
    public function store(Request $request)
    {
        $imagePath = null;

        $request->validate([
            'title' => 'required|string|max:255|unique:beritas,title',
            'content' => 'required',
            'kategori_id' => 'required|exists:kategori_beritas,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'published_at' => 'nullable|date'
        ]);

        // Upload Image jika ada
        if ($request->hasFile('image')) {

            $imagePath = $request
                ->file('image')
                ->store('berita', 'public');
        }

        $berita = Berita::create([
            'title' => $request->title,
            'kategori_id' => $request->kategori_id,
            'content' => $request->content,
            'image' => $imagePath,
            'published_at' => $request->published_at,
        ]);

        return redirect()
            ->route('berita.index')
            ->with('success', 'Data berita berhasil ditambahkan.');
    }

    // update Berita
    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:beritas,title,' . $berita->id,
            'kategori_id' => 'required|exists:kategori_beritas,id',
            'content' => 'required',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

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
            'kategori_id' => $request->kategori_id,
            'content' => $request->content,
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
