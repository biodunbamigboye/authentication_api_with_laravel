<?php

namespace App\Policies;

use App\Models\SalesRequest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalesRequestPolicy
{
    use HandlesAuthorization;

    public function view(User $user, SalesRequest $saleRequest): bool
    {
        return $user->id === $saleRequest->user_id;
    }

    public function update(User $user, SalesRequest $saleRequest): bool
    {
        return $user->id === $saleRequest->user_id;
    }

    public function delete(User $user, SalesRequest $saleRequest): bool
    {
        return $user->id === $saleRequest->user_id &&
            $saleRequest->status === SalesRequest::STATUS_PENDING;
    }
}
