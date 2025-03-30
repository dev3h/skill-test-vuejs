<?php

namespace App\Http\Controllers;
use App\Helpers\ResponseHelper;


abstract class Controller
{
    public function sendSuccessResponse(mixed $data, string $message = '', int $code = 200)
    {
        return ResponseHelper::sendSuccessResponse($data, $message, $code);
    }

    public function sendErrorResponse(string $message, mixed $errors = null, int $code = 500)
    {
        return ResponseHelper::sendErrorResponse($message, $errors, $code);
    }
}
