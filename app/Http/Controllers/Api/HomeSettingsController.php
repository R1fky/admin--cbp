<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomeHeroResource;
use App\Models\HomeHero;
use App\Models\HomeSetting;

class HomeSettingsController extends Controller
{
    public function index()
    {
        return response()->json([

            'heroes' => HomeHeroResource::collection(
                HomeHero::orderBy('sort_order')->get()
            ),

            'youtube_urls' => HomeSetting::latest()
                ->take(3)
                ->pluck('youtube_url'),

        ]);
    }
}
