<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use App\Models\Slider;



class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::firstOrCreate([]);
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::firstOrCreate([]);

        $data = $request->except(['_token', 'logo', 'mobile_logo', 'favicon']);
        $data['maintenance_mode'] = $request->has('maintenance_mode') ? 1 : 0;

        if ($request->hasFile('logo')) {
            if ($setting->logo) Storage::disk('public')->delete($setting->logo);

            $file = $request->file('logo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move('site/images/settings', $fileName);
            $data['logo'] = 'site/images/settings/' . $fileName;

//            $data['logo'] = $request->file('logo')->store('settings', 'public');
        }

        if ($request->hasFile('mobile_logo')) {
            if ($setting->mobile_logo) Storage::disk('public')->delete($setting->mobile_logo);

            $file = $request->file('mobile_logo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move('site/images/settings', $fileName);
            $data['mobile_logo'] = 'site/images/settings/' . $fileName;

//            $data['mobile_logo'] = $request->file('mobile_logo')->store('settings', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($setting->favicon) Storage::disk('public')->delete($setting->favicon);
            // $data['favicon'] = $request->file('favicon')->store('settings', 'public');

            $file = $request->file('favicon');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move('site/images/settings', $fileName);
            $data['favicon'] = 'site/images/settings/' . $fileName;
        }

        $setting->update($data);

        return redirect()->back()->with('success', 'Ayarlar başarıyla güncellendi.');
    }


    public function sliderIndex()
    {
        $sliders = \App\Models\Slider::orderBy('order')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function sliderCreate()
    {
        return view('admin.sliders.create');
    }

    public function sliderStore(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'button_link' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $data = $request->except(['image', 'status']);
        $data['status'] = $request->has('status') ? 1 : 0;
        // $data['image'] = $request->file('image')->store('sliders', 'public');

        $file = $request->file('image');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move('site/images/sliders', $fileName);
        $data['image'] = 'site/images/sliders/' . $fileName;

        \App\Models\Slider::create($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider başarıyla eklendi.');
    }

    public function sliderEdit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function sliderUpdate(Request $request, Slider $slider)
{
    $request->validate([
        'title' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'button_link' => 'nullable|string|max:255',
        'order' => 'nullable|integer',
        'status' => 'nullable|boolean',
    ]);

    $data = $request->except(['image', 'status']);
    $data['status'] = $request->has('status') ? 1 : 0;

    if ($request->hasFile('image')) {
        // Eski görsel varsa sil
        if ($slider->image && \Storage::disk('public')->exists($slider->image)) {
            \Storage::disk('public')->delete($slider->image);
        }

        // Yeni görseli yükle
        // $data['image'] = $request->file('image')->store('sliders', 'public');

        $file = $request->file('image');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move('site/images/sliders', $fileName);
        $data['image'] = 'site/images/sliders/' . $fileName;
    }

    $slider->update($data);

    return redirect()->route('admin.sliders.index')->with('success', 'Slider başarıyla güncellendi.');
}
public function sliderDestroy(Slider $slider)
{
    // Eski görsel varsa sil
    if ($slider->image && \Storage::disk('public')->exists($slider->image)) {
        \Storage::disk('public')->delete($slider->image);
    }

    $slider->delete();

    return redirect()->route('admin.sliders.index')->with('success', 'Slider başarıyla silindi.');
}


}
