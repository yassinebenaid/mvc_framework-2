<?php

namespace Spoot\Database;

use Attribute;
use Spoot\Database\Connection\MysqlConnection;
use Spoot\Database\QueryBuilder\MysqlQueryBuilder;

class Mysql
{
    private static ?Factory $factory = null;

    public static function Query(): MysqlQueryBuilder
    {
        return self::GetFactory()->query();
    }

    public static function CreateTable(string $name, string $engine = "INNODB", string $charset = "utf8")
    {
        return self::GetFactory()->createTable($name, $engine, $charset);
    }

    public static function AlterTable(string $name)
    {
        return self::GetFactory()->alterTable($name);
    }

    public static function DropTable(string $name)
    {
        self::GetFactory()->dropTable($name);
        return;
    }


    private static function GetFactory()
    {
        if (is_null(self::$factory)) {
            self::$factory = new Factory();
            self::$factory->addConnector("mysql", fn ($config) => new MysqlConnection($config));
        }

        $config = app("config")->get("database.mysql");
        return self::$factory->connect($config);
    }
}
