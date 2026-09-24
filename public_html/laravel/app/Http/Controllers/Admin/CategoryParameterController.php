<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryParameter;
use Illuminate\Http\Request;

class CategoryParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $parameters = CategoryParameter::where('category_id', $categoryId)
            ->orderBy('order')
            ->get();
        
        return view('admin.category.parameters.index', compact('category', 'parameters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        return view('admin.category.parameters.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $categoryId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:input,select',
            'is_required' => 'boolean',
            'options' => 'nullable|array',
            'order' => 'integer|min:0'
        ]);

        $data = $request->all();
        $data['category_id'] = $categoryId;
        $data['is_required'] = $request->has('is_required') ? 1 : 0;
        
        if ($request->type === 'select' && $request->options) {
            $data['options'] = array_filter($request->options);
        } else {
            $data['options'] = null;
        }

        CategoryParameter::create($data);

        return redirect()->route('admin.categories.parameters.index', $categoryId)
            ->with('success', 'Parametre başarıyla eklendi.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($categoryId, $id)
    {
        $category = Category::findOrFail($categoryId);
        $parameter = CategoryParameter::where('category_id', $categoryId)->findOrFail($id);
        
        return view('admin.category.parameters.edit', compact('category', 'parameter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $categoryId, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:input,select',
            'is_required' => 'boolean',
            'options' => 'nullable|array',
            'order' => 'integer|min:0'
        ]);

        $parameter = CategoryParameter::where('category_id', $categoryId)->findOrFail($id);
        
        $data = $request->all();
        $data['is_required'] = $request->has('is_required') ? 1 : 0;
        
        if ($request->type === 'select' && $request->options) {
            $data['options'] = array_filter($request->options);
        } else {
            $data['options'] = null;
        }

        $parameter->update($data);

        return redirect()->route('admin.categories.parameters.index', $categoryId)
            ->with('success', 'Parametre başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($categoryId, $id)
    {
        $parameter = CategoryParameter::where('category_id', $categoryId)->findOrFail($id);
        $parameter->delete();

        return redirect()->route('admin.categories.parameters.index', $categoryId)
            ->with('success', 'Parametre başarıyla silindi.');
    }
}
