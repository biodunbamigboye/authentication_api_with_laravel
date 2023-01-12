<?php

namespace App\Services;

use App\Models\Location;

class LocationService
{
    public function create(array $payload): Location
    {
        return Location::create($payload);
    }
}
