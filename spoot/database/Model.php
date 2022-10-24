<?php

namespace Spoot\Database;

use Exception;
use ReflectionClass;

class Model
{
    public array $attributes;


    public function table(): string
    {
        $reflector = new ReflectionClass(static::class);

        foreach ($reflector->getAttributes() as $attr) {

            if ($attr->getName() == TableName::class) {
                return $attr->getArguments()[0];
            }
        }

        throw new Exception("table name does not defined ! you should use #[TableName(...)] to defne the table name");
    }

    protected function primaryKey(string|null $primaryKay = null)
    {
        if (!is_null($primaryKay)) $this->primaryKey = $primaryKay;

        if (!isset($this->primaryKey)) {
            $primary =  explode("\\", strtolower(static::class));
            $this->primaryKey = $primary[count($primary) - 1] . "_id";
        }

        return $this->primaryKey;
    }

    public static function find(int $id)
    {
        $model = new static();
        return self::Query()->where($model->primaryKey(), $id)->get();
    }

    public static function join(array $attributes): static
    {
        $model = new static();

        foreach ($attributes as $key => $value) {
            $model->{$key} = $value;
        }

        return $model;
    }

    public function hasOne(string $class, string $foriegnKey, string $primaryKey): mixed
    {
        $model = new $class;
        $query = $class::Query()->from($model->table())->where($foriegnKey, $this->{$primaryKey});

        return (new Relationship($query))->get();
    }

    public function hasMany(string $class, string $foriegnKey, string $primaryKey): mixed
    {
        $model = new $class;
        $query = $class::Query()->from($model->table())->where($foriegnKey, $this->{$primaryKey});

        return (new Relationship($query))->all();
    }

    public static function Query()
    {
        $model = new static();
        return (new ModelCollector(Mysql::Query(), static::class))->from($model->table());
    }

    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        }

        return $this->$name;
    }


    public static function __callStatic($name, $arguments)
    {
        return static::Query()->$name(...$arguments);
    }
}

/**
 * -- ReflectionClass => get infos about class whatever it is 
 * 
 * -- ReflectionClass->getAttributes() get all the attributes that have been used in the givven class
 * 
 * -- any class to be an attribute  must have an attribute of Attribute class
 * 
 * -- each attribute that got from getAttributes( ) method is an object from ReflectionAttribute class
 *    so that you can simply use getName() wich gives us the name of the attribute wich is a class
 * 
 * -- getArguments() method gives all the proprty values of each attribute whatever its name as array of array
 */
