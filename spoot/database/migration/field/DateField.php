<?php

namespace Spoot\Database\Migration\Field;

class DateField extends Field
{
    public string|int $default;

    public function __construct(string $name, string $newName = "", string $action = "create")
    {
        parent::__construct($name);
        $this->type = "DATE";
        $this->action = $action;
        $this->newName = $newName ? $newName : $this->name;
    }

    public function default(string|int $default): static
    {
        $this->default = $default;
        return $this;
    }
}
