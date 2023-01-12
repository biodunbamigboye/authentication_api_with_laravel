<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait CustomResponse
{
    protected function response(mixed $data = null, string $message = '', int $code = null, array $headers = [], $log = null): JsonResponse|Response
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
        ], $code ?? Response::HTTP_OK, $headers);
    }

    protected function reject(mixed $data = null, string $message = '', int $code = null, array $headers = []): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
        ], $code ?? Response::HTTP_UNAUTHORIZED, $headers);
    }

    protected function validationErrorResponse(array $errors, $message): JsonResponse
    {
        return response()->json([
            'data' => $errors,
            'message' => $message,
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
