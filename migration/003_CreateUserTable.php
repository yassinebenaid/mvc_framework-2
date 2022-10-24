<?php

use Spoot\Database\Mysql;

class CreateUserTable
{
    public function migrate()
    {
        $table = Mysql::CreateTable('users');
        $table->id("user_id");
        $table->varchar("name", 255);
        $table->varchar("email", 255);
        $table->varchar("password", 255);
        $table->execute();
    }
}
