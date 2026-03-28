<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\House;
use App\Models\Node;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class NodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
    }

    public function index()
    {
        $nodes = Node::with('choices')->paginate(20);

        return view('nodes.index', compact('nodes'));
    }

    public function create()
    {
        Gate::authorize('create-houses');
        $houses = House::all();

        return view('nodes.create', compact('houses'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create-houses');

        $validated = $request->validate([
            'node_code' => 'required|string|unique:nodes,node_code|max:50',
            'chapter_label' => 'nullable|string|max:100',
            'title' => 'required|string|max:255',
            'art_image' => 'nullable|image|mimes:jpeg,png,gif,svg,webp|max:2048',
            'narrative_text' => 'required|string',
            'debt_warning_text' => 'nullable|string',
            'debt_warning_threshold' => 'nullable|integer|min:0|max:100',
            'is_ending' => 'boolean',
        ]);

        if ($request->hasFile('art_image')) {
            $validated['art_image_path'] = $request->file('art_image')->store('nodes', 'public');
        }

        $node = Node::create($validated);

        return redirect()->route('nodes.show', $node)->with('success', 'Node created!');
    }

    public function show(Node $node)
    {
        $node->load(['choices.toNode', 'choices.requiredHouse']);

        return view('nodes.show', compact('node'));
    }

    public function edit(Node $node)
    {
        Gate::authorize('create-houses');
        $houses = House::all();

        return view('nodes.edit', compact('node', 'houses'));
    }

    public function update(Request $request, Node $node)
    {
        Gate::authorize('create-houses');

        $validated = $request->validate([
            'node_code' => 'required|string|unique:nodes,node_code,'.$node->id.'|max:50',
            'chapter_label' => 'nullable|string|max:100',
            'title' => 'required|string|max:255',
            'art_image' => 'nullable|image|mimes:jpeg,png,gif,svg,webp|max:2048',
            'narrative_text' => 'required|string',
            'debt_warning_text' => 'nullable|string',
            'debt_warning_threshold' => 'nullable|integer|min:0|max:100',
            'is_ending' => 'boolean',
        ]);

        if ($request->hasFile('art_image')) {
            if ($node->art_image_path) {
                Storage::disk('public')->delete($node->art_image_path);
            }
            $validated['art_image_path'] = $request->file('art_image')->store('nodes', 'public');
        }

        $node->update($validated);

        return redirect()->route('nodes.show', $node)->with('success', 'Node updated!');
    }

    public function destroy(Node $node)
    {
        Gate::authorize('create-houses');
        $node->delete();

        return redirect()->route('nodes.index')->with('success', 'Node deleted!');
    }

    public function createChoice(Node $node)
    {
        Gate::authorize('create-houses');
        $nodes = Node::where('id', '!=', $node->id)->get();
        $houses = House::all();

        return view('nodes.choices.create', compact('node', 'nodes', 'houses'));
    }

    public function storeChoice(Request $request, Node $node)
    {
        Gate::authorize('create-houses');

        $validated = $request->validate([
            'to_node_id' => 'required|exists:nodes,id',
            'display_order' => 'required|integer|min:1',
            'required_house_id' => 'nullable|exists:houses,id',
            'choice_text' => 'required|string',
            'hint_text' => 'nullable|string',
            'honor_delta' => 'integer',
            'power_delta' => 'integer',
            'debt_delta' => 'integer',
            'locks_on_high_debt' => 'boolean',
        ]);

        $validated['from_node_id'] = $node->id;
        Choice::create($validated);

        return redirect()->route('nodes.show', $node)->with('success', 'Choice added!');
    }

    public function destroyChoice(Node $node, Choice $choice)
    {
        Gate::authorize('create-houses');
        $choice->delete();

        return back()->with('success', 'Choice deleted!');
    }
}
