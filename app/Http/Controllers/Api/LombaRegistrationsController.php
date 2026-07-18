<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lomba;
use Illuminate\Support\Facades\Validator;
use App\Models\LombaRegistration;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

use Illuminate\Validation\Rule;

class LombaRegistrationsController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'lomba_id' => 'required|integer',
                'name'     => 'required|max:255',
                'domicile' => 'required|max:255',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('lomba_registrations')
                        ->where(fn($query) => $query->where('lomba_id', $request->lomba_id)),
                ],
                'phone'    => 'required|max:20',
                'address'  => 'required',

                'file'     => 'nullable|file|mimes:pdf,doc,docx|max:10240',

                'link'     => 'nullable|url',
            ],
            [
                'lomba_id.required' => 'Lomba harus dipilih.',

                'name.required'     => 'Nama wajib diisi.',

                'domicile.required' => 'Domisili wajib diisi.',

                'email.required'    => 'Email wajib diisi.',
                'email.email'       => 'Format email tidak valid.',

                'phone.required'    => 'Nomor HP wajib diisi.',

                'address.required'  => 'Alamat wajib diisi.',

                'file.mimes'        => 'File harus PDF, DOC, atau DOCX.',
                'file.max'          => 'Ukuran file maksimal 10 MB.',

                'link.url'          => 'Link tidak valid.',
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
        $lomba = Lomba::withCount('registrations')
            ->find($validated['lomba_id']);

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
        // $alreadyRegistered = LombaRegistration::where('lomba_id', $validated['lomba_id'])
        //     ->where('email', $validated['email'])
        //     ->exists();

        // if ($alreadyRegistered) {
        //     return response()->json([
        //         'message' => 'Email ini sudah terdaftar pada lomba tersebut.'
        //     ], 409);
        // }

        try {

            $registration = DB::transaction(function () use ($validated, $request) {

                $lomba = Lomba::where('id', $validated['lomba_id'])
                    ->lockForUpdate()
                    ->first();

                $currentParticipants = $lomba->registrations()->count();

                if ($currentParticipants >= $lomba->max_participants) {
                    throw ValidationException::withMessages([
                        'quota' => ['Kuota peserta sudah penuh.']
                    ]);
                }

                if ($request->hasFile('file')) {
                    $validated['file'] = $request
                        ->file('file')
                        ->store('lomba-files', 'public');
                }

                return LombaRegistration::create($validated);
            });
        } catch (ValidationException $e) {

            return response()->json([
                'message' => 'Kuota peserta sudah penuh.',
                'errors' => $e->errors(),
            ], 409);
        }

        return response()->json([
            'message' => 'Pendaftaran berhasil.',
            'data' => [
                ...$registration->toArray(),
                'file_url' => $registration->file
                    ? asset('storage/' . $registration->file)
                    : null,
            ]
        ], 201);
    }
}
