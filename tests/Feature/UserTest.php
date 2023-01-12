<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testCanGetAllUsers(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        User::factory()->count(10)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['data' => ['data' => [['id', 'name', 'email', 'is_merchant', 'is_active', 'created_at', 'updated_at']]]]);
    }

    public function testCanFilterUser()
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        User::factory()->count(5)->create();
        User::factory()->count(5)->create(['is_merchant' => true]);


        $response = $this->getJson('/api/users?is_merchant=1');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['data' => ['data' => [['id', 'name', 'email', 'is_merchant', 'is_active', 'created_at', 'updated_at']]]])
            ->assertJsonCount(5, 'data.data');
    }

    public function testCanGetUser(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['data' => ['id', 'name', 'email', 'is_merchant', 'is_active', 'created_at', 'updated_at']]);
    }
}
