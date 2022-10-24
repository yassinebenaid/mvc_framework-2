<?php

namespace Spoot\Database\Connection;

use InvalidArgumentException;
use PDO;
use Spoot\Database\Migration\Migration;
use Spoot\Database\Migration\MysqlMigration;
use Spoot\Database\QueryBuilder\MysqlQueryBuilder;
use Spoot\Database\QueryBuilder\QueryBuilder;

class MysqlConnection extends Connection
{
    private static ?PDO $pdo =  null;

    public function __construct(array $config)
    {
        [
            "host" => $host,
            "port" => $port,
            "username" => $username,
            "password" => $password,
            "database" => $database,

        ] = $config;

        if (empty($host) || empty($username) || empty($database)) throw new InvalidArgumentException("missed connection configuration to mysql !");

        if (is_null(self::$pdo)) {
            self::$pdo = new PDO("mysql:host={$host};dbname={$database};port={$port}", $username, $password);
        }
    }


    public function pdo(): PDO
    {
        return self::$pdo;
    }


    public function query(): QueryBuilder
    {
        return new MysqlQueryBuilder($this);
    }

    public function createTable(string $table, string $engine = "INNODB", string $charset = "utf8"): Migration
    {
        return  new MysqlMigration($this, $table, "create", $engine, $charset);
    }

    public function alterTable(string $table): Migration
    {
        return  new MysqlMigration($this, $table, "alter");
    }

    public function dropTable(string $table): void
    {
        $table = new MysqlMigration($this, $table, "drop");
        $table->execute();
        return;
    }
}
