<?php

namespace Spoot\Provider;

use Spoot\Application;
use Spoot\Cash\Driver\MemoryDriver;
use Spoot\Cash\Factory;

class CashProvider
{
    public function bind(Application $app)
    {
        $app->bind("cash", function () use ($app) {
            $factory = new Factory;
            $this->addMemoryDriver($factory);
            $config = app("config")->get("cash.memory");
            return $factory->connect($config);
        });
    }

    private function addMemoryDriver(Factory $factory)
    {
        $factory->addDriver("memory", fn ($config) => new MemoryDriver($config));
    }
}
