<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\CacheHelper;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')->with('childrenRecursive')->orderBy('order')->get();
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->get(); // Sadece üst kategoriler
        return view('admin.category.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'order' => 'required|integer',
            'status' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Resmi yükle ve yolunu al
        //        $imagePath = $request->hasFile('image') ? $request->file('image')->store('categories', 'public') : null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move('site/images/categories', $fileName);
            $imagePath = 'site/images/categories/' . $fileName;
        } else {
            $imagePath = null;
        }

        // Kategoriyi oluştur
        Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'order' => $request->order,
            'status' => $request->status,
            'image' => $imagePath,
        ]);

        // Cache'i temizle
        CacheHelper::clearCategoryCache();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori başarıyla eklendi.');
    }

    public function edit(Category $category)
    {
        $categories = Category::whereNull('parent_id')->where('id', '!=', $category->id)->get();
        return view('admin.category.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'order' => 'required|integer',
            'status' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'order' => $request->order,
            'status' => $request->has('status') ? 1 : 0,
        ];

        if ($request->hasFile('image')) {
            // Eski görsel varsa sil
            if ($category->image && \Storage::disk('public')->exists($category->image)) {
                \Storage::disk('public')->delete($category->image);
            }


            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move('site/images/categories', $fileName);
            $data['image'] = 'site/images/categories/' . $fileName;

            // Yeni görseli yükle
            //            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        // Cache'i temizle
        CacheHelper::clearCategoryCache();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori başarıyla güncellendi.');
    }


    public function destroy(Category $category)
    {
        $category->delete();

        // Cache'i temizle
        CacheHelper::clearCategoryCache();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori başarıyla silindi.');
    }
}
