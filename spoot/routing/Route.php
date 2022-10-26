<?php

namespace Spoot\Routing;

class Route
{
    private array $paramates;
    protected string $name;


    public function __construct(
        protected string $method,
        protected string $path,
        protected $callback
    ) {
    }


    public function path(): string
    {
        return $this->path;
    }


    public function method(): string
    {
        return $this->method;
    }

    public function parameters(): array
    {
        return $this->parameters;
    }

    public function name(?string $name = null): string
    {
        if (!is_null($name)) {
            $this->name = $name;
        }

        return $this->name ?? "";
    }


    public function run()
    {
        // return call_user_func($this->callback);
        return app()->call($this->callback);
    }



    public function isMatching(string $url, string $method): bool
    {
        if ($this->method === $method && $this->path === $url) return true;

        // if the method is not correct , no need to keep proccessing
        if ($this->method !== $method) return false;

        $parameterNames = [];

        // normalize the path to simply change it to regex without problems 
        $pathToBeRegEx = $this->normalizePath($this->path);

        // convert the path to regex pattern ,hence, we can simply compair the givven url e.g "product/452" => "product/([^/]+)"
        $requiredPattern = preg_replace_callback(
            "#\{([^}]+)}/#",

            function (array $matches) use (&$parameterNames) {

                // we may have something like /product/{product_id:\d}/ so we need to get only the name
                $matches = explode(":", $matches[1]);
                $parameterNames[] = rtrim($matches[0], "?");

                if (str_ends_with($matches[0], "?")) {
                    return "([" . ($matches[1] ?? "^/") . "]*)(?:/?)";
                }

                return "([" . ($matches[1] ?? "^/") . "]+)/";
            },
            $pathToBeRegEx
        );

        // if the route  do not have any required or optional params , breack up
        if (!str_contains($requiredPattern, "+") && !str_contains($requiredPattern, "*")) return false;


        // match the request url with the local path pattern
        preg_match_all("#{$requiredPattern}$#", $this->normalizePath($url), $matches);

        // the matches actually is an array of muli arrays, so we need to merge the as a single array
        $matches = array_merge(...array_values($matches));


        // check if the parameters are exists and not empty, as well as avoid the first element which is the full pattern : use print_r() to see 
        $matches = array_filter($matches, fn ($v) => !empty($v));
        unset($matches[0]);

        $parameterValues = [];

        if ($matches) {
            $parameterValues = $matches;

            // we need to fill the unsetted keys so that we can still use array combine even if the optional params wasn't provided
            $parameterValues += array_fill(1, count($parameterNames), null);

            $this->parameters = array_combine($parameterNames, $parameterValues);

            return true;
        }


        return false;
    }


    protected function normalizePath(string $path): string
    {
        $path = trim($path, "/");
        $path = "/{$path}/";

        // to avoid duplicate slashes
        $path = preg_replace("#([\/]{2,})#", "/", $path);

        return $path;
    }
}
