<?php

namespace Spoot\Database\Migration\Field;

class BoolField extends Field
{
    public bool $default;

    public function __construct(string $name, string $newName = "", string $action = "create")
    {
        parent::__construct($name);
        $this->type = "BOOLEAN";
        $this->newName = $newName ? $newName : $this->name;
    }

    public function default(bool $default): static
    {
        $this->default = $default ? "TRUE" : "FALSE";
        return $this;
    }
}
