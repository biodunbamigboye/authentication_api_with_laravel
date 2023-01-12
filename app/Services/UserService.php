<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function getAll(?array $filter = null): LengthAwarePaginator
    {
        $query = User::query();

        if ($filter) {
            $query->where($filter);
        }

        return $query->paginate();
    }
}
