<?php

namespace Spoot\Cash;

use Closure;
use Spoot\Cash\Driver\Driver;
use Spoot\Cash\Driver\DriverException;

class Factory
{
    protected array $drivers = [];

    public function addDriver(string $alias, Closure $driver): static
    {
        $this->drivers[$alias] = $driver;
        return $this;
    }

    public function connect(array $config): Driver
    {
        if (!isset($config["type"])) {
            throw new DriverException("type isn't defined !");
        }
        $type = $config["type"];

        if (isset($this->drivers[$type])) {
            return $this->drivers[$type]($config);
        }

        throw new DriverException("unrocognized type !");
    }
}
