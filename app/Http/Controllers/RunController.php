<?php

namespace App\Http\Controllers;

use App\Models\Run;
use Illuminate\Support\Facades\Auth;

class RunController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $player = $user->players()->first();

        $runs = Run::where('player_id', $player?->id)
            ->with(['house', 'endingNode'])
            ->orderBy('completed_at', 'desc')
            ->get();

        return view('runs.index', compact('runs'));
    }

    public function show(Run $run)
    {
        $user = Auth::user();
        $player = $user->players()->first();

        if ($run->player_id !== $player?->id) {
            abort(403);
        }

        $run->load(['game.gameSteps.choice', 'house', 'endingNode', 'startingNode']);

        return view('runs.show', compact('run'));
    }
}
