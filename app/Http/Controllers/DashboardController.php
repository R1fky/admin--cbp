<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use App\Models\Berita;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $today = Carbon::today();

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

            // Akan Dibuka
            'lombaAkanDibuka' => Lomba::whereDate('release_date', '>', $today)
                ->count(),

            // Sedang Berlangsung
            'lombaBerlangsung' => Lomba::whereDate('release_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->count(),

            // Selesai
            'lombaSelesai' => Lomba::whereDate('end_date', '<', $today)
                ->count(),

            'beritaTerbaru' => $beritaTerbaru,

            'lombaTerbaru' => $lombaTerbaru,

            'search' => $search
        ]);
    }
}
