<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HomeSetting;

class RunningTextController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => HomeSetting::latest()
                ->select('id', 'running_text', 'created_at')
                ->get(),
        ]);
    }
}
