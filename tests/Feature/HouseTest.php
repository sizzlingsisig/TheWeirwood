<?php

namespace Tests\Feature;

use App\Models\House;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HouseTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_view_houses_index(): void
    {
        House::factory()->create();

        $this->get('/houses')->assertStatus(200);
    }

    public function test_guests_can_view_house_details(): void
    {
        $house = House::factory()->create();

        $this->get("/houses/{$house->id}")->assertStatus(200);
    }

    public function test_guests_cannot_create_houses(): void
    {
        $this->get('/houses/create')->assertRedirect('/login');
    }

    public function test_non_admin_users_cannot_create_houses(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/houses/create')->assertStatus(403);
    }

    public function test_admin_users_can_view_create_page(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $this->get('/houses/create')->assertStatus(200);
    }

    public function test_admin_users_can_create_houses(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $this->post('/houses', [
            'name' => 'Test House',
            'motto' => 'Test Motto',
            'description' => 'Test Description',
            'starting_honor' => 50,
            'starting_power' => 50,
            'starting_debt' => 10,
        ])->assertRedirect('/houses/1');

        $this->assertDatabaseHas('houses', ['name' => 'Test House']);
    }

    public function test_admin_users_can_update_houses(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $house = House::factory()->create();
        $this->actingAs($admin);

        $this->put("/houses/{$house->id}", [
            'name' => 'Updated House',
            'motto' => 'Updated Motto',
            'description' => 'Updated Description',
            'starting_honor' => 60,
            'starting_power' => 40,
            'starting_debt' => 20,
        ])->assertRedirect("/houses/{$house->id}");

        $this->assertDatabaseHas('houses', ['name' => 'Updated House']);
    }

    public function test_admin_users_can_delete_houses(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $house = House::factory()->create();
        $this->actingAs($admin);

        $this->delete("/houses/{$house->id}")->assertRedirect('/houses');

        $this->assertSoftDeleted('houses', ['id' => $house->id]);
    }

    public function test_admin_users_can_restore_deleted_houses(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $house = House::factory()->create();
        $this->actingAs($admin);

        $house->delete();

        $this->assertSoftDeleted('houses', ['id' => $house->id]);

        $this->post("/houses/{$house->id}/restore");

        $this->assertDatabaseHas('houses', ['id' => $house->id, 'deleted_at' => null]);
    }

    public function test_admin_users_can_force_delete_houses(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $house = House::factory()->create();
        $this->actingAs($admin);

        $house->delete();

        $this->delete("/houses/{$house->id}/force-delete");

        $this->assertDatabaseMissing('houses', ['id' => $house->id]);
    }

    public function test_house_requires_valid_data(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $this->post('/houses', [])->assertSessionHasErrors(['name', 'starting_honor', 'starting_power', 'starting_debt']);
    }
}
