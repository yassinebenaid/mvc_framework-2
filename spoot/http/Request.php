<?php

namespace Spoot\Http;

class Request
{
    public static function path(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? "/";
        $queryMarck = strpos($path, "?");

        // if url contains parameters we need to delete them to get just the uri that we need
        if ($queryMarck) $path = substr($path, 0, $queryMarck);

        return $path;
    }

    public static function method(): string
    {
        return strtolower($_SERVER["REQUEST_METHOD"]) ?? "get";
    }

    public static function body(): array
    {
        $body = [];

        switch (self::method()) {
            case "get":
                foreach ($_GET as $key => $value) {
                    $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
                break;
            case 'post':
                foreach ($_POST as $key => $value) {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
                break;
        }

        return $body;
    }


    public static function postItem(string $name)
    {
        $body = self::body();
        return $body[$name] ?? false;
    }
}
