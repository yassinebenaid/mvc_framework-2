<?php

namespace Spoot\Database\Migration;

use Spoot\Database\Connection\MysqlConnection;
use Spoot\Database\Exception\MigrationException;

class MysqlMigration extends Migration
{
    public function __construct(
        protected MysqlConnection $connection,
        protected string $table,
        protected string $type,
        protected string $engine = "INNODB",
        protected string $cherset = "utf8"
    ) {
    }

    public function execute(): void
    {

        switch ($this->type) {
            case 'create':
                $this->create();
                return;
                break;

            case 'alter':
                $this->alter();
                return;
                break;

            case 'drop':
                $this->drop();
                return;
                break;
        }
    }

    private function create()
    {
        $fields = array_map(fn ($field) => $field->toString(), $this->fields);
        $fields = join(", ", $fields);

        $query = "CREATE TABLE IF NOT EXISTS {$this->table}( {$fields} ) ENGINE={$this->engine} DEFAULT CHARSET={$this->cherset};";

        $this->connection->pdo()->prepare($query)->execute();
    }

    private function drop()
    {

        $query = "DROP TABLE IF  EXISTS `{$this->table}`";
        $this->connection->pdo()->exec($query);
    }

    private function alter()
    {
        $fields = array_map(fn ($field) => $field->toString(), $this->fields);
        $fields = join(", ", $fields);

        $query = "ALTER TABLE {$this->table}  {$fields} ;";
        $this->connection->pdo()->prepare($query)->execute();
    }
}
