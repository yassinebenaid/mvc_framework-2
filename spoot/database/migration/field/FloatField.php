<?php


namespace Spoot\Database\Migration\Field;

class FloatField extends Field
{
    public float $default;

    public function __construct(string $name, string $newName = "", string $action = "create")
    {
        parent::__construct($name);
        $this->type = "FLOAT";
        $this->newName = $newName ? $newName : $this->name;
        $this->action = $action;
    }

    public function default(float $default): static
    {
        $this->default = $default;
        return $this;
    }
}
