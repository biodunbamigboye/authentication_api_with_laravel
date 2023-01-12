<?php

namespace App\Services;

use App\Models\SalesRequest;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class SalesRequestService
{

    public function getAll(): LengthAwarePaginator
    {
        $query = SalesRequest::query();

        /** @var User $user */
        $user = auth()->user();

        if(!$user->is_admin){
            $query->where('user_id', $user->id);
        }

        return $query->paginate();
    }

    public function create(float $price, string $description): SalesRequest
    {
        return SalesRequest::create([
           'price' => $price,
            'description' => $description
        ]);
    }

    public function update(SalesRequest $request, array $payload): SalesRequest
    {
        $request->update($payload);

        return $request->fresh();
    }

}