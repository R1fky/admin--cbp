<?php

namespace App\Http\Controllers;

use App\Models\EdukasiVideo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class EdukasiVideoController extends Controller
{
    public function index()
    {
        $videos = EdukasiVideo::latest()->paginate(10);

        return view('edukasi-video.index', compact('videos'));
    }

    public function create()
    {
        // Maksimal 3 video
        if (EdukasiVideo::count() >= 3) {
            return redirect()
                ->route('edukasi-video.index')
                ->with('error', 'Maksimal hanya 3 video yang dapat ditambahkan.');
        }

        return view('edukasi-video.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'videos.*.judul' => 'nullable|string|max:255',
            'videos.*.deskripsi' => 'nullable|string',
            'videos.*.link' => 'nullable|url|max:2048',
        ]);

        $validator->after(function ($validator) use ($request) {

            $links = [];

            foreach ($request->videos ?? [] as $index => $video) {

                // Skip jika kosong semua
                if (
                    empty($video['judul']) &&
                    empty($video['deskripsi']) &&
                    empty($video['link'])
                ) {
                    continue;
                }

                // Judul wajib
                if (empty($video['judul'])) {
                    $validator->errors()->add(
                        "videos.$index.judul",
                        "Judul video wajib diisi."
                    );
                }

                // Link wajib
                if (empty($video['link'])) {
                    $validator->errors()->add(
                        "videos.$index.link",
                        "Link video wajib diisi."
                    );
                }

                if (!empty($video['link'])) {

                    // Cek duplikat dalam form
                    if (in_array($video['link'], $links)) {
                        $validator->errors()->add(
                            "videos.$index.link",
                            "Link video tidak boleh sama dengan video lainnya."
                        );
                    }

                    $links[] = $video['link'];

                    // Cek database
                    if (EdukasiVideo::where('link', $video['link'])->exists()) {
                        $validator->errors()->add(
                            "videos.$index.link",
                            "Link video sudah pernah digunakan."
                        );
                    }
                }
            }
        });

        $validator->validate();

        foreach ($request->videos as $video) {

            if (
                empty($video['judul']) &&
                empty($video['deskripsi']) &&
                empty($video['link'])
            ) {
                continue;
            }

            EdukasiVideo::create([
                'judul' => $video['judul'],
                'deskripsi' => $video['deskripsi'],
                'link' => $video['link'],
            ]);
        }

        return redirect()
            ->route('edukasi-video.index')
            ->with('success', 'Video berhasil ditambahkan.');
    }

    public function edit(EdukasiVideo $edukasiVideo)
    {
        return view('edukasi-video.edit', compact('edukasiVideo'));
    }

    public function update(Request $request, EdukasiVideo $edukasiVideo)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'link' => [
                'required',
                'url',
                'max:2048',
                Rule::unique('edukasi_videos', 'link')->ignore($edukasiVideo->id),
            ],
        ], [
            'judul.required' => 'Judul wajib diisi.',
            'link.required' => 'Link video wajib diisi.',
            'link.url' => 'Link harus berupa URL yang valid.',
            'link.unique' => 'Link video sudah digunakan.',
        ]);

        $edukasiVideo->update($validated);

        return redirect()
            ->route('edukasi-video.index')
            ->with('success', 'Video berhasil diperbarui.');
    }

    public function destroy(EdukasiVideo $edukasiVideo)
    {
        $edukasiVideo->delete();

        return redirect()
            ->route('edukasi-video.index')
            ->with('success', 'Video berhasil dihapus.');
    }
}
