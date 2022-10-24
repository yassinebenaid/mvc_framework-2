<?php

namespace Spoot\View;

use Closure;
use Exception;
use Spoot\View\Engine\Engine;

class Manager
{
    protected array $engines;
    protected array $paths;
    protected array $macros;

    public function addEngine(string $ext, Engine $engine): static
    {
        $this->engines[$ext] = $engine;
        $this->engines[$ext]->setManager($this);
        return $this;
    }

    public function addPath(string $path): static
    {
        $this->paths[] = $path;
        return $this;
    }

    public function resolve(string $page, array $data): View
    {
        foreach ($this->engines as $ext => $engine) {
            foreach ($this->paths as $path) {
                $file = "{$path}/{$page}.{$ext}";

                if (is_file($file)) {
                    return new View($file, $engine, $data);
                }
            }
        }

        throw new Exception("can't resolve $page , check the path or engine extension");
    }

    public function addMacro(string $name, Closure $callback): static
    {
        $this->macros[$name] = $callback;
        return $this;
    }

    public function useMacro(string $name, ...$parameters): mixed
    {
        if (!isset($this->macros[$name])) throw new Exception("macro $name is not defined !");

        $macro = $this->macros[$name]->bindTo($this);
        return $macro(...$parameters);
    }
}
