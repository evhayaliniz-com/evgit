<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StructureType;
use Illuminate\Http\Request;

class StructureTypeController extends Controller
{
    /**
     * Yapı türlerinin listelendiği sayfa
     */
    public function index()
    {
        $types = StructureType::orderBy('id', 'desc')->get();
        return view('admin.structure_types.index', compact('types'));
    }

    /**
     * Yeni yapı türü ekleme formu
     */
    public function create()
    {
        return view('admin.structure_types.create');
    }

    /**
     * Yapı türünü veritabanına kaydetme
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        StructureType::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.structure-types.index')->with('success', 'Yapı türü başarıyla eklendi.');
    }

    /**
     * Yapı türü düzenleme formu
     */
    public function edit($id)
    {
        $type = StructureType::findOrFail($id);
        return view('admin.structure_types.edit', compact('type'));
    }

    /**
     * Yapı türünü güncelleme
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $type = StructureType::findOrFail($id);
        $type->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.structure-types.index')->with('success', 'Yapı türü başarıyla güncellendi.');
    }

    /**
     * Yapı türünü silme
     */
    public function destroy($id)
    {
        $type = StructureType::findOrFail($id);
        $type->delete();

        return redirect()->route('admin.structure-types.index')->with('success', 'Yapı türü silindi.');
    }
}
