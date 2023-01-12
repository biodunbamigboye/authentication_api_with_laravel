<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentController extends Controller
{
    public function __construct(
        private readonly PaymentService $paymentService
    ) {
    }

    public function index(): JsonResponse
    {
        $payments = $this->paymentService->getAll();

        return $this->response($payments, __('messages.records_fetched'));
    }

    public function store(Request $request): JsonResponse
    {
        $payment = $this->paymentService->create($request->all());

        return $this->response($payment, __('messages.record_created'), Response::HTTP_CREATED);
    }

    public function show(Payment $payment): JsonResponse
    {
        return $this->response($payment, __('messages.record_fetched'));
    }
}
