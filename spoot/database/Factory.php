<?php

namespace Spoot\Database;

use Closure;
use Spoot\Database\Connection\Connection;
use Spoot\Database\Exception\ConnectionException;

class Factory
{
    protected array $connectors  = [];

    public function addConnector(string $alias, Closure $connector): static
    {
        $this->connectors[$alias] = $connector;
        return $this;
    }

    public function connect(array $config): Connection
    {
        if (!isset($config["type"])) throw new ConnectionException("type is not defined ! ");

        $type = $config["type"];

        if (isset($this->connectors[$type])) return $this->connectors[$type]($config);

        throw new ConnectionException("type $type is not recognized !");
    }
}
