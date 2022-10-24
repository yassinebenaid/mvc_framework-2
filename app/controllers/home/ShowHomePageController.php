<?php

namespace App\controllers\Home;

use App\Models\Product;
use Spoot\Database\Connection\MysqlConnection;
use Spoot\Database\Factory;
use Spoot\Routing\Router;

class ShowHomePageController
{
    public function __construct(private Router $router)
    {
    }


    public function handle()
    {
        $products = Product::all();

        $data  = [
            "title" => "Home",
            "router" => $this->router,
            "products" => $products
        ];

        return view('home.home', $data);
    }

    protected function MakeConnection()
    {
        $factory = new Factory();
        $factory->addConnector("mysql", fn ($config) => new MysqlConnection($config));
        $config = require dirname(__DIR__, 3) . "/config/database.php";
        $connection = $factory->connect($config[$config["default"]]);
        return $connection;
    }
}
