<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use App\Models\Berita;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $beritaTerbaru = Berita::query()
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->latest()
            ->take(5)
            ->get();

        $lombaTerbaru = Lomba::query()
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', [
            'totalLomba' => Lomba::count(),
            'totalBerita' => Berita::count(),

            'lombaBerlangsung' => Lomba::where(
                'status',
                'sedang_berlangsung'
            )->count(),

            'lombaSelesai' => Lomba::where(
                'status',
                'selesai'
            )->count(),

            'beritaTerbaru' => $beritaTerbaru,
            'lombaTerbaru' => $lombaTerbaru,
            'search' => $search
        ]);
    }
}
