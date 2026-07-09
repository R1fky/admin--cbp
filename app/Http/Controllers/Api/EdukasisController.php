<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EdukasiResource;
use App\Models\Edukasi;
use Illuminate\Support\Facades\Storage;

class EdukasisController extends Controller
{
    public function index()
    {
        return EdukasiResource::collection(
            Edukasi::latest()->get()
        );
    }

    public function show(Edukasi $edukasi)
    {
        return new EdukasiResource($edukasi);
    }

    public function pdf(Edukasi $edukasi)
    {
        if (!$edukasi->file || !Storage::disk('public')->exists($edukasi->file)) {
            abort(404);
        }

        return response()->file(Storage::disk('public')->path($edukasi->file));
    }
}
