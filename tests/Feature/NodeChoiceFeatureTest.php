<?php

namespace Tests\Feature;

use App\Models\Choice;
use App\Models\House;
use App\Models\Node;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NodeChoiceFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_view_nodes_index(): void
    {
        Node::factory()->count(3)->create();

        $this->get('/nodes')->assertRedirect('/login');
    }

    public function test_guests_can_view_node_details(): void
    {
        $node = Node::factory()->create();

        $this->get("/nodes/{$node->id}")->assertStatus(200);
    }

    public function test_non_admin_cannot_create_nodes(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)->get('/nodes/create')->assertStatus(403);
    }

    public function test_admin_can_create_nodes(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post('/nodes', [
            'node_code' => 'TEST_01',
            'title' => 'Test Node',
            'narrative_text' => 'Test narrative content.',
            'starting_honor' => 50,
            'starting_power' => 50,
            'starting_debt' => 10,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('nodes', ['node_code' => 'TEST_01']);
    }

    public function test_admin_can_update_nodes(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $node = Node::factory()->create();

        $response = $this->actingAs($admin)->put("/nodes/{$node->id}", [
            'node_code' => 'UPDATED_01',
            'title' => 'Updated Node',
            'narrative_text' => 'Updated narrative.',
            'starting_honor' => 50,
            'starting_power' => 50,
            'starting_debt' => 10,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('nodes', ['node_code' => 'UPDATED_01']);
    }

    public function test_admin_can_delete_nodes(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $node = Node::factory()->create();

        $response = $this->actingAs($admin)->delete("/nodes/{$node->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('nodes', ['id' => $node->id]);
    }

    public function test_node_requires_unique_code(): void
    {
        $node = Node::factory()->create(['node_code' => 'DUPLICATE']);
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post('/nodes', [
            'node_code' => 'DUPLICATE',
            'title' => 'Test',
            'narrative_text' => 'Test',
            'starting_honor' => 50,
            'starting_power' => 50,
            'starting_debt' => 10,
        ]);

        $response->assertSessionHasErrors('node_code');
    }

    public function test_guests_can_view_choices(): void
    {
        Choice::factory()->count(3)->create();

        $this->get('/choices')->assertStatus(200);
    }

    public function test_guests_can_view_choice_details(): void
    {
        $choice = Choice::factory()->create();

        $this->get("/choices/{$choice->id}")->assertStatus(200);
    }

    public function test_non_admin_cannot_create_choices(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)->get('/choices/create')->assertStatus(403);
    }

    public function test_admin_can_create_choices(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $fromNode = Node::factory()->create();
        $toNode = Node::factory()->create();

        $response = $this->actingAs($admin)->post('/choices', [
            'from_node_id' => $fromNode->id,
            'to_node_id' => $toNode->id,
            'choice_text' => 'Test choice',
            'display_order' => 1,
            'honor_delta' => 10,
            'power_delta' => -5,
            'debt_delta' => 5,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('choices', ['choice_text' => 'Test choice']);
    }

    public function test_admin_can_update_choices(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $choice = Choice::factory()->create();

        $response = $this->actingAs($admin)->put("/choices/{$choice->id}", [
            'from_node_id' => $choice->from_node_id,
            'to_node_id' => $choice->to_node_id,
            'choice_text' => 'Updated choice',
            'display_order' => 1,
            'honor_delta' => 10,
            'power_delta' => -5,
            'debt_delta' => 5,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('choices', ['choice_text' => 'Updated choice']);
    }

    public function test_admin_can_delete_choices(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $choice = Choice::factory()->create();

        $response = $this->actingAs($admin)->delete("/choices/{$choice->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('choices', ['id' => $choice->id]);
    }

    public function test_choice_validates_required_fields(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post('/choices', []);

        $response->assertSessionHasErrors(['from_node_id', 'to_node_id', 'choice_text', 'display_order']);
    }

    public function test_node_has_choices(): void
    {
        $node = Node::factory()->create();
        Choice::factory()->create(['from_node_id' => $node->id, 'display_order' => 1]);
        Choice::factory()->create(['from_node_id' => $node->id, 'display_order' => 2]);
        Choice::factory()->create(['from_node_id' => $node->id, 'display_order' => 3]);

        $node->load('choices');

        $this->assertEquals(3, $node->choices->count());
    }

    public function test_choice_belongs_to_required_house(): void
    {
        $house = House::factory()->create();
        $choice = Choice::factory()->create(['required_house_id' => $house->id]);

        $this->assertEquals($house->id, $choice->requiredHouse->id);
    }
}
