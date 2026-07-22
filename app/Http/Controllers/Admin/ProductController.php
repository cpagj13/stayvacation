<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $rooms = Room::with('category')->latest()->get();
        return view('admin.products.index', compact('rooms'));
    }

    public function create()
    {
        $categories = RoomCategory::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_category_id' => 'nullable|exists:room_categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string',
        ]);

        Room::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Room created.');
    }

    public function edit(Room $product)
    {
        $categories = RoomCategory::all();
        return view('admin.products.edit', ['room' => $product, 'categories' => $categories]);
    }

    public function update(Request $request, Room $product)
    {
        $validated = $request->validate([
            'room_category_id' => 'nullable|exists:room_categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string',
        ]);

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Room updated.');
    }

    public function destroy(Room $product)
    {
        $product->delete();
        return back()->with('success', 'Room deleted.');
    }
}