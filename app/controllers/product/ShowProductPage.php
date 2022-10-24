<?php

namespace App\Controllers\Product;

use App\Models\Product;
use Spoot\Database\Connection\MysqlConnection;
use Spoot\Database\Factory;
use Spoot\Database\Mysql;
use Spoot\Routing\Router;

class ShowProductPage
{
    public function __construct(private Router $router)
    {
    }


    public function handle()
    {
        $product_id = $this->router->currentRoute()->parameters()["product_id"];
        $product = Product::find($product_id);

        $data  = [
            "title" => "Product - {$product->product_name}",
            "router" => $this->router,
            "product" => $product
        ];

        return view('product.product', $data);
    }
}
