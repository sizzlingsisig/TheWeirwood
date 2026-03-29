<?php

namespace Tests\Feature;

use App\Models\Choice;
use App\Models\Ending;
use App\Models\Game;
use App\Models\House;
use App\Models\Node;
use App\Models\Player;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Player $player;

    protected House $house;

    protected Node $startNode;

    protected Node $nextNode;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->player = Player::factory()->create(['user_id' => $this->user->id]);
        $this->house = House::factory()->create();

        $this->startNode = Node::factory()->create(['node_code' => 'TEST_START']);
        $this->nextNode = Node::factory()->create(['node_code' => 'TEST_NEXT']);
    }

    public function test_guest_cannot_access_games(): void
    {
        $this->get('/games')->assertRedirect('/login');
    }

    public function test_user_can_view_games_index(): void
    {
        $this->actingAs($this->user)
            ->get('/games')
            ->assertStatus(200);
    }

    public function test_user_can_start_game(): void
    {
        Node::factory()->create(['node_code' => 'TRUNK_01']);
        $this->user->houses()->attach($this->house->id, ['unlocked_at' => now()]);

        $response = $this->actingAs($this->user)->post('/games/start', [
            'house_id' => $this->house->id,
            'entry_mode' => 'commoner',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('games', [
            'house_id' => $this->house->id,
            'entry_mode' => 'commoner',
            'is_complete' => false,
        ]);
    }

    public function test_start_game_requires_house(): void
    {
        $response = $this->actingAs($this->user)->post('/games/start', [
            'house_id' => '',
            'entry_mode' => 'commoner',
        ]);

        $response->assertSessionHasErrors('house_id');
    }

    public function test_start_game_requires_valid_entry_mode(): void
    {
        $this->user->houses()->attach($this->house->id, ['unlocked_at' => now()]);

        $response = $this->actingAs($this->user)->post('/games/start', [
            'house_id' => $this->house->id,
            'entry_mode' => 'invalid_mode',
        ]);

        $response->assertSessionHasErrors('entry_mode');
    }

    public function test_user_can_play_game(): void
    {
        $game = Game::factory()->create([
            'player_id' => $this->player->id,
            'house_id' => $this->house->id,
            'current_node_id' => $this->startNode->id,
        ]);

        $response = $this->actingAs($this->user)->get("/games/{$game->id}/play");

        $response->assertStatus(200);
        $response->assertSee($this->startNode->title);
    }

    public function test_user_cannot_play_others_game(): void
    {
        $otherUser = User::factory()->create();
        $otherPlayer = Player::factory()->create(['user_id' => $otherUser->id]);

        $game = Game::factory()->create([
            'player_id' => $otherPlayer->id,
            'current_node_id' => $this->startNode->id,
        ]);

        $response = $this->actingAs($this->user)->get("/games/{$game->id}/play");

        $response->assertStatus(403);
    }

    public function test_user_can_make_choice(): void
    {
        $game = Game::factory()->create([
            'player_id' => $this->player->id,
            'house_id' => $this->house->id,
            'current_node_id' => $this->startNode->id,
            'honor' => 50,
            'power' => 50,
            'debt' => 20,
        ]);

        $choice = Choice::factory()->create([
            'from_node_id' => $this->startNode->id,
            'to_node_id' => $this->nextNode->id,
            'honor_delta' => 10,
            'power_delta' => -5,
            'debt_delta' => 5,
        ]);

        $response = $this->actingAs($this->user)->post("/games/{$game->id}/choice/{$choice->id}");

        $response->assertRedirect();

        $this->assertDatabaseHas('game_steps', [
            'game_id' => $game->id,
            'choice_id' => $choice->id,
            'honor_before' => 50,
            'honor_after' => 60,
            'power_before' => 50,
            'power_after' => 45,
            'debt_before' => 20,
            'debt_after' => 25,
        ]);
    }

    public function test_debt_multiplier_applies_at_40_debt(): void
    {
        $game = Game::factory()->create([
            'player_id' => $this->player->id,
            'house_id' => $this->house->id,
            'current_node_id' => $this->startNode->id,
            'honor' => 50,
            'power' => 50,
            'debt' => 40,
        ]);

        $choice = Choice::factory()->create([
            'from_node_id' => $this->startNode->id,
            'to_node_id' => $this->nextNode->id,
            'debt_delta' => 10,
        ]);

        $this->actingAs($this->user)->post("/games/{$game->id}/choice/{$choice->id}");

        $game->refresh();

        $this->assertEquals(53, $game->debt);
        $this->assertDatabaseHas('debt_events', [
            'game_id' => $game->id,
            'event_type' => 'multiplier_1_3',
        ]);
    }

    public function test_debt_multiplier_applies_at_60_debt(): void
    {
        $game = Game::factory()->create([
            'player_id' => $this->player->id,
            'house_id' => $this->house->id,
            'current_node_id' => $this->startNode->id,
            'honor' => 50,
            'power' => 50,
            'debt' => 60,
        ]);

        $choice = Choice::factory()->create([
            'from_node_id' => $this->startNode->id,
            'to_node_id' => $this->nextNode->id,
            'debt_delta' => 10,
        ]);

        $this->actingAs($this->user)->post("/games/{$game->id}/choice/{$choice->id}");

        $game->refresh();

        $this->assertEquals(76, $game->debt);
        $this->assertDatabaseHas('debt_events', [
            'game_id' => $game->id,
            'event_type' => 'multiplier_1_6',
        ]);
    }

    public function test_debt_multiplier_applies_at_80_debt(): void
    {
        $game = Game::factory()->create([
            'player_id' => $this->player->id,
            'house_id' => $this->house->id,
            'current_node_id' => $this->startNode->id,
            'honor' => 50,
            'power' => 50,
            'debt' => 80,
        ]);

        $choice = Choice::factory()->create([
            'from_node_id' => $this->startNode->id,
            'to_node_id' => $this->nextNode->id,
            'debt_delta' => 10,
        ]);

        $this->actingAs($this->user)->post("/games/{$game->id}/choice/{$choice->id}");

        $game->refresh();

        $this->assertEquals(100, $game->debt);
    }

    public function test_debt_reduction_is_not_multiplied(): void
    {
        $game = Game::factory()->create([
            'player_id' => $this->player->id,
            'house_id' => $this->house->id,
            'current_node_id' => $this->startNode->id,
            'honor' => 50,
            'power' => 50,
            'debt' => 50,
        ]);

        $choice = Choice::factory()->create([
            'from_node_id' => $this->startNode->id,
            'to_node_id' => $this->nextNode->id,
            'debt_delta' => -10,
        ]);

        $this->actingAs($this->user)->post("/games/{$game->id}/choice/{$choice->id}");

        $game->refresh();

        $this->assertEquals(40, $game->debt);
    }

    public function test_choice_blocked_without_required_house(): void
    {
        $differentHouse = House::factory()->create();

        $game = Game::factory()->create([
            'player_id' => $this->player->id,
            'house_id' => $this->house->id,
            'current_node_id' => $this->startNode->id,
        ]);

        $choice = Choice::factory()->create([
            'from_node_id' => $this->startNode->id,
            'to_node_id' => $this->nextNode->id,
            'required_house_id' => $differentHouse->id,
        ]);

        $response = $this->actingAs($this->user)->post("/games/{$game->id}/choice/{$choice->id}");

        $response->assertSessionHas('error');
    }

    public function test_choice_available_with_required_house(): void
    {
        $game = Game::factory()->create([
            'player_id' => $this->player->id,
            'house_id' => $this->house->id,
            'current_node_id' => $this->startNode->id,
        ]);

        $choice = Choice::factory()->create([
            'from_node_id' => $this->startNode->id,
            'to_node_id' => $this->nextNode->id,
            'required_house_id' => $this->house->id,
        ]);

        $response = $this->actingAs($this->user)->post("/games/{$game->id}/choice/{$choice->id}");

        $response->assertRedirect();
    }

    public function test_choice_blocked_at_high_debt(): void
    {
        $game = Game::factory()->create([
            'player_id' => $this->player->id,
            'house_id' => $this->house->id,
            'current_node_id' => $this->startNode->id,
            'debt' => 95,
        ]);

        $choice = Choice::factory()->create([
            'from_node_id' => $this->startNode->id,
            'to_node_id' => $this->nextNode->id,
            'locks_on_high_debt' => true,
        ]);

        $response = $this->actingAs($this->user)->get("/games/{$game->id}/play");

        $response->assertStatus(200);

        $availableChoices = $response->viewData('availableChoices');
        $this->assertFalse($availableChoices->contains($choice->id));
    }

    public function test_game_ends_at_100_debt(): void
    {
        $game = Game::factory()->create([
            'player_id' => $this->player->id,
            'house_id' => $this->house->id,
            'current_node_id' => $this->startNode->id,
            'honor' => 50,
            'power' => 50,
            'debt' => 95,
        ]);

        $choice = Choice::factory()->create([
            'from_node_id' => $this->startNode->id,
            'to_node_id' => $this->nextNode->id,
            'debt_delta' => 10,
        ]);

        $response = $this->actingAs($this->user)->post("/games/{$game->id}/choice/{$choice->id}");

        $game->refresh();

        $this->assertTrue($game->is_complete);
    }

    public function test_game_ends_at_0_honor(): void
    {
        $game = Game::factory()->create([
            'player_id' => $this->player->id,
            'house_id' => $this->house->id,
            'current_node_id' => $this->startNode->id,
            'honor' => 5,
            'debt' => 20,
        ]);

        $choice = Choice::factory()->create([
            'from_node_id' => $this->startNode->id,
            'to_node_id' => $this->nextNode->id,
            'honor_delta' => -10,
        ]);

        $response = $this->actingAs($this->user)->post("/games/{$game->id}/choice/{$choice->id}");

        $game->refresh();

        $this->assertTrue($game->is_complete);
    }

    public function test_run_created_on_game_end(): void
    {
        $game = Game::factory()->create([
            'player_id' => $this->player->id,
            'house_id' => $this->house->id,
            'current_node_id' => $this->startNode->id,
            'honor' => 50,
            'power' => 50,
            'debt' => 95,
        ]);

        $choice = Choice::factory()->create([
            'from_node_id' => $this->startNode->id,
            'to_node_id' => $this->nextNode->id,
            'debt_delta' => 10,
            'honor_delta' => 0,
        ]);

        $this->actingAs($this->user)->post("/games/{$game->id}/choice/{$choice->id}");

        $game->refresh();

        $this->assertTrue($game->is_complete);
        $this->assertDatabaseHas('runs', [
            'game_id' => $game->id,
            'player_id' => $this->player->id,
            'house_id' => $this->house->id,
            'final_honor' => $game->honor,
            'final_debt' => $game->debt,
            'is_victory' => false,
        ]);
    }

    public function test_unlocked_house_granted_on_ending(): void
    {
        $unlockHouse = House::factory()->create();

        $endingNode = Node::factory()->ending()->create();
        $unlockEnding = Ending::create([
            'node_id' => $endingNode->id,
            'verdict_label' => 'Victory',
            'ending_type' => 'honor',
            'ending_text' => 'You won!',
            'unlocks_house_id' => $unlockHouse->id,
        ]);

        $game = Game::factory()->create([
            'player_id' => $this->player->id,
            'house_id' => $this->house->id,
            'current_node_id' => $this->startNode->id,
            'honor' => 80,
            'debt' => 20,
        ]);

        Choice::factory()->create([
            'from_node_id' => $this->startNode->id,
            'to_node_id' => $endingNode->id,
        ]);

        $this->actingAs($this->user)->post("/games/{$game->id}/choice/{$game->currentNode->choices->first()->id}");

        $this->assertTrue($this->user->hasHouse($unlockHouse));
    }

    public function test_game_can_set_and_get_flags(): void
    {
        $game = Game::factory()->create([
            'player_id' => $this->player->id,
            'current_node_id' => $this->startNode->id,
        ]);

        $game->setFlag('spared_thief', true);
        $game->setFlag('found_secret', false);

        $this->assertTrue($game->hasFlag('spared_thief'));
        $this->assertFalse($game->hasFlag('found_secret'));
        $this->assertNull($game->getFlag('nonexistent'));
    }

    public function test_choice_requirements_min_honor_met(): void
    {
        $game = Game::factory()->create([
            'player_id' => $this->player->id,
            'current_node_id' => $this->startNode->id,
            'honor' => 60,
        ]);

        $choice = Choice::factory()->create([
            'from_node_id' => $this->startNode->id,
            'to_node_id' => $this->nextNode->id,
            'requirements_json' => ['min_honor' => 50],
        ]);

        $this->assertTrue($choice->meetsRequirements($game));
    }

    public function test_choice_requirements_min_honor_not_met(): void
    {
        $game = Game::factory()->create([
            'player_id' => $this->player->id,
            'current_node_id' => $this->startNode->id,
            'honor' => 40,
        ]);

        $choice = Choice::factory()->create([
            'from_node_id' => $this->startNode->id,
            'to_node_id' => $this->nextNode->id,
            'requirements_json' => ['min_honor' => 50],
        ]);

        $this->assertFalse($choice->meetsRequirements($game));
    }

    public function test_choice_requirements_required_flag(): void
    {
        $game = Game::factory()->create([
            'player_id' => $this->player->id,
            'current_node_id' => $this->startNode->id,
        ]);

        $game->setFlag('spared_thief', true);

        $choice = Choice::factory()->create([
            'from_node_id' => $this->startNode->id,
            'to_node_id' => $this->nextNode->id,
            'requirements_json' => ['required_flag' => 'spared_thief'],
        ]);

        $this->assertTrue($choice->meetsRequirements($game));
    }

    public function test_choice_requirements_forbidden_flag(): void
    {
        $game = Game::factory()->create([
            'player_id' => $this->player->id,
            'current_node_id' => $this->startNode->id,
        ]);

        $game->setFlag('killed_thief', true);

        $choice = Choice::factory()->create([
            'from_node_id' => $this->startNode->id,
            'to_node_id' => $this->nextNode->id,
            'requirements_json' => ['forbidden_flag' => 'killed_thief'],
        ]);

        $this->assertFalse($choice->meetsRequirements($game));
    }

    public function test_weighted_success_penalty_applied_when_low_power(): void
    {
        $game = Game::factory()->create([
            'player_id' => $this->player->id,
            'house_id' => $this->house->id,
            'current_node_id' => $this->startNode->id,
            'honor' => 50,
            'power' => 30,
            'debt' => 20,
        ]);

        $choice = Choice::factory()->create([
            'from_node_id' => $this->startNode->id,
            'to_node_id' => $this->nextNode->id,
            'power_delta' => 10,
            'debt_delta' => 5,
        ]);

        $this->actingAs($this->user)->post("/games/{$game->id}/choice/{$choice->id}");

        $game->refresh();

        $this->assertEquals(40, $game->debt);
    }

    public function test_no_weighted_success_penalty_with_high_power(): void
    {
        $game = Game::factory()->create([
            'player_id' => $this->player->id,
            'house_id' => $this->house->id,
            'current_node_id' => $this->startNode->id,
            'honor' => 50,
            'power' => 50,
            'debt' => 20,
        ]);

        $choice = Choice::factory()->create([
            'from_node_id' => $this->startNode->id,
            'to_node_id' => $this->nextNode->id,
            'power_delta' => 10,
            'debt_delta' => 5,
        ]);

        $this->actingAs($this->user)->post("/games/{$game->id}/choice/{$choice->id}");

        $game->refresh();

        $this->assertEquals(25, $game->debt);
    }

    public function test_dynamic_choice_text_replaces_house_placeholder(): void
    {
        $game = Game::factory()->create([
            'player_id' => $this->player->id,
            'house_id' => $this->house->id,
            'current_node_id' => $this->startNode->id,
        ]);

        $choice = Choice::factory()->create([
            'from_node_id' => $this->startNode->id,
            'to_node_id' => $this->nextNode->id,
            'choice_text' => '[House] draws their steel!',
        ]);

        $dynamicText = $choice->getDynamicText($game);

        $this->assertEquals("{$this->house->name} draws their steel!", $dynamicText);
    }

    public function test_choice_with_min_power_requirement(): void
    {
        $game = Game::factory()->create([
            'player_id' => $this->player->id,
            'current_node_id' => $this->startNode->id,
            'power' => 30,
        ]);

        $choice = Choice::factory()->create([
            'from_node_id' => $this->startNode->id,
            'to_node_id' => $this->nextNode->id,
            'requirements_json' => ['min_power' => 40],
        ]);

        $this->assertFalse($choice->meetsRequirements($game));
    }
}
