<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Pagination\LengthAwarePaginator;

class PaymentService
{
    public function getAll(): LengthAwarePaginator
    {
        $query = Payment::query();

        if (! auth()->user()->is_admin) {
            $query->where('user_id', auth()->user()->id);
        }

        return $query->paginate();
    }

    public function create(array $payload): Payment
    {
        return Payment::create($payload);
    }
}
