<?php

namespace Spoot\Database\Migration\Field;

abstract class Field
{
    public bool $nullable = false;
    public string $type = "";

    public function __construct(string $name, string $newName = "", string $action = "create")
    {
        $this->name = $name;
        $this->newName = $newName ? $newName : $this->name;
        $this->action = $action;
    }

    public function nullable(): static
    {
        $this->nullable = true;
        return $this;
    }

    public function toString()
    {
        switch ($this->action) {
            case "create":
                $name = $this->name;
                $type = $this->type;
                $nullable = $this->nullable ? " NULL" : "NOT NULL";
                $default = isset($this->default) ? "DEFAULT {$this->default}"  : "";

                return "{$name} {$type} {$nullable} {$default}";
                break;

            case "change":
                echo "changing...";
                $type = $this->type;
                $name = $this->name;
                $newName = $this->newName;
                $nullable = $this->nullable ? " NULL" : "NOT NULL";
                $default = isset($this->default) ? "DEFAULT {$this->default}"  : "";

                return "CHANGE {$name} {$newName} {$type} {$nullable} {$default}";
                break;

            case "add":
                $type = $this->type;
                $name = $this->name;
                $nullable = $this->nullable ? " NULL" : "NOT NULL";
                $default = isset($this->default) ? "DEFAULT {$this->default}"  : "";

                return "ADD COLUMN {$name} {$type} {$nullable} {$default}";
                break;
        }
    }
}
