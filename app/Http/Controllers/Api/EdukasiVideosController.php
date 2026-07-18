<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EdukasiVideoResource;
use App\Models\EdukasiVideo;

class EdukasiVideosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = EdukasiVideo::latest()->get();

        return EdukasiVideoResource::collection($videos);
    }

    /**
     * Display the specified resource.
     */
    public function show(EdukasiVideo $edukasiVideo)
    {
        return new EdukasiVideoResource($edukasiVideo);
    }
}
