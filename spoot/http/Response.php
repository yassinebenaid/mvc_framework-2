<?php

namespace Spoot\Http;

use Throwable;

class Response
{
    public static function NotFound(?string $errorPage = null): ?string
    {
        http_response_code(404);
        if (is_null($errorPage)) {
            return "Not Found";
        }

        // todo: // view the error page
    }

    public static function NotAllowed(?string $errorPage = null): ?string
    {
        http_response_code(401);
        if (is_null($errorPage)) {
            return "Not Allowed";
        }

        // todo: // view the error page
    }

    public static function ServerError(Throwable $th, ?string $errorPage = null): ?string
    {
        http_response_code(500);

        if (is_null($errorPage)) {
            return "The server has been chocked ! : " .     $th->getMessage();
        }

        // todo: // view the error page
    }
}
