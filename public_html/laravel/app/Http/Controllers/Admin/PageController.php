<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('order')->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'nullable|string',
            'order'   => 'nullable|integer',
            'status'  => 'nullable|boolean',
        ]);

        Page::create([
            'title'   => $request->title,
            'slug'    => Str::slug($request->title),
            'content' => $request->content,
            'order'   => $request->order ?? 0,
            'status'  => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Sayfa başarıyla eklendi.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'nullable|string',
            'order'   => 'nullable|integer',
            'status'  => 'nullable|boolean',
        ]);

        $page->update([
            'title'   => $request->title,
            'slug'    => Str::slug($request->title),
            'content' => $request->content,
            'order'   => $request->order ?? 0,
            'status'  => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Sayfa başarıyla güncellendi.');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Sayfa silindi.');
    }


    /************************* KULLANICI İŞLEMLERİ *************************/

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('status', true)->firstOrFail();

        return view('site.pages.index', compact('page'));
    }
}
