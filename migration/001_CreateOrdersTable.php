<?php

use Spoot\Database\Connection\Connection;
use Spoot\Database\Mysql;

class CreateOrdersTable
{
    public function migrate()
    {
        $table = Mysql::CreateTable('orders');
        $table->id('id');
        $table->int('quantity')->default(1);
        $table->float('price')->nullable();
        $table->bool('is_confirmed')->default(false);
        $table->timestamp('ordered_at');
        $table->text('notes');

        $table->execute();
    }
}
