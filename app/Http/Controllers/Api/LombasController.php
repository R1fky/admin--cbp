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
        return LombaResource::collection(
            Lomba::latest()->get()
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Lomba $lomba)
    {
        return new LombaResource($lomba);
    }
}
