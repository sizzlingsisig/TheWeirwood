<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Game;
use App\Models\House;
use App\Services\GameEngineService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function __construct(
        protected GameEngineService $engine
    ) {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        $player = $user->players()->first();

        if (! $player) {
            $player = $user->players()->create([
                'display_name' => $user->name,
            ]);
        }

        $activeGames = $player->games()->where('is_complete', false)->get();
        $completedGames = $player->games()->where('is_complete', true)->with('run')->get();

        return view('games.index', compact('activeGames', 'completedGames'));
    }

    public function create()
    {
        $user = Auth::user();
        $houses = House::all();
        $userHouses = $user->houses()->pluck('houses.id');

        return view('games.create', compact('houses', 'userHouses', 'user'));
    }

    public function start(Request $request)
    {
        $request->validate([
            'house_id' => 'required|exists:houses,id',
            'region_id' => 'nullable|exists:regions,id',
            'entry_mode' => 'required|in:commoner,quiz,map,blind',
        ]);

        $user = Auth::user();

        $player = $user->players()->firstOrCreate([
            'display_name' => $user->name,
        ]);

        $house = House::findOrFail($request->house_id);

        $game = Game::create([
            'player_id' => $player->id,
            'house_id' => $house->id,
            'region_id' => $request->region_id,
            'entry_mode' => $request->entry_mode,
            'honor' => $house->starting_honor,
            'power' => $house->starting_power,
            'debt' => $house->starting_debt,
            'current_node_id' => $this->engine->getStartingNodeId($request->entry_mode, $house),
            'session_started' => now(),
        ]);

        return redirect()->route('games.play', $game);
    }

    public function play(Game $game)
    {
        $this->authorizePlay($game);

        $game->load(['currentNode.choices.toNode', 'currentNode.choices.requiredHouse', 'currentNode.ending', 'house']);

        $availableChoices = $this->getAvailableChoices($game);

        return view('games.play', compact('game', 'availableChoices'));
    }

    public function makeChoice(Request $request, Game $game, Choice $choice)
    {
        $this->authorizePlay($game);

        $game->load('currentNode');

        if ($game->current_node_id !== $choice->from_node_id) {
            return back()->with('error', 'Invalid choice for current node.');
        }

        $user = Auth::user();
        $player = $user->players()->first();

        if ($choice->required_house_id && ! $player->user->hasHouse($choice->requiredHouse)) {
            return back()->with('error', 'You do not have the required house to make this choice.');
        }

        $result = $this->engine->processChoice($game, $choice);

        if ($result['status'] === 'ruin' || $result['status'] === 'ending') {
            $game->refresh();

            return view('games.ending', [
                'game' => $result['game'],
                'unlockedHouse' => $result['game']->run?->unlockedHouse,
            ]);
        }

        return redirect()->route('games.play', $game);
    }

    public function endGame(Game $game)
    {
        $this->authorizePlay($game);

        $this->engine->endGame($game);
        $game->refresh();

        return view('games.ending', [
            'game' => $game,
            'unlockedHouse' => $game->run?->unlockedHouse,
        ]);
    }

    protected function getAvailableChoices(Game $game): Collection
    {
        return $game->currentNode->choices
            ->filter(function ($choice) use ($game) {
                if ($choice->required_house_id) {
                    if ($choice->required_house_id !== $game->house_id) {
                        return false;
                    }
                }

                if ($choice->locks_on_high_debt && $game->debt >= 90) {
                    return false;
                }

                return true;
            })
            ->sortBy('display_order');
    }

    protected function authorizePlay(Game $game): void
    {
        $user = Auth::user();
        $playerIds = $user->players()->pluck('id');

        if (! $playerIds->contains($game->player_id)) {
            abort(403);
        }
    }
}
