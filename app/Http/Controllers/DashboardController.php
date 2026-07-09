<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use App\Models\Berita;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\LombaRegistration;
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

            'search' => $search


        ]);
    }

    public function storeHome(Request $request)
    {
        $validated = $request->validate([
            'hero_title' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string',
            'youtube_url' => 'nullable|url',
            'hero_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
        ], [
            'hero_image.required' => 'Gambar hero wajib diupload.',
            'hero_image.image' => 'File harus berupa gambar.',
            'hero_image.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'hero_image.max' => 'Ukuran gambar maksimal 5 MB.',
            'youtube_url.url' => 'Link Youtube tidak valid.',
        ]);

        $validated['hero_image'] = $request
            ->file('hero_image')
            ->store('home', 'public');

        HomeSetting::create($validated);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Data berhasil ditambahkan.');
    }
}
