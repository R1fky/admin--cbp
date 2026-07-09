<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomeSettingResource;
use App\Models\HomeSetting;

class HomeSettingsController extends Controller
{
    public function index()
    {
        return HomeSettingResource::collection(
            HomeSetting::latest()
                ->take(3)
                ->get()
        );
    }
}
