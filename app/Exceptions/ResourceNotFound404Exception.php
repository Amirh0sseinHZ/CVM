<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ResourceNotFound404Exception extends Exception
{
    /**
     * Render the exception into an JSON response.
     *
     * @return JsonResponse
     */
    public function render()
    {
        return response()->json([
            "message" => "The requested resource was not found."
        ], 404);
    }
}
