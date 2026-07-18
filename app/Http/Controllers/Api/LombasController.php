<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LombaResource;
use App\Models\Lomba;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Validation\Rule;



class LombasController extends Controller
{
    /**
     * Display a listing of the resource.   
     */
    public function index()
    {
        $lombas = Lomba::withCount('registrations')
            ->latest()
            ->get();

        return LombaResource::collection($lombas);
    }

    public function show(Lomba $lomba)
    {
        $lomba->loadCount('registrations');

        return new LombaResource($lomba);
    }
}
