<?php

use App\controllers\Home\ShowHomePageController;
use App\Controllers\Product\ShowProductPage;
use App\Controllers\User\RegisterUserController;
use App\Controllers\User\ShowRegisterFormController;
use Spoot\Routing\Router;

return function (Router $router) {
    $router->onGet("/", [new ShowHomePageController($router), "handle"])->name("show-home-page");
    $router->onGet("/product/{product_id:\d}/", [new ShowProductPage($router), "handle"])->name("product-page");
    $router->onGet("/register", [new ShowRegisterFormController($router), "handle"])->name("show-register-form");
    $router->onPost("/register", [new RegisterUserController($router), "handle"])->name("register-user");
};
