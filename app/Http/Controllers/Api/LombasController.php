<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;



class LombasController extends Controller
{
    /**
     * Display a listing of the resource.   
     */
    public function index()
    {
        return response()->json(
            Lomba::latest()->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|string|max:255|unique:lombas,title',
                'description' => 'required',
                'status' => 'required|in:sedang_berlangsung,selesai'
            ],
            [
                'title.unique' => 'Lomba dengan judul tersebut sudah ada.'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $lomba = Lomba::create([
            'title' => $request->title,
            'description' => $request->description,
            'thumbnail' => $request->thumbnail,
            'release_date' => $request->release_date,
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Lomba berhasil ditambahkan',
            'data' => $lomba
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lomba = Lomba::find($id);
        if (!$lomba) {
            return response()->json([
                'message' => 'Lomba tidak di temukan',
            ], 404);
        }

        return response()->json([
            'message' => 'Detail Lomba',
            'data' => $lomba
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lomba = Lomba::find($id);

        if (!$lomba) {
            return response()->json([
                'message' => 'Lomba tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'title' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('lombas', 'title')->ignore($id)
                ],
                'description' => 'required',
                'status' => 'required|in:sedang_berlangsung,selesai'
            ],
            [
                'title.unique' => 'Lomba dengan judul tersebut sudah ada.'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $lomba->update([
            'title' => $request->title,
            'description' => $request->description,
            'thumbnail' => $request->thumbnail,
            'release_date' => $request->release_date,
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Lomba berhasil diperbarui',
            'data' => $lomba
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lomba = Lomba::find($id);

        if (!$lomba) {
            return response()->json([
                'message' => 'Lomba tidak ditemukan'
            ], 404);
        }

        $lomba->delete();

        return response()->json([
            'message' => 'Lomba berhasil dihapus'
        ]);
    }
}
