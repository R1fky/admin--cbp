<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomeHeroResource;
use App\Models\HomeHero;

class HomeHeroController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => HomeHeroResource::collection(
                HomeHero::orderBy('sort_order')->get()
            ),
        ]);
    }
}
