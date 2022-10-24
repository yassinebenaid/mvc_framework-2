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
            <div class="roket">
                <div class="title">
                  <?php print  $product->product_name  ?>
                </div>
                <div class="description">
                    <?php print $product->description ?>
                </div>
                <form href="<?php print $router->route('product-page',['product_id'=> $product->product_id]) ?>" class="m-5">
                    <input class="py-2" type="number" name="product_count" id="product_count" placeholder="how many product you want">
                    <a class="btn btn-primary mx-5" >Order</a> 
                </form>
            </div>
        </div>
    </div>
</main>