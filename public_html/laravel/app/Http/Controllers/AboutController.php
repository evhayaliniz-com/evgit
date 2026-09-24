<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /************************* ADMIN İŞLEMLERİ *************************/

    public function adminIndex()
    {
        $about = AboutUs::first();
        return view('admin.about.index', compact('about'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'box1_content' => ['nullable', 'string', 'max:5000'],
            'box2_content' => ['nullable', 'string', 'max:5000'],
        ]);

        // Hakkımızda yazısı yoksa oluşturuyoruz, varsa güncelliyoruz.
        AboutUs::updateOrCreate(
            ['id' => 1],
            $request->only(['title', 'content', 'box1_content', 'box2_content'])
        );

        return redirect()->route('admin.about.index')->withSuccess('İşlem Tamamlandı.');
    }


    /************************* KULLANICI İŞLEMLERİ *************************/

    public function index()
    {
        $about = AboutUs::first();
        return view('site.about.index', compact('about'));
    }
}
