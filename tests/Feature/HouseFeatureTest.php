<?php

namespace Tests\Feature;

use App\Models\House;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HouseFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_view_houses(): void
    {
        House::factory()->count(3)->create();

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

    public function test_non_admin_cannot_create_houses(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)->get('/houses/create')->assertStatus(403);
    }

    public function test_admin_can_create_houses(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post('/houses', [
            'name' => 'Test House',
            'motto' => 'Test Motto',
            'description' => 'Test Description',
            'starting_honor' => 50,
            'starting_power' => 50,
            'starting_debt' => 10,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('houses', ['name' => 'Test House']);
    }

    public function test_admin_can_update_houses(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $house = House::factory()->create();

        $response = $this->actingAs($admin)->put("/houses/{$house->id}", [
            'name' => 'Updated House',
            'motto' => 'Updated Motto',
            'description' => 'Updated Description',
            'starting_honor' => 60,
            'starting_power' => 40,
            'starting_debt' => 20,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('houses', ['name' => 'Updated House']);
    }

    public function test_admin_can_delete_houses(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $house = House::factory()->create();

        $response = $this->actingAs($admin)->delete("/houses/{$house->id}");

        $response->assertRedirect();
        $this->assertSoftDeleted('houses', ['id' => $house->id]);
    }

    public function test_house_requires_valid_data(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post('/houses', []);

        $response->assertSessionHasErrors(['name', 'starting_honor', 'starting_power', 'starting_debt']);
    }

    public function test_house_validates_honor_range(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post('/houses', [
            'name' => 'Test',
            'starting_honor' => 150,
            'starting_power' => 50,
            'starting_debt' => 10,
        ]);

        $response->assertSessionHasErrors('starting_honor');
    }

    public function test_house_validates_debt_range(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post('/houses', [
            'name' => 'Test',
            'starting_honor' => 50,
            'starting_power' => 50,
            'starting_debt' => 150,
        ]);

        $response->assertSessionHasErrors('starting_debt');
    }

    public function test_user_can_have_multiple_houses(): void
    {
        $user = User::factory()->create();
        $house1 = House::factory()->create();
        $house2 = House::factory()->create();

        $user->houses()->attach([$house1->id, $house2->id], ['unlocked_at' => now()]);

        $this->assertTrue($user->hasHouse($house1));
        $this->assertTrue($user->hasHouse($house2));
    }

    public function test_user_can_check_specific_house(): void
    {
        $user = User::factory()->create();
        $house = House::factory()->create();

        $this->assertFalse($user->hasHouse($house));

        $user->houses()->attach($house->id, ['unlocked_at' => now()]);

        $this->assertTrue($user->hasHouse($house));
    }
}
