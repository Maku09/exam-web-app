<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait HttpResponses
{

    protected function success($data, $message = 'Data retrieved successfully!', $code = Response::HTTP_OK)
    {
        return response()->json([
            'status' => 'Success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function error($data, $message = null, $code)
    {
        return response()->json([
            'status' => 'Error',
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}