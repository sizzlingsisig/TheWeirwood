<?php

namespace App\Services;

use App\Models\Choice;
use App\Models\DebtEvent;
use App\Models\Game;
use App\Models\GameStep;
use App\Models\House;
use App\Models\Node;
use App\Models\Run;
use Illuminate\Support\Facades\DB;

class GameEngineService
{
    public function processChoice(Game $game, Choice $choice): array
    {
        $honorBefore = $game->honor;
        $powerBefore = $game->power;
        $debtBefore = $game->debt;

        $multiplier = $this->calculateDebtMultiplier($debtBefore);

        $debtPenalty = $this->calculateWeightedSuccessPenalty($game, $choice);

        $actualDebtDelta = $choice->debt_delta > 0
            ? (int) (($choice->debt_delta + $debtPenalty) * $multiplier)
            : $choice->debt_delta;

        $newHonor = max(0, min(100, $honorBefore + ($choice->honor_delta ?? 0)));
        $newPower = max(0, min(100, $powerBefore + ($choice->power_delta ?? 0)));
        $newDebt = min(100, max(0, $debtBefore + $actualDebtDelta));

        DB::transaction(function () use ($game, $choice, $honorBefore, $powerBefore, $debtBefore, $newHonor, $newPower, $newDebt, $multiplier, $debtPenalty) {
            $game->update([
                'current_node_id' => $choice->to_node_id,
                'honor' => $newHonor,
                'power' => $newPower,
                'debt' => $newDebt,
            ]);

            GameStep::create([
                'game_id' => $game->id,
                'choice_id' => $choice->id,
                'sequence_order' => $game->gameSteps()->count() + 1,
                'honor_before' => $honorBefore,
                'power_before' => $powerBefore,
                'debt_before' => $debtBefore,
                'honor_after' => $newHonor,
                'power_after' => $newPower,
                'debt_after' => $newDebt,
                'debt_multiplier_applied' => $multiplier,
                'weighted_success_penalty' => $debtPenalty,
                'chosen_at' => now(),
            ]);

            $this->logDebtEventsIfTriggered($game, $debtBefore, $newDebt, $multiplier, $choice->to_node_id);
        });

        $game->refresh();

        if ($newHonor <= 0 || $newDebt >= 100) {
            $this->endGame($game);

            return ['status' => 'ruin', 'game' => $game];
        }

        $nextNode = $choice->toNode;

        if ($nextNode && $nextNode->is_ending) {
            $this->endGame($game);

            return ['status' => 'ending', 'game' => $game];
        }

        return ['status' => 'continue', 'game' => $game];
    }

    public function endGame(Game $game): void
    {
        $game->load(['currentNode.ending', 'house', 'player.user']);
        $game->is_complete = true;
        $game->session_ended = now();
        $game->save();

        $ending = $game->currentNode->ending;
        $unlockedHouse = null;

        if ($ending && $ending->unlocks_house_id) {
            $user = $game->player->user;

            if (! $user->hasHouse($ending->unlockedHouse)) {
                $user->houses()->attach($ending->unlocks_house_id, ['unlocked_at' => now()]);
                $unlockedHouse = $ending->unlockedHouse;
            }
        }

        Run::create([
            'game_id' => $game->id,
            'player_id' => $game->player_id,
            'house_id' => $game->house_id,
            'region_id' => $game->region_id,
            'starting_node_id' => $game->gameSteps()->first()?->choice?->fromNode?->id ?? $game->current_node_id,
            'ending_node_id' => $game->current_node_id,
            'final_honor' => $game->honor,
            'final_power' => $game->power,
            'final_debt' => $game->debt,
            'steps_taken' => $game->gameSteps()->count(),
            'is_victory' => $game->honor > 0 && $game->debt < 100,
            'unlocked_house_id' => $unlockedHouse?->id,
            'completed_at' => now(),
        ]);
    }

    public function getStartingNodeId(string $entryMode, House $house): int
    {
        $nodeCode = match ($entryMode) {
            'commoner' => 'TRUNK_01',
            'quiz' => 'QUIZ_01',
            'map' => 'MAP_01',
            'blind' => 'BLIND_01',
            default => 'TRUNK_01',
        };

        $node = Node::where('node_code', $nodeCode)->first();

        return $node?->id ?? Node::where('node_code', 'TRUNK_01')->firstOrFail()->id;
    }

    public function calculateDebtMultiplier(int $currentDebt): float
    {
        if ($currentDebt >= 80) {
            return 2.0;
        }
        if ($currentDebt >= 60) {
            return 1.6;
        }
        if ($currentDebt >= 40) {
            return 1.3;
        }

        return 1.0;
    }

    private function calculateWeightedSuccessPenalty(Game $game, Choice $choice): int
    {
        if ($choice->power_delta > 0 && $game->power < 40) {
            return 15;
        }

        return 0;
    }

    private function logDebtEventsIfTriggered(Game $game, int $oldDebt, int $newDebt, float $multiplier, int $nodeId): void
    {
        if ($multiplier > 1.0) {
            $eventType = $multiplier >= 1.6 ? 'multiplier_1_6' : 'multiplier_1_3';
            DebtEvent::create([
                'game_id' => $game->id,
                'event_type' => $eventType,
                'debt_value_at_event' => $newDebt,
                'multiplier_used' => $multiplier,
                'triggered_at_node' => $nodeId,
                'occurred_at' => now(),
            ]);
        }
    }
}
