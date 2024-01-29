<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponse
{
    protected function successResponse($data, $message = null, $code = Response::HTTP_OK, array $flags = []): JsonResponse
    {
        $response = [
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ];

        return response()->json(array_merge($flags, $response), $code);
    }

    protected function errorResponse($code, $message = null, $data = []): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
