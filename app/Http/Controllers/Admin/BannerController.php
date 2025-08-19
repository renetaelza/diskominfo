<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeroBanner;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $hero = HeroBanner::first(); // Ambil record pertama, jika ada
        return view('admin.banner', compact('hero'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'tagline' => 'nullable|string|max:255',
            'img_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:20480', // 20MB
        ]);

        $hero = HeroBanner::first() ?? new HeroBanner();

        $hero->tagline = $request->tagline;

        if ($request->hasFile('img_banner')) {
            if ($hero->img_banner && Storage::disk('public')->exists($hero->img_banner)) {
                Storage::disk('public')->delete($hero->img_banner);
            }
            $hero->img_banner = $request->file('img_banner')->store('hero_banners', 'public');
        }

        $hero->save();

        return redirect()->back()->with('success', 'Banner berhasil diperbarui.');
    }

}
