<?php

use Spoot\Application;
use Spoot\Http\Request;


if (!function_exists("app")) {
    function app(string|null $alias = null)
    {
        if (is_null($alias)) return Application::GetInstance();

        return Application::GetInstance()->resolve($alias);
    }
}

if (!function_exists("view")) {
    function view(string $page, array $data = [])
    {
        $page = str_replace(".", "/", $page);
        return app("view")->resolve($page, $data);
    }
}


if (!function_exists("redirect")) {
    function redirect(string $url, int $statusCode = 0)
    {
        header("Location: {$url}", true, $statusCode);
        exit;
    }
}


if (!function_exists("validate")) {
    function validate(array $data, array $rules)
    {
        return app("validate")->validate($data, $rules);
    }
}


if (!function_exists("csrf")) {
    function csrf()
    {
        $_SESSION["token"] = bin2hex(random_bytes(32));
        return $_SESSION["token"];
    }
}

if (!function_exists("secure")) {
    function secure()
    {
        $sessionToken = $_SESSION["token"];
        $postToken = Request::postItem("token");

        if (!isset($sessionToken) || !$postToken || !hash_equals($sessionToken, $postToken)) {
            throw new Exception("csrf error, missed token");
        }
    }
}


if (!function_exists("Root")) {
    /**
     * @return string The Root directory for the project  
     */
    function Root()
    {
        static $root;

        if (!$root) {
            $root = app("path.base");
        }

        return $root;
    }
}
