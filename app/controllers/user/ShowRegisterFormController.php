<?php

namespace App\Controllers\User;

use Spoot\Routing\Router;

class ShowRegisterFormController
{
    public function __construct(
        private Router $router
    ) {
    }


    public function handle()
    {
        $data = [
            "csrfToken" => csrf(),
            "router" => $this->router,
            "errors" => ($_SESSION["errors"] ?? []),
            "title" => "Register"
        ];
        return view("user.register", $data);
    }
}
