<?php

namespace App\Http\Controllers;

use App\Models\Edukasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EdukasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Edukasi::query();

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $edukasis = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('edukasi.index', compact('edukasis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('edukasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255|unique:edukasis,judul',
            'deskripsi' => 'required|string',
            'file' => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'link' => 'nullable|url|max:255',
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('edukasi', 'public');
        }

        Edukasi::create($validated);

        return redirect()
            ->route('edukasi.index')
            ->with('success', 'Data edukasi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Edukasi $edukasi)
    {
        return view('edukasi.edit', compact('edukasi'));
    }

    public function update(Request $request, Edukasi $edukasi)
    {
        $validated = $request->validate([
            'judul' => [
                'required',
                'string',
                'max:255',
                Rule::unique('edukasis', 'judul')->ignore($edukasi->id),
            ],
            'deskripsi' => 'required|string',
            'file' => 'nullable|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'link' => 'nullable|url|max:2048',
        ], [
            'judul.unique' => 'Judul edukasi sudah digunakan.',
            'file.mimes' => 'File harus berupa JPG, JPEG, PNG, WEBP, atau PDF.',
            'file.max' => 'Ukuran file maksimal 5MB.',
            'link.url' => 'Link harus berupa URL yang valid.',
        ]);

        $oldFile = $edukasi->file;

        DB::beginTransaction();

        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                $filename = Str::slug($validated['judul'])
                    . '-'
                    . time()
                    . '.'
                    . $file->getClientOriginalExtension();

                $validated['file'] = $file->storeAs(
                    'edukasi',
                    $filename,
                    'public'
                );
            }

            $edukasi->update($validated);

            DB::commit();

            if ($request->hasFile('file') && $oldFile && Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }

            return redirect()
                ->route('edukasi.index')
                ->with('success', 'Data edukasi berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();

            if (!empty($validated['file']) && Storage::disk('public')->exists($validated['file'])) {
                Storage::disk('public')->delete($validated['file']);
            }

            return back()
                ->withInput()
                ->with('error', 'Data edukasi gagal diperbarui.');
        }
    }

    public function destroy(Edukasi $edukasi)
    {
        if ($edukasi->file && Storage::disk('public')->exists($edukasi->file)) {
            Storage::disk('public')->delete($edukasi->file);
        }

        $edukasi->delete();

        return redirect()
            ->route('edukasi.index')
            ->with('success', 'Data edukasi berhasil dihapus.');
    }
}
