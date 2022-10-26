<?php

namespace Spoot;

use Dotenv\Exception\InvalidFileException;
use InvalidArgumentException;
use Spoot\Routing\Router;

class Container
{
    private array $binding = [];
    private array $resolved = [];

    public function __construct()
    {
        $this->bind("router", fn () => new Router);
    }

    public function bind(string $alias, callable $callback): static
    {
        $this->binding[$alias] = $callback;
        $this->resolved[$alias] = null;
        return $this;
    }

    public function resolve(string $alias): mixed
    {
        if (!isset($this->binding[$alias])) throw new InvalidArgumentException("$alias was not bound");

        if (is_null($this->resolved[$alias])) {
            $this->resolved[$alias] = call_user_func($this->binding[$alias]);
        }

        return $this->resolved[$alias];
    }
}
