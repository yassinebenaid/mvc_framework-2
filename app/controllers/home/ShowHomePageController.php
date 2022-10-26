<?php

namespace App\controllers\Home;

use App\Models\Product;
use Spoot\Routing\Router;

class ShowHomePageController
{

    public function handle(Router $router)
    {
        $products = Product::all();

        $data  = [
            "title" => "Home",
            "router" => $router,
            "products" => $products
        ];

        return view('home.home', $data);
    }
}
