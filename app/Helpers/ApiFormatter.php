<?php

namespace App\Helpers;

class ApiFormatter
{
    public static $response = [
        'code' => null,
        'message' => null,
        'data' => null
    ];

    public static function response($code = null, $message = null, $data = null)
    {
        self::$response['code'] = $code;
        self::$response['message'] = $message;
        self::$response['data'] = $data;

        return response(self::$response, self::$response['code']);
    }
}
