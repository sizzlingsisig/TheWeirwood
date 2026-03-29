<?php

namespace App\Http\Controllers;

use App\Models\Ending;
use Illuminate\Support\Facades\Auth;

class EndingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $player = $user->players()->first();

        $allEndings = Ending::with('node')->get();

        $discoveredEndingIds = \DB::table('runs')
            ->where('player_id', $player?->id)
            ->pluck('ending_node_id')
            ->toArray();

        return view('endings.index', compact('allEndings', 'discoveredEndingIds'));
    }
}
