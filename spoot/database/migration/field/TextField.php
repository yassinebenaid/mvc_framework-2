<?php

namespace Spoot\Database\Migration\Field;

class TextField extends Field
{
    public string $default;

    public function __construct(string $name, string $newName = "", string $action = "create")
    {
        parent::__construct($name);
        $this->type = "TEXT";
        $this->newName = $newName ? $newName : $this->name;
        $this->action = $action;
    }

    public function default(string $default): static
    {
        $this->default = "'" . $default . "'";
        return $this;
    }
}
