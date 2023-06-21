<?php

namespace App\Helpers;

class HttpStatus
{

    public static function getStatusCode()
    {
        return 'OK';
    }
    public static $CREATED = '201';
    public static $OK = '200';
    public static  $NO_CONTENT = '204';
    public static  $BAD_REQUEST = '400';
    public static  $UNAUTHORIZED = '401';
    public static  $FORBIDDEN = '403';
    public static  $NOT_FOUND = '404';
    public static  $METHOD_NOT_ALLOWED = '405';
    public static  $NOT_ACCEPTABLE = '406';
    public static  $CONFLICT = '409';
    public static  $LENGTH_REQUIRED = '411';
    public static  $PRECONDITION_FAILED = '412';
    public static  $REQUEST_ENTITY_TOO_LARGE = '413';
    public static  $UNSUPPORTED_MEDIA_TYPE = '415';
    public static  $REQUEST_URI_TOO_LONG = '414';
    public static  $REQUESTED_RANGE_NOT_SATISFIABLE = '416';
    public static  $EXPECTATION_FAILED = '417';
}
