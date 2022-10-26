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
        $router = $this->resolve("router");
        $routes = require_once Root() . "/app/routes.php";
        $routes($router);

        print $router->dispatch();
    }

    public function call(callable|array $callback, array $params = [])
    {
        $reflector = $this->GetReflector($callback);

        $dependencies = [];

        foreach ($reflector->getParameters() as $parameter) {
            $name = $parameter->getName();
            $type = $parameter->getType();


            if (isset($params[$name])) {
                $dependencies[$name] = $params[$name];
                continue;
            }

            if ($parameter->isDefaultValueAvailable()) {
                $dependencies[$name] = $parameter->getDefaultValue();
                continue;
            }

            if ($type instanceof ReflectionNamedType) {
                $dependencies[$name] = $this->resolve($name);
                continue;
            }

            throw new InvalidArgumentException($reflector->getName() . " accept " . count($reflector->getParameters()) . " arguments, $name is not defined !");
        }


        return call_user_func($callback, ...$dependencies);
    }

    private function getReflector(array|callable $callback)
    {
        if (is_array($callback)) return new ReflectionMethod($callback[0], $callback[1]);
        return new ReflectionFunction($callback);
    }

    private function __construct()
    {
        parent::__construct();
    }
    private function __clone()
    {
    }
}
