<?php

namespace Spoot\Database\Migration;

use Spoot\Database\Connection\Connection;
use Spoot\Database\Migration\Field\BoolField;
use Spoot\Database\Migration\Field\DateField;
use Spoot\Database\Migration\Field\Field;
use Spoot\Database\Migration\Field\FloatField;
use Spoot\Database\Migration\Field\IdField;
use Spoot\Database\Migration\Field\IntField;
use Spoot\Database\Migration\Field\TextField;
use Spoot\Database\Migration\Field\TimestampField;
use Spoot\Database\Migration\Field\VarcharField;

abstract class Migration
{

    protected array $fields = [];
    protected string $fieldsToBeAltered = "";
    protected string $action = "create";

    public function id(string $name): IdField
    {
        $new_name = $this->fieldsToBeAltered ? $this->fieldsToBeAltered : $name;
        return $this->fields[] = new IdField($name, $new_name, $this->action);
    }

    public function text(string $new_name): TextField
    {
        $name = $this->fieldsToBeAltered ? $this->fieldsToBeAltered : $new_name;
        return $this->fields[] = new TextField($name, $new_name, $this->action);
    }

    public function varchar(string $name, int $length): VarcharField
    {
        $the_name = $this->fieldsToBeAltered ??  $name;
        return $this->fields[] = new VarcharField($the_name, $length, $name, $this->action);
    }

    public function date(string $name): DateField
    {
        $the_name = $this->fieldsToBeAltered ??  $name;
        return $this->fields[] = new DateField($the_name, $name, $this->action);
    }

    public function int(string $name): IntField
    {
        $the_name = !empty($this->fieldsToBeAltered) ? $this->fieldsToBeAltered :  $name;
        return $this->fields[] = new IntField($the_name, $name, $this->action);
    }

    public function bool(string $name): BoolField
    {
        $the_name = $this->fieldsToBeAltered ??  $name;
        return $this->fields[] = new BoolField($the_name, $name, $this->action);
    }

    public function timestamp(string $name): TimestampField
    {
        $the_name = $this->fieldsToBeAltered ??  $name;
        return $this->fields[] = new TimestampField($the_name, $name, $this->action);
    }

    public function float(string $name): FloatField
    {
        $the_name = $this->fieldsToBeAltered ??  $name;
        return $this->fields[] = new FloatField($the_name, $name, $this->action);
    }

    // abstract public function connection(): Connection;
    abstract public function execute(): void;

    public function change(string $name): static
    {
        $this->action = "change";
        $this->fieldsToBeAltered = $name;
        return $this;
    }


    public function add(): static
    {
        $this->action = "add";
        return $this;
    }
}
