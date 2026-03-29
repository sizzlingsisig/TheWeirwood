<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class HouseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $houses = House::paginate(9);

        return view('houses.index', compact('houses'));
    }

    public function create()
    {
        Gate::authorize('create-houses');

        return view('houses.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create-houses');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'motto' => 'nullable|string|max:80',
            'description' => 'nullable|string',
            'sigil_image' => 'nullable|image|mimes:jpeg,png,gif,svg,webp|max:2048',
            'starting_honor' => 'required|integer|min:0|max:100',
            'starting_power' => 'required|integer|min:0|max:100',
            'starting_debt' => 'required|integer|min:0|max:100',
        ]);

        if ($request->hasFile('sigil_image')) {
            $validated['sigil_image_path'] = $request->file('sigil_image')->store('houses', 'public');
        }

        $house = House::create($validated);
        if ($request->wantsJson()) {
            return response()->json($house, 201);
        }

        return redirect()->route('houses.show', $house);
    }

    public function show(Request $request, House $house)
    {
        if ($request->wantsJson()) {
            return response()->json($house);
        }

        return view('houses.show', compact('house'));
    }

    public function edit(House $house)
    {
        Gate::authorize('edit-houses');

        return view('houses.edit', compact('house'));
    }

    public function update(Request $request, House $house)
    {
        Gate::authorize('edit-houses');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'motto' => 'nullable|string|max:80',
            'description' => 'nullable|string',
            'sigil_image' => 'nullable|image|mimes:jpeg,png,gif,svg,webp|max:2048',
            'starting_honor' => 'required|integer|min:0|max:100',
            'starting_power' => 'required|integer|min:0|max:100',
            'starting_debt' => 'required|integer|min:0|max:100',
        ]);

        if ($request->hasFile('sigil_image')) {
            if ($house->sigil_image_path) {
                Storage::disk('public')->delete($house->sigil_image_path);
            }
            $validated['sigil_image_path'] = $request->file('sigil_image')->store('houses', 'public');
        }

        $house->update($validated);
        return redirect()->route('houses.show', $house);
    }

    public function destroy(Request $request, House $house)
    {
        Gate::authorize('delete-houses');

        $house->delete();

        return redirect()->route('houses.index');
    }
}
