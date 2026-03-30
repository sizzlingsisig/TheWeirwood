<?php

namespace App\Http\Controllers;

use App\Models\Ending;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EndingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $player = $user->players()->first();

        $allEndings = Ending::with('node')->get();

        $discoveredEndingIds = DB::table('runs')
            ->where('player_id', $player?->id)
            ->whereNotNull('ending_node_id')
            ->pluck('ending_node_id')
            ->toArray();

        return view('endings.index', compact('allEndings', 'discoveredEndingIds'));
    }

    public function show(Ending $ending)
    {
        $user = Auth::user();
        $player = $user->players()->first();

        $discoveredEndingIds = DB::table('runs')
            ->where('player_id', $player?->id)
            ->whereNotNull('ending_node_id')
            ->pluck('ending_node_id')
            ->toArray();

        $isDiscovered = in_array($ending->node_id, $discoveredEndingIds);

        if (! $isDiscovered) {
            return redirect()->route('endings.index');
        }

        return view('endings.show', compact('ending'));
    }
}
