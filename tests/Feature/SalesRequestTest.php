<?php

namespace Tests\Feature;

use App\Models\SalesRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class SalesRequestTest extends TestCase
{
    public function testCanCreateSalesRequest()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson(route('sales-requests.store'), [
            'price' => '100.00',
            'description' => 'Purchase of 1000 units of product X',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testCanUpdateSalesRequest()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $salesRequest = SalesRequest::factory()->create();

        $response = $this->putJson(route('sales-requests.update', $salesRequest), [
            'price' => '200.00',
            'description' => 'Purchase of 2000 units of product X',
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertNotEquals($salesRequest, $salesRequest->fresh());
    }

    public function testUnAuthorizedUserCannotUpdateSalesRequest()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $salesRequest = SalesRequest::factory()->create();

        $this->actingAs(User::factory()->create());

        $response = $this->putJson(route('sales-requests.update', $salesRequest), [
            'price' => '200.00',
            'description' => 'Purchase of 2000 units of product X',
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testCanDeleteSalesRequest()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $salesRequest = SalesRequest::factory()->create();

        $response = $this->deleteJson(route('sales-requests.destroy', $salesRequest));

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testUnAuthorizedUserCannotDeleteSalesRequest()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $salesRequest = SalesRequest::factory()->create();

        $this->actingAs(User::factory()->create());

        $response = $this->deleteJson(route('sales-requests.destroy', $salesRequest));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testCanGetAllSalesRequests()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        SalesRequest::factory()->count(10)->create();

        $response = $this->getJson(route('sales-requests.index'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['data' => ['data' => ['*' => ['id', 'price', 'description', 'created_at', 'updated_at']]]]);
    }
}
