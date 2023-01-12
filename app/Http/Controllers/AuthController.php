<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService)
    {
    }

    public function login(Request $request): JsonResponse
    {
        if (!$this->authService->login($request->email, $request->password)) {
            return $this->reject(null, __('auth.failed'));
        }

        return $this->response([
            'token' => $this->authService->generateToken(),
            'user' => auth()->user()
        ], __('auth.login_successful'));
    }

    public function register(CreateUserRequest $request)
    {
        $user = $this->authService->register(
            name: $request->name,
            email: $request->email,
            password: $request->password
        );

        $this->authService->autoLogin($user);

        return $this->response([
            'token' => $this->authService->generateToken(),
            'user' => auth()->user()
        ], __('auth.registration_successful'), Response::HTTP_CREATED);
    }

    public function user(): JsonResponse
    {
        return $this->response(auth()->user(), __('auth.user'));
    }
}
