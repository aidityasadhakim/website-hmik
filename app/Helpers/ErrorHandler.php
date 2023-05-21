<?php

namespace App\Helpers;

class ErrorHandler
{
    public function notAuthenticated()
    {
        return Response::error("Not Authenticated", HttpStatus::$FORBIDDEN);
    }
}
