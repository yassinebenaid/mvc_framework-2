<?php

namespace Spoot\Database\Migration\Field;

use Spoot\Database\Exception\MigrationException;

class TimestampField extends Field
{
    public string|int $default;

    public function __construct(string $name, string $newName = "", string $action = "create")
    {
        parent::__construct($name);
        $this->newName = $newName ? $newName : $this->name;
        $this->action = $action;
    }

    public function toString()
    {
        switch ($this->action) {
            case "create":
                $name = $this->name;
                return "{$name} TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
                break;

            case "change":
                $type = $this->type;
                $name = $this->name;
                $newName = $this->newName;
                $nullable = $this->nullable ? " NULL" : "NOT NULL";
                $default = isset($this->default) ? "DEFAULT {$this->default}"  : "";

                return "CHANGE {$name} {$newName} TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
                break;

            case "add":
                $type = $this->type;
                $name = $this->name;
                $nullable = $this->nullable ? " NULL" : "NOT NULL";
                $default = isset($this->default) ? "DEFAULT {$this->default}"  : "";

                return "ADD {$name} TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
                break;
        }
    }

    public function default(): static
    {
        throw new MigrationException("time stap field can't have default value");
        return $this;
    }

    public function nullable(): static
    {
        throw new MigrationException("timestap field can't be null");
        return $this;
    }
}
