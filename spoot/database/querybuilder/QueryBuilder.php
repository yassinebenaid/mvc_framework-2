<?php

namespace Spoot\Database\QueryBuilder;

use PDOStatement;
use Spoot\Database\Connection\Connection;
use Spoot\Database\Exception\QueryException;

abstract class QueryBuilder
{
    protected string $type = "select";
    protected string $table;
    protected array $columns = ["*"];
    protected int    $limit;
    protected int    $offset;
    protected array  $conditions = [];
    protected array  $values;

    abstract public function connection(): Connection;

    public function prepare(): PDOStatement
    {
        $query = "";

        if ($this->type === 'select') {
            $query = $this->compileSelect($query);
            $query = $this->compileLimit($query);
        } elseif ($this->type === "insert") {
            $query .= $this->compileInsert($query);
        } elseif ($this->type === "update") {
            $query .= $this->compileUpdate($query);
        } elseif ($this->type === "delete") {
            $query .= $this->compileDelete($query);
        }

        if (empty($query))   throw new QueryException("unrocugnize query type !");

        return $this->connection()->pdo()->prepare($query);
    }

    public function compileUpdate(string $query): string
    {
        $conditions = count($this->conditions) > 0 ? "WHERE " . join(" AND ", $this->conditions) : "";
        $placeholder = array_map(fn ($v) => "$v = :$v", array_keys($this->values));
        $placeholder = join(",", $placeholder);

        $query .= "UPDATE {$this->table} SET {$placeholder} {$conditions}";
        return $query;
    }

    public function compileDelete(string $query): string
    {
        $conditions = count($this->conditions) > 0 ? "WHERE " . join(" AND ", $this->conditions) : "";

        $query .= "DELETE FROM {$this->table} {$conditions}";
        return $query;
    }

    public function compileSelect(string $query): string
    {
        $columns =  implode(", ", $this->columns);
        $conditions = count($this->conditions) > 0 ? "WHERE " . join(" AND ", $this->conditions) : "";
        $query .= "SELECT {$columns} FROM {$this->table} {$conditions}";
        return $query;
    }

    public function compileInsert(string $query): string
    {
        $placeholder = implode(",", array_map(fn ($v) => ":$v", $this->columns));
        $columns =  implode(", ", $this->columns);
        $query .= "INSERT INTO {$this->table} ({$columns}) VALUES( {$placeholder})";
        return $query;
    }


    public function compileLimit(string $query): string
    {
        if (isset($this->limit)) $query .= " LIMIT {$this->limit} ";
        if (isset($this->offset)) $query .= " OFFSET  {$this->offset} ";
        return $query;
    }

    public function first(): array
    {
        $statment = $this->take(1)->prepare();
        $statment->execute();
        return $statment->fetch(\PDO::FETCH_ASSOC);
    }

    public function all(): array
    {
        $statment = $this->prepare();
        $statment->execute();

        return $statment->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function get(): array
    {
        $statment = $this->prepare();
        $statment->execute();

        return $statment->fetch(\PDO::FETCH_ASSOC);
    }

    public function getColumn()
    {
        $statment = $this->prepare();
        $statment->execute();
        return $statment->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function take(int $limit, int $offset = 0): static
    {
        $this->limit = $limit;
        $this->offset = $offset;
        return $this;
    }


    public function from(string $table_name): static
    {
        $this->table = $table_name;
        return $this;
    }

    public function where(string $column, $value, string $operator = "="): static
    {
        $this->conditions[] = "$column  $operator $value";
        return $this;
    }

    public function select($column = "*", ...$columns): static
    {
        $this->type = "select";
        $this->columns = [$column, ...$columns];

        return $this;
    }

    public function update(string $column, $value): static
    {
        $this->type = "update";
        $this->values[$column] = $value;

        $statment = $this->prepare();
        $statment = $statment->execute($this->values);

        return $this;
    }

    public function delete(): static
    {
        $this->type = "delete";

        $statment = $this->prepare();
        $statment = $statment->execute();

        return $this;
    }

    public function insert(array $columns, array $values): static
    {
        $this->type = "insert";
        $this->columns = $columns;
        $this->values = $values;

        $statment = $this->prepare();

        $columns = array_map(fn ($v) => ":$v", $columns);
        $values = array_combine($columns, $values);



        $statment->execute($values);
        return $this;
    }
}
