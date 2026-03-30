<?php

namespace App\Http\Controllers;

use App\Models\Ending;
use App\Models\House;
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
        $totalHouses = House::count();

        $discoveredEndingIds = Run::where('player_id', $player?->id)
            ->whereNotNull('ending_node_id')
            ->pluck('ending_node_id')
            ->unique()
            ->toArray();
        $discoveredEndings = Ending::whereIn('node_id', $discoveredEndingIds)->count();
        $totalEndings = Ending::count();

        return view('dashboard', compact('totalRuns', 'unlockedHouses', 'discoveredEndings', 'totalHouses', 'totalEndings'));
    }
}
