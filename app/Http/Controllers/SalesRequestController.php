<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSalesRequestRequest;
use App\Http\Requests\UpdateSalesRequestRequest;
use App\Models\SalesRequest;
use App\Services\SalesRequestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SalesRequestController extends Controller
{
    public function __construct(private readonly SalesRequestService $salesRequestService)
    {
    }

    public function index(): JsonResponse
    {
        $salesRequests = $this->salesRequestService->getAll();

        return $this->response($salesRequests, __('messages.records_fetched'));
    }

    public function store(CreateSalesRequestRequest $request): JsonResponse
    {
        $salesRequest = $this->salesRequestService->create(
            price: $request->price,
            description: $request->description
        );

        return $this->response($salesRequest, __('messages.record_created'), Response::HTTP_CREATED);
    }

    public function update(UpdateSalesRequestRequest $request, SalesRequest $salesRequest): JsonResponse
    {
        $this->authorize('update', $salesRequest);

        $salesRequest = $this->salesRequestService->update($salesRequest, $request->validated());

        return $this->response($salesRequest, __('messages.record_updated'));
    }

    public function show(SalesRequest $salesRequest): JsonResponse
    {
        $this->authorize('view', $salesRequest);

        return $this->response($salesRequest, __('messages.record_fetched'));
    }

    public function destroy(SalesRequest $salesRequest): JsonResponse
    {
        $this->authorize('delete', $salesRequest);

        $deleted = $this->salesRequestService->delete($salesRequest);

        return $this->response($deleted, __('messages.record_deleted'));
    }
}
