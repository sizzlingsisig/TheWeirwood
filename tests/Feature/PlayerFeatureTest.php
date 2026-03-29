<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_players(): void
    {
        $this->get('/players')->assertRedirect('/login');
    }

    public function test_user_can_view_players_index(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/players')->assertStatus(200);
    }

    public function test_user_can_view_create_player_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/players/create')->assertStatus(200);
    }

    public function test_user_can_create_player(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/players', [
            'display_name' => 'Test Player',
        ]);

        $response->assertRedirect('/games');
        $this->assertDatabaseHas('players', [
            'user_id' => $user->id,
            'display_name' => 'Test Player',
        ]);
    }

    public function test_player_requires_display_name(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/players', []);

        $response->assertSessionHasErrors('display_name');
    }

    public function test_user_can_view_player_details(): void
    {
        $user = User::factory()->create();
        $player = Player::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get("/players/{$player->id}");

        $response->assertStatus(200);
    }

    public function test_user_can_view_edit_page_for_player(): void
    {
        $user = User::factory()->create();
        $player = Player::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get("/players/{$player->id}/edit");

        $response->assertStatus(200);
    }

    public function test_user_can_delete_player(): void
    {
        $user = User::factory()->create();
        $player = Player::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete("/players/{$player->id}");

        $response->assertStatus(200);
        $this->assertSoftDeleted('players', ['id' => $player->id]);
    }

    public function test_player_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $player = Player::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $player->user->id);
    }

    public function test_user_has_many_players(): void
    {
        $user = User::factory()->create();
        Player::factory()->count(3)->create(['user_id' => $user->id]);

        $this->assertEquals(3, $user->players->count());
    }
}
