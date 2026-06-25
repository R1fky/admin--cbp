<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LombaController extends Controller
{
    public function index()
    {
        $lombas = Lomba::latest()->paginate(10);

        return view('lomba.index', compact('lombas'));
    }

    # add data to database
    public function store(Request $request)
    {
        $thumbnailPath = null;

        $request->validate([
            'title' => 'required|string|max:255|unique:lombas,title',
            'description' => 'required',
            'release_date' => 'required|date',
            'status' => 'required|in:sedang_berlangsung,selesai',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Upload thumbnail jika ada
        if ($request->hasFile('thumbnail')) {

            $thumbnailPath = $request
                ->file('thumbnail')
                ->store('lomba', 'public');
        }

        $lomba = Lomba::create([
            'title' => $request->title,
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
    public function update(Request $request, Lomba $lomba)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:lombas,title,' . $lomba->id,
            'description' => 'required',
            'release_date' => 'required|date',
            'status' => 'required|in:sedang_berlangsung,selesai',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

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
