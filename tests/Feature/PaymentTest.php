<?php

namespace Tests\Feature;

use App\Models\Payment;
use App\Models\SalesRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    public function testCanCreatePayment()
    {
        $this->actingAs(User::factory()->create());

        $countBefore = Payment::count();

        $salesRequest = SalesRequest::factory()->create();

        $response = $this->postJson('/api/payments', [
            'amount' => 1000,
            'reference' => '1234567890',
            'sales_request_id' => $salesRequest->id,
        ]);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertEquals($countBefore + 1, Payment::count());
    }

    public function testCanGetAllPayments()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->getJson('/api/payments');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'data' => [
                        '*' => [
                            'id',
                            'user_id',
                            'sales_request_id',
                            'reference',
                            'amount',
                            'currency',
                            'payment_method',
                            'payment_provider',
                            'status',
                            'created_at',
                            'updated_at',
                        ],
                    ],
                ],
            ]);
    }

    public function testCanGetPayment()
    {
        $this->actingAs(User::factory()->create());

        $payment = Payment::factory()->create();

        $response = $this->getJson('/api/payments/'.$payment->id);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'user_id',
                    'sales_request_id',
                    'reference',
                    'amount',
                    'currency',
                    'payment_method',
                    'payment_provider',
                    'status',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }
}
