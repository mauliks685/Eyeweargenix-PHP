<?php
    include('controller.php');
    session_start();
    $title = "Home";
    require_once "./template/header.php";
    $controllerObj = new Controller();
    $products = $controllerObj->getLatestVisibleProducts();

    if(isset($_POST['addToCart'])){
        $controllerObj->addToCart();
    }
?>

<main id="main">
    <section class="home-page-banner-slider p-0">
        <div class="banner-section slide-1">
            <div class="container">
                <h2 class="text-left">Bestseller Premium <br/>Sunglasses</h2>
                <a class="btn btn-primary mt-5" href="books.php">Shop Now</a>
            </div>
            <div class="overlay"></div>
        </div>
    </section>

    <section class="product-section">
        <div class="container">
            <h2 class="section-title">Latest Products</h2>
            <div class="row product-list">
            <?php  
                foreach ($products as $product) { ?>
                    <div class="col col-md-3">
                        <div class="product-block">
                            <div class="product-image">
                                <a href="eyeweargenix.php?product_id=<?php echo $product['productID']; ?>">
                                    <img src="admin/<?php echo $product['productImg'] ?>" alt="<?php echo $product['productName']; ?>">
                                </a>
                            </div>
                            <div class="product-content-wrap">
                                <h3><?php echo $product['productName'] ?></h3>
                                <p><b>$<?php echo $product['price'] ?></b></p>
                                <!-- In your HTML file -->
                                <form method="post">
                                    <input type="hidden" name="productId" value="<?php echo $product['productID']; ?>">
                                    <label for="quantity">Quantity:</label>
                                    
                                    <div class="input-group">
                                        <input type="button" value="-" class="button-minus" data-field="quantity">
                                        <!-- <input type="number" step="1" max="" value="1" name="quantity" class="quantity-field"> -->
                                        <input class="quantity-input quantity-field" type="number" step="1" name="quantity" value="1" min="1" max="<?php echo $product['quantityAvailable']; ?>">
                                        <input type="button" value="+" class="button-plus" data-field="quantity">
                                    </div>


                                    
                                    <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                                    <button class="btn btn-primary add-to-cart-button" type="submit" name="addToCart">Add to Cart</button>
                                </form>

                            </div>
                        </div>
                    </div>
                 <?php } ?>

                 <div class="col-12 mt-5 text-center">
                    <a class="btn btn-secondary" href="products.php">See all Products</a>
                </div>

            </div>
        </div>
    </section>
</main>
<?php
require_once "./template/footer.php";
?>                