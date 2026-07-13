<?php

namespace App\Helpers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ApiResponse
{
    public static function success($data = null, string $message = 'Success', ?LengthAwarePaginator $pagination = null, int $status = 200)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data,
        ];

        if ($pagination) {
            $response['meta'] = [
                'current_page' => $pagination->currentPage(),
                'last_page' => $pagination->lastPage(),
                'per_page' => $pagination->perPage(),
                'total' => $pagination->total(),
            ];
        }

        return response()->json($response, $status);
    }

    public static function created($data = null, string $message = 'Created successfully')
    {
        return self::success($data, $message, null, 201);
    }

    public static function deleted(string $message = 'Deleted successfully')
    {
        return response()->json([
            'success' => true,
            'message' => $message,
        ], 200);
    }

    public static function error(string $message = 'Something went wrong', int $status = 500, $errors = null)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }
}