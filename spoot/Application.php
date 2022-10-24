<?php

namespace Spoot;

use Dotenv\Dotenv;
use InvalidArgumentException;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionNamedType;
use Spoot\Routing\Router;

class Application extends Container
{
    private static ?Application $instance = null;

    public static function GetInstance(): static
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function run()
    {
        session_start();

        $rootPath = $this->resolve("path.base");

        $this->configure($rootPath);
        $this->bindProviders($rootPath);
        $this->dispatch($rootPath);
    }

    private function configure(string $rootPath)
    {
        (Dotenv::createImmutable($rootPath))->load();
    }

    private function bindProviders(string $rootPath)
    {
        $providers = require_once $rootPath . "/config/providers.php";

        foreach ($providers as $provider) {
            $instance = new $provider();

            if (method_exists($instance, "bind")) {
                $instance->bind($this);
            }
        }
    }

    private function dispatch(string $rootPath)
    {
        $router = new Router;
        $routes = require_once Root() . "/app/routes.php";
        $routes($router);

        print $router->dispatch();
    }


    private function __construct()
    {
    }
    private function __clone()
    {
    }
}
