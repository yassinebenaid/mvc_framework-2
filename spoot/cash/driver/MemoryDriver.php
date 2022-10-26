<?php

namespace Spoot\Cash\Driver;

class MemoryDriver implements Driver
{
    private array $config = [];
    private array $cashed = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function has(string $key): bool
    {
        return isset($this->cashed[$key]) && $this->cashed[$key]["expired"] > time();
    }

    public function get(string $key, mixed $default = null): mixed
    {
        if ($this->has($key)) return $this->cashed[$key]["value"];
        return $default;
    }

    public function put(string $key, mixed $value, ?int $seconds = null): static
    {
        $seconds = is_int($seconds) ? $seconds : (int)$this->config["seconds"];

        $this->cashed[$key] = [
            "value" => $value,
            "expired" => time() +  $seconds
        ];
        return $this;
    }

    public function forget(string $key): static
    {
        unset($this->cashed[$key]);
        return $this;
    }

    public function reset(): static
    {
        $this->cashed = [];
        return $this;
    }
}
