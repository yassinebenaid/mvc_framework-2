<?php

namespace App\Controllers\User;

use App\Models\User;
use Spoot\Database\Mysql;
use Spoot\Http\Request;
use Spoot\Routing\Router;

class RegisterUserController
{
    public function __construct(
        private Router $router
    ) {
    }

    public function handle()
    {
        secure();

        $data = Request::body();

        $data = validate(
            $data,
            [
                "name" => ["required"],
                "email" => ["required", "email"],
                "password" => ["required", "min:10"],
            ]
        );

        User::insert(array_keys($data), array_values($data));

        $_SESSION["registered"] = true;

        return redirect($this->router->route("show-home-page"));
    }
}
