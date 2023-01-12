<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLocationRequest;
use App\Models\Location;
use App\Services\LocationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class LocationController extends Controller
{
    public function __construct(
        private readonly LocationService $locationService,
    ) {
    }

    public function index(): JsonResponse
    {
        $locations = $this->locationService->getAll();

        return $this->response($locations, __('messages.records_fetched'));
    }

    public function store(CreateLocationRequest $request): JsonResponse
    {
        $location = $this->locationService->create($request->validated());

        return $this->response($location, __('messages.record_created'), Response::HTTP_CREATED);
    }

    public function show(Location $location): JsonResponse
    {
        $this->authorize('view', $location);

        return $this->response($location, __('messages.record_fetched'));
    }

    public function update(CreateLocationRequest $request, Location $location): JsonResponse
    {
        $this->authorize('update', $location);

        $location = $this->locationService->update($location, $request->validated());

        return $this->response($location, __('messages.record_updated'));
    }

    public function destroy(Location $location): JsonResponse
    {
        $this->authorize('delete', $location);

        $this->locationService->delete($location);

        return $this->response(null, __('messages.record_deleted'));
    }
}
