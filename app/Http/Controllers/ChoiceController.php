<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\House;
use App\Models\Node;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ChoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $choices = Choice::with(['fromNode', 'toNode', 'requiredHouse'])->paginate(20);

        return view('choices.index', compact('choices'));
    }

    public function create()
    {
        Gate::authorize('create-houses');
        $nodes = Node::all();
        $houses = House::all();

        return view('choices.create', compact('nodes', 'houses'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create-houses');

        $validated = $request->validate([
            'from_node_id' => 'required|exists:nodes,id',
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

        Choice::create($validated);

        return redirect()->route('choices.index')->with('success', 'Choice created!');
    }

    public function show(Choice $choice)
    {
        $choice->load(['fromNode', 'toNode', 'requiredHouse']);

        return view('choices.show', compact('choice'));
    }

    public function edit(Choice $choice)
    {
        Gate::authorize('create-houses');
        $nodes = Node::all();
        $houses = House::all();

        return view('choices.edit', compact('choice', 'nodes', 'houses'));
    }

    public function update(Request $request, Choice $choice)
    {
        Gate::authorize('create-houses');

        $validated = $request->validate([
            'from_node_id' => 'required|exists:nodes,id',
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

        $choice->update($validated);

        return redirect()->route('choices.show', $choice)->with('success', 'Choice updated!');
    }

    public function destroy(Choice $choice)
    {
        Gate::authorize('create-houses');
        $choice->delete();

        return redirect()->route('choices.index')->with('success', 'Choice deleted!');
    }
}
