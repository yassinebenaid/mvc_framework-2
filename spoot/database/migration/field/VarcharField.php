<?php

namespace Spoot\Database\Migration\Field;

class VarcharField extends Field
{
    public string $default;

    public function __construct(string $name, int $lenght = 255, string $newName = "", string $action = "create")
    {
        parent::__construct($name);
        $this->type = "VARCHAR({$lenght})";
        $this->newName = $newName ? $newName : $this->name;
        $this->action = $action;
    }

    public function default(string $default): static
    {
        $this->default = $default;
        return $this;
    }
}
