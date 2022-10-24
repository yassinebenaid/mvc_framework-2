<?php

namespace Spoot\Routing;

use Exception;
use InvalidArgumentException;
use SplObjectStorage;
use Spoot\Http\Request;
use Spoot\Http\Response;
use Spoot\Validation\ValidationException;

class Router
{
    protected SplObjectStorage $routes;
    protected array $errors;
    private Route $currentRoute;

    public function __construct()
    {
        $this->routes = new SplObjectStorage;
    }


    public function onGet(string $path, callable $callback): Route
    {
        $route = new Route("get", $path, $callback);
        $this->routes->attach($route);
        return $route;
    }


    public function onPost(string $path, callable $callback): Route
    {
        $route  =  new Route("post", $path, $callback);
        $this->routes->attach($route);
        return $route;
    }


    public function currentRoute(): ?Route
    {
        return $this->currentRoute;
    }


    public function dispatch()
    {
        $path =  Request::path();
        $method = Request::method();

        // check if the request rout is matching any of our routes
        $matchedRoute = $this->match($path, $method);

        if ($matchedRoute) {
            try {
                $this->currentRoute = $matchedRoute;
                return $matchedRoute->run();
            } catch (\Throwable $th) {
                if ($th instanceof ValidationException) {
                    $_SESSION["errors"] = $th->getErrors();
                    return redirect($_SERVER["HTTP_REFERER"]);
                }
                throw $th;
                return Response::ServerError($th);
            }
        }

        // check if there is a similar route with a diffirent method
        $paths  = $this->getAllPaths();
        if (in_array($path, $paths)) return Response::NotAllowed();

        // otherwise if no route was matched
        return Response::NotFound();
    }


    protected function match(string $path, string $method): ?Route
    {
        foreach ($this->routes as $route) {
            if ($route->isMatching($path, $method)) {

                /**
                 * @var Route $route
                 */
                return $route;
            }
        }

        return null;
    }

    protected function getAllPaths(): array
    {
        $paths = [];

        foreach ($this->routes as $route) {
            $paths[] = $route->path();
        }

        return $paths;
    }

    public function route(string $name, array $params = []): string
    {
        $routePath = "";

        foreach ($this->routes as $route) {
            if ($route->name() === $name) {

                $routePath =  $route->path();

                foreach ($params as $key => $value) {
                    $routePath = preg_replace("#\{($key)([^}]*)}#", $value, $routePath);
                }

                // if there is non provided required parameters throw an error
                if (preg_match("#\{([^?}]+)}#", $routePath)) {
                    throw new InvalidArgumentException("missed required parameters");
                }

                // ignore non provided optional parameters
                $routePath = preg_replace("#\{([^}]+)}#", "", $routePath);

                return preg_replace("#([/]{2,})#", "/", $routePath);
            }
        }

        throw new Exception("route does not exists \"$name\"");
    }
}
