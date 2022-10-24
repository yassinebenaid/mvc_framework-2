<?php

namespace Spoot\View;

use Spoot\View\Engine\Engine;

class View
{
    public string $path;
    public array $data = [];
    private Engine $engine;


    public function __construct(string $path, Engine $engine, array $data = [])
    {
        $this->path = realpath($path);
        $this->engine = $engine;
        $this->data = $data;
    }

    public function __toString()
    {
        return $this->engine->render($this);
    }
}
