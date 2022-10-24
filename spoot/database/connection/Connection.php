<?php

namespace Spoot\Database\Connection;

use PDO;
use Spoot\Database\Migration\Migration;
use Spoot\Database\QueryBuilder\QueryBuilder;

abstract class Connection
{
    abstract public function pdo(): PDO;
    abstract public function query(): QueryBuilder;
    abstract public function createTable(string $table, string $engine = "INNODB", string $charset = "utf8"): Migration;
    abstract public function alterTable(string $table): Migration;
    abstract public function dropTable(string $table): void;
}
