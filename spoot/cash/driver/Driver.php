<?php

namespace Spoot\Cash\Driver;

interface Driver
{
    /**
     * Tell if if a value is cashed 
     * @return bool true if the value for the givven key is cashed , and false otherwise
     */
    public function has(string $key): bool;

    /**
     * Get a cashed value
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * Put a value into the cache, for an optional number of seconds
     */
    public function put(string $key, mixed $value, int $seconds = null): static;
    /**
     * Remove a single cached value
     */
    public function forget(string $key): static;
    /**
     * Remove all cached values
     */
    public function reset(): static;
}
