<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use App\Models\LombaRegistration;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LombaRegistrationExport;

class LombaRegistrationController extends Controller
{

    public function index(Request $request, Lomba $lomba)
    {
        $query = $lomba->registrations();

        // Search nama atau email
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $registrations = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'registration.index',
            compact('lomba', 'registrations')
        );
    }

    public function updateStatus(
        Request $request,
        LombaRegistration $registration
    ) {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $registration->update([
            'status' => $request->status
        ]);

        return back()
            ->with('success', 'Status berhasil diperbarui.');
    }

    // export excel
    public function export(Request $request, Lomba $lomba)
    {
        return Excel::download(
            new LombaRegistrationExport(
                $lomba,
                $request->search,
                $request->status
            ),
            'peserta-' . $lomba->title . '.xlsx'
        );
    }
}
