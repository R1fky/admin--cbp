<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use App\Models\Berita;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\LombaRegistration;

use App\Models\HomeHero;
use App\Models\HomeSetting;
// use Illuminate\Support\Facades\Storage;

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

        $pendaftaranTerbaru = LombaRegistration::with('lomba')
            ->latest()
            ->take(8)
            ->get();

        $heroes = HomeHero::orderBy('sort_order')->get();

        $setting = HomeSetting::all();

        return view('dashboard.index', [

            'totalLomba' => Lomba::count(),

            'totalBerita' => Berita::count(),

            'lombaAkanDibuka' => Lomba::whereDate('release_date', '>', $today)->count(),

            'lombaBerlangsung' => Lomba::whereDate('release_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->count(),

            'lombaSelesai' => Lomba::whereDate('end_date', '<', $today)
                ->count(),

            'beritaTerbaru' => $beritaTerbaru,

            'lombaTerbaru' => $lombaTerbaru,

            'pendaftaranTerbaru' => $pendaftaranTerbaru,

            'heroes' => $heroes,
            'setting' => $setting,

            'search' => $search


        ]);
    }
}
