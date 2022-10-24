<?php

namespace Spoot\Database;

class Relationship
{
    public function __construct(
        public ModelCollector $collector
    ) {
    }

    public function __call(string $method, $parameters)
    {
        return $this->collector->$method(...$parameters);
    }
}
