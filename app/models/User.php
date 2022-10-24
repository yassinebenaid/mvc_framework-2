<?php

namespace App\Models;

use Spoot\Database\Model;
use Spoot\Database\Mysql;
use Spoot\Database\TableName;

#[TableName('users')]
class User extends Model
{
    public function profile()
    {
        return ($this->hasOne(Profile::class, "user_id", "user_id"));
    }

    public function orders()
    {
        return ($this->hasMany(Orders::class, "client_id", "user_id"));
    }
}
