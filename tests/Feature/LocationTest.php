<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class LocationTest extends TestCase
{
    public function testCanCreateLocation()
    {
        $this->actingAs(User::factory()->create());

        $countBefore = Location::count();

        $response = $this->postJson('/api/locations', [
            'latitude' => '123',
            'longitude' => '456',
            'address' => '123 Main St',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson(['data' => [
            'latitude' => '123',
            'longitude' => '456',
            'address' => '123 Main St',
        ]]);

        $this->assertEquals($countBefore + 1, Location::count());
    }

    public function testCanUpdateLocation()
    {
        $this->actingAs(User::factory()->create());

        $location = Location::factory()->create();

        $response = $this->putJson("/api/locations/{$location->id}", [
            'latitude' => '123',
            'longitude' => '456',
            'address' => '123 Main St',
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['data' => [
            'latitude' => '123',
            'longitude' => '456',
            'address' => '123 Main St',
        ]]);
    }

    public function testCanDeleteLocation()
    {
        $this->actingAs(User::factory()->create());

        $location = Location::factory()->create();

        $countBefore = Location::count();

        $response = $this->deleteJson("/api/locations/{$location->id}");

        $response->assertStatus(Response::HTTP_OK);

        $this->assertEquals($countBefore - 1, Location::count());
    }

    public function testCanGetAllLocations()
    {
        $this->actingAs(User::factory()->create());

        $locations = Location::factory()->count(5)->create();

        $response = $this->getJson('/api/locations');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['data' => ['data' => ['*' => ['id', 'latitude', 'longitude', 'address']]]]);
    }

    public function testCanGetSingleLocation()
    {
        $this->actingAs(User::factory()->create());

        $location = Location::factory()->create();

        $response = $this->getJson("/api/locations/{$location->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['data' => ['id', 'latitude', 'longitude', 'address']]);
    }
}
