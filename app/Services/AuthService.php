<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login(string $email, string $password): bool
    {
        return auth()->attempt([
            'email' => $email,
            'password' => $password,
        ]);
    }

    public function autoLogin(User $user): void
    {
        auth()->login($user);
    }

    public function register(string $name, string $email, string $password): User
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
    }

    public function generateToken(?User $user = null): string
    {
        $user = $user ?? auth()->user();

        return $user->createToken('auth_token')->plainTextToken;
    }

    public function logout(): void
    {
        auth()->user()->tokens()->delete();
    }
}
