<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return boolval($user->is_admin);
    }

    public function view(User $user, User $model): bool
    {
        return $model->id === $user->id;
    }
}
