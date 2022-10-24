<?php

use Spoot\Database\Connection\Connection;
use Spoot\Database\Mysql;

class CreateProductPage
{
    public function migrate()
    {
        $table = Mysql::CreateTable('product');
        $table->id("product_id");
        $table->varchar("product_name", 255);
        $table->varchar("vendor", 255);
        $table->varchar("description", 255);
        $table->timestamp("created_at");
        $table->execute();
    }
}
