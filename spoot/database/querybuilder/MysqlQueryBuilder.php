<?php

namespace Spoot\Database\QueryBuilder;

use Spoot\Database\Connection\Connection;
use Spoot\Database\Connection\MysqlConnection;

class MysqlQueryBuilder extends QueryBuilder
{
    protected MysqlConnection $connection;

    public function __construct(MysqlConnection $connection)
    {
        $this->connection = $connection;
    }


    public function connection(): Connection
    {
        return $this->connection;
    }
}
