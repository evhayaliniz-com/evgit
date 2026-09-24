<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomCount;
use Illuminate\Http\Request;

class RoomCountController extends Controller
{
    /**
     * Oda sayılarının listelendiği sayfa
     */
    public function index()
    {
        $rooms = RoomCount::orderBy('id', 'desc')->get();
        return view('admin.room_counts.index', compact('rooms'));
    }

    /**
     * Oda sayısı ekleme formu
     */
    public function create()
    {
        return view('admin.room_counts.create');
    }

    /**
     * Yeni oda sayısını kaydetme
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
        ]);

        RoomCount::create([
            'label' => $request->label,
        ]);

        return redirect()->route('admin.room-counts.index')->with('success', 'Oda sayısı başarıyla eklendi.');
    }

    /**
     * Oda sayısı düzenleme formu
     */
    public function edit($id)
    {
        $room = RoomCount::findOrFail($id);
        return view('admin.room_counts.edit', compact('room'));
    }

    /**
     * Oda sayısını güncelleme
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'label' => 'required|string|max:255',
        ]);

        $room = RoomCount::findOrFail($id);
        $room->update([
            'label' => $request->label,
        ]);

        return redirect()->route('admin.room-counts.index')->with('success', 'Oda sayısı güncellendi.');
    }

    /**
     * Oda sayısını silme
     */
    public function destroy($id)
    {
        $room = RoomCount::findOrFail($id);
        $room->delete();

        return redirect()->route('admin.room-counts.index')->with('success', 'Oda sayısı silindi.');
    }
}
