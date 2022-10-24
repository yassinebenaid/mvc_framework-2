<?php

namespace Spoot\Database;

use Spoot\Database\QueryBuilder\QueryBuilder;

class ModelCollector
{
    public function __construct(
        private QueryBuilder $builder,
        private string $class
    ) {
    }

    public function __call($name, $arguments)
    {
        $result =  $this->builder->$name(...$arguments);

        if ($result instanceof QueryBuilder) {
            $this->builder = $result;
            return $this;
        }

        return $result;
    }

    public function all()
    {
        $rows = $this->builder->all();

        foreach ($rows as $i => $row) {
            $rows[$i] = $this->class::join($row);
        }

        return $rows;
    }

    public function get()
    {
        $row = $this->builder->get();

        $row = is_null($row) ?: $this->class::join($row);

        return $row;
    }
}
