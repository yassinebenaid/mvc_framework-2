<?php

namespace Spoot\Database\Migration\Field;

use Spoot\Database\Exception\MigrationException;

class IdField extends Field
{
    public function default()
    {
        throw new MigrationException("ID fields can't have default value !");
    }

    public function toString()
    {
        return "{$this->name} INT AUTO_INCREMENT PRIMARY KEY";
    }


    public function toAlterString()
    {
        $name = $this->name;
        $newName = $this->newName;
        return "CHANGE {$name} {$newName} INT AUTO_INCREMENT PRIMARY KEY";
    }
}
