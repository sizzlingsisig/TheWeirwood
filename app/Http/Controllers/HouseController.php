<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class HouseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        // BONUS: Simple Search functionality (Fulfills Rubric 2a)
        $query = House::query();

        if ($request->filled('search')) {
            $query->where('name', 'ilike', '%' . $request->search . '%')
                  ->orWhere('motto', 'ilike', '%' . $request->search . '%');
        }

        // withQueryString() ensures pagination doesn't break when searching
        $houses = $query->paginate(9)->withQueryString();

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
            'sigil_image' => 'required|image|mimes:jpeg,png,gif,svg,webp|max:2048', // Required for creation
            'starting_honor' => 'required|integer|min:0|max:100',
            'starting_power' => 'required|integer|min:0|max:100',
            'starting_debt' => 'required|integer|min:0|max:100',
        ]);

        // Handle the File Upload (Fulfills Rubric 2b)
        if ($request->hasFile('sigil_image')) {
            $validated['sigil_image_path'] = $request->file('sigil_image')->store('houses', 'public');
            
            // FIX: Remove the file object from the array so Laravel doesn't try to save it as text
            unset($validated['sigil_image']); 
        }

        $house = House::create($validated);

        // Auto-unlock this house for the user who created it so they can play it immediately
        if (Auth::check()) {
            Auth::user()->houses()->attach($house->id, ['unlocked_at' => now()]);
        }

        if ($request->wantsJson()) {
            return response()->json($house, 201);
        }

        return redirect()->route('houses.show', $house)->with('success', 'House forged successfully.');
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
            'sigil_image' => 'nullable|image|mimes:jpeg,png,gif,svg,webp|max:2048', // Nullable on update
            'starting_honor' => 'required|integer|min:0|max:100',
            'starting_power' => 'required|integer|min:0|max:100',
            'starting_debt' => 'required|integer|min:0|max:100',
        ]);

        // Handle updating the file
        if ($request->hasFile('sigil_image')) {
            // Delete the old image to save server space
            if ($house->sigil_image_path && Storage::disk('public')->exists($house->sigil_image_path)) {
                Storage::disk('public')->delete($house->sigil_image_path);
            }
            
            $validated['sigil_image_path'] = $request->file('sigil_image')->store('houses', 'public');
            unset($validated['sigil_image']);
        }

        $house->update($validated);

        return redirect()->route('houses.show', $house)->with('success', 'House records updated.');
    }

    public function destroy(Request $request, House $house)
    {
        Gate::authorize('delete-houses');

        // This performs a "Soft Delete", moving it to the archive instead of destroying the data completely
        $house->delete(); 

        return redirect()->route('houses.index')->with('success', 'House moved to the archives.');
    }

    public function trashed(Request $request)
    {
        Gate::authorize('edit-houses');

        $houses = House::onlyTrashed()->paginate(9);

        return view('houses.trashed', compact('houses'));
    }

    public function restore(Request $request, int $id)
    {
        Gate::authorize('edit-houses');

        $house = House::onlyTrashed()->findOrFail($id);
        $house->restore();

        return redirect()->route('houses.trashed')->with('success', 'House restored from archives.');
    }

    public function forceDelete(Request $request, int $id)
    {
        Gate::authorize('edit-houses');

        $house = House::onlyTrashed()->findOrFail($id);

        // Clean up the image from the server permanently
        if ($house->sigil_image_path && Storage::disk('public')->exists($house->sigil_image_path)) {
            Storage::disk('public')->delete($house->sigil_image_path);
        }

        $house->forceDelete();

        return redirect()->route('houses.trashed')->with('success', 'House permanently erased from history.');
    }
}