<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EdukasiResource;
use App\Models\Edukasi;

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
}
