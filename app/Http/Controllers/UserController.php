<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', User::class);

        $filter = $request->only(['status', 'is_merchant', 'is_active']);

        $users = $this->userService->getAll($filter);

        return $this->response($users, __('messages.records_fetched'));
    }

    public function show(User $user): JsonResponse
    {
        $this->authorize('view', $user);

        return $this->response($user, __('messages.record_fetched'));
    }

    public function delete(User $user): JsonResponse
    {
        $user->delete();

        return $this->response($user, __('messages.record_deleted'));
    }
}
