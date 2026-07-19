<?php

namespace App\Http\Controllers;

use App\Models\HomeHero;
use App\Models\HomeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HomeHeroController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
            'sort_order' => 'required|integer|min:1|max:3',
        ]);

        $filename = Str::slug($validated['title'])
            . '-' . time()
            . '.' . $request->file('image')->extension();

        $validated['image'] = $request
            ->file('image')
            ->storeAs('home-heroes', $filename, 'public');

        $hero = HomeHero::where('sort_order', $validated['sort_order'])->first();

        if ($hero) {
            if ($hero->image && Storage::disk('public')->exists($hero->image)) {
                Storage::disk('public')->delete($hero->image);
            }

            $hero->update($validated);
        } else {
            HomeHero::create($validated);
        }

        return back()->with(
            'success',
            'Hero berhasil disimpan.'
        )->with('openHomeModal', true);
    }

    public function update(Request $request, HomeHero $hero)
    {
        $validated = $request->validate([
            'title' => 'nullable|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        if ($request->hasFile('image')) {

            if (
                $hero->image &&
                Storage::disk('public')->exists($hero->image)
            ) {
                Storage::disk('public')->delete($hero->image);
            }

            $filename = Str::slug($validated['title'])
                . '-' . time()
                . '.' . $request->file('image')->extension();

            $validated['image'] = $request
                ->file('image')
                ->storeAs(
                    'home-heroes',
                    $filename,
                    'public'
                );
        }

        $hero->update($validated);

        return back()->with(
            'success',
            'Hero berhasil diperbarui.'
        )->with('openHomeModal', true);
    }

    public function destroy(HomeHero $hero)
    {
        if (
            $hero->image &&
            Storage::disk('public')->exists($hero->image)
        ) {
            Storage::disk('public')->delete($hero->image);
        }

        $hero->delete();

        return back()->with(
            'success',
            'Hero berhasil dihapus.'
        )->with('openHomeModal', true);
    }

    // public function updateYoutube(Request $request)
    // {
    //     $validated = $request->validate([
    //         'youtube_url' => 'nullable|url'
    //     ]);

    //     HomeSetting::updateOrCreate(
    //         ['id' => 1],
    //         $validated
    //     );

    //     return back()->with(
    //         'success',
    //         'Link Youtube berhasil diperbarui.'
    //     );
    // }

    public function storeRunningText(Request $request)
    {
        $validated = $request->validate([
            'running_text' => 'nullable|string|max:500',
        ]);

        HomeSetting::create($validated);

        return back()
            ->with('success', 'Running Text berhasil ditambahkan.')
            ->with('openHomeModal', true);
    }

    public function destroyRunningText(HomeSetting $runningText)
    {
        $runningText->delete();

        return back()
            ->with('success', 'Running Text berhasil dihapus.')
            ->with('openHomeModal', true);
    }
}
