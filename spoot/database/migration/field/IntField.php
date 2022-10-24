<?php

namespace Spoot\Database\Migration\Field;

class IntField extends Field
{
    public int $default;

    public function __construct(string $name, string $newName = "", string $action = "create")
    {
        parent::__construct($name);
        $this->type = "INT";
        $this->newName = $newName ? $newName : $this->name;
        $this->action = $action;
    }

    public function default(int $default): static
    {
        $this->default = $default;
        return $this;
    }
}
