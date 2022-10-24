
<?php $this->extends("layouts.main", "content") ;?>

<main>
    <div class="top">
        <div class="container">
            <div class="logo">
                Spoot
            </div>
            <div class="header">
                <div class="caption">A place to buy rocket things</div>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/register">Register</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="under">
        <div class="container">
            <?php foreach($products as $product) : ?>
            <div class="roket">
                <div class="title">
                  <?php print  $product->product_name  ?>
                </div>
                <div class="description">
                    <?php print  $product->description  ?>
                </div>
                <a class="btn btn-primary" href="<?php print  $router->route('product-page',['product_id'=> $product->product_id])  ?>">Order</a> 
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>