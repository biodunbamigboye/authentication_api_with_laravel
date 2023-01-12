<?php

namespace App\Services;

use App\Models\Location;
use Illuminate\Pagination\LengthAwarePaginator;

class LocationService
{
    public function create(array $payload): Location
    {
        return Location::create($payload);
    }

    public function update(Location $location, array $payload): Location
    {
        $location->update($payload);

        return $location;
    }

    public function delete(Location $location): void
    {
        $location->delete();
    }

    public function getAll(): LengthAwarePaginator
    {
        $query = Location::query();

        if (! auth()->user()->is_admin) {
            $query->where('user_id', auth()->id());
        }

        return $query->paginate();
    }
}
