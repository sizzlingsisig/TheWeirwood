<?php

namespace App\Http\Controllers;

use App\Models\Ending;
use App\Models\Run;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $player = $user->players()->first();

        $totalRuns = $player?->games()->where('is_complete', true)->count() ?? 0;
        $unlockedHouses = $user->houses()->count();

        $discoveredEndingIds = Run::where('player_id', $player?->id)
            ->pluck('ending_node_id')
            ->toArray();
        $discoveredEndings = count(array_unique($discoveredEndingIds));

        return view('dashboard', compact('totalRuns', 'unlockedHouses', 'discoveredEndings'));
    }
}
