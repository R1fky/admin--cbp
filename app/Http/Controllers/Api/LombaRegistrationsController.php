<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lomba;
use Illuminate\Support\Facades\Validator;
use App\Models\LombaRegistration;
use Illuminate\Http\Request;

class LombaRegistrationsController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'lomba_id' => 'required|integer',
                'name'     => 'required|max:255',
                'email'    => 'required|email',
                'phone'    => 'required|max:20',
                'address'  => 'required',
                'file'     => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            ],
            [
                'lomba_id.required' => 'Lomba harus dipilih.',
                'name.required'     => 'Nama wajib diisi.',
                'email.required'    => 'Email wajib diisi.',
                'email.email'       => 'Format email tidak valid.',
                'phone.required'    => 'Nomor HP wajib diisi.',
                'address.required'  => 'Alamat wajib diisi.',
                'file.mimes'        => 'File harus PDF, DOC, atau DOCX.',
                'file.max'          => 'Ukuran file maksimal 5 MB.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        /*
    |--------------------------------------------------------------------------
    | Cek lomba
    |--------------------------------------------------------------------------
    */
        $lomba = Lomba::find($validated['lomba_id']);

        if (!$lomba) {
            return response()->json([
                'message' => 'Lomba tidak ditemukan.'
            ], 404);
        }

        /*
|--------------------------------------------------------------------------
| Cek apakah pendaftaran sudah ditutup
|--------------------------------------------------------------------------
*/
        if (now()->gt($lomba->end_date)) {
            return response()->json([
                'message' => 'Pendaftaran lomba sudah ditutup.'
            ], 400);
        }

        /*
|--------------------------------------------------------------------------
| Cek apakah lomba belum dibuka
|--------------------------------------------------------------------------
*/
        if (now()->lt($lomba->release_date)) {
            return response()->json([
                'message' => 'Pendaftaran lomba belum dibuka.'
            ], 400);
        }

        /*
    |--------------------------------------------------------------------------
    | Cek apakah email sudah pernah mendaftar
    |--------------------------------------------------------------------------
    */
        $alreadyRegistered = LombaRegistration::where('lomba_id', $validated['lomba_id'])
            ->where('email', $validated['email'])
            ->exists();

        if ($alreadyRegistered) {
            return response()->json([
                'message' => 'Email ini sudah terdaftar pada lomba tersebut.'
            ], 409);
        }

        /*
    |--------------------------------------------------------------------------
    | Upload File
    |--------------------------------------------------------------------------
    */

        if ($request->hasFile('file')) {
            $validated['file'] = $request
                ->file('file')
                ->store('lomba-files', 'public');
        }

        /*
    |--------------------------------------------------------------------------
    | Simpan
    |--------------------------------------------------------------------------
    */

        $registration = LombaRegistration::create($validated);

        return response()->json([
            'message' => 'Pendaftaran berhasil.',
            'data' => $registration
        ], 201);
    }
}
