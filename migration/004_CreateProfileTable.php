<?php

use Spoot\Database\Mysql;

class CreateProfileTable
{
    public function migrate()
    {
        $table = Mysql::CreateTable('profile');
        $table->id("profile_id");
        $table->varchar("moroccan_address", 255);
        $table->varchar("american_adess", 255);
        $table->execute();
    }
}
