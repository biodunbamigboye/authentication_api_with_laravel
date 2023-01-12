<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;

class AuthTest extends TestCase
{

    public function testUserCanRegisterSuccessfully()
    {
        $response = $this->postJson(route('register'), [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber(),
            'occupation' => $this->faker->jobTitle(),
            'address' => $this->faker->address(),
            'password' => 'Password',
            'password_confirmation' => 'Password',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testUserCanLogin()
    {
        $user = User::factory()->create();

        $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['data' => ['access_token', 'user']]);
    }

    public function testUserCanLogout()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->postJson(route('logout'))
            ->assertStatus(Response::HTTP_OK);
    }
}
