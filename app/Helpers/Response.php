<?php

namespace App\Helpers;

use App\Helpers\HttpStatus;


class Response
{

    public static function success($payload, $message = null, $statusCode)
    {
        $datas = [
            "success" => true,
            "statusCode" => $statusCode,
            "message" => $message,
            "data" => $payload
        ];

        return response()->json($datas);
    }

    public static function error($message = null, $statusCode)
    {
        $datas = [
            "success" => false,
            "statusCode" => $statusCode,
            "error" => $message
        ];

        return response()->json($datas);
    }
}
