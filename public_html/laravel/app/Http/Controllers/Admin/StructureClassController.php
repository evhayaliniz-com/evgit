<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StructureClass;
use Illuminate\Http\Request;

class StructureClassController extends Controller
{
    /**
     * Yapı sınıfı listeleme
     */
    public function index()
    {
        $classes = StructureClass::orderBy('id', 'desc')->get();
        return view('admin.structure_classes.index', compact('classes'));
    }

    /**
     * Yeni yapı sınıfı ekleme formu
     */
    public function create()
    {
        return view('admin.structure_classes.create');
    }

    /**
     * Yapı sınıfı kayıt işlemi
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        StructureClass::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.structure-classes.index')->with('success', 'Yapı sınıfı başarıyla eklendi.');
    }

    /**
     * Yapı sınıfı düzenleme formu
     */
    public function edit($id)
    {
        $class = StructureClass::findOrFail($id);
        return view('admin.structure_classes.edit', compact('class'));
    }

    /**
     * Güncelleme işlemi
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $class = StructureClass::findOrFail($id);
        $class->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.structure-classes.index')->with('success', 'Yapı sınıfı güncellendi.');
    }

    /**
     * Silme işlemi
     */
    public function destroy($id)
    {
        $class = StructureClass::findOrFail($id);
        $class->delete();

        return redirect()->route('admin.structure-classes.index')->with('success', 'Yapı sınıfı silindi.');
    }
}
