<?php
    session_start();
    $count = 0;
    include('./controller.php');
    $controllerObj = new Controller();
    $products = $controllerObj->getProducts();
    require_once "./template/header.php";

    // Filter by Price Range
    $minPrice = isset($_GET['minPrice']) ? $_GET['minPrice'] : 0;
    $maxPrice = isset($_GET['maxPrice']) ? $_GET['maxPrice'] : PHP_INT_MAX;

    // Sorting Options
    $sortOption = isset($_GET['sort']) ? $_GET['sort'] : 'default';

    // Function to compare product names for sorting
    function compareProductNames($a, $b) {
        return strcmp($a['productName'], $b['productName']);
    }

    // Apply Sorting
    if ($sortOption == 'az') {
        usort($products, 'compareProductNames');
    } elseif ($sortOption == 'za') {
        usort($products, 'compareProductNames');
        $products = array_reverse($products);
    }

    if(isset($_POST['addToCart'])){
        $controllerObj->addToCart();
    }
?>
  <section class="books-section">
    <div class="container">
      <h2 class="section-title">Our Products</h2>

      <div class="row"> 
        <div class="col-md-3"> 
            <h3><b>Filter:</b></h3>
            <!-- Filter Form -->
            <form method="get" action="products.php" id="sortingForm">
                <div class="form-label" class="sort-filter">
                    <label for="sort">Sort by:</label>
                    <select class="form-select" name="sort" id="sort" onchange="document.getElementById('sortingForm').submit();">
                        <option value="default" <?php echo ($sortOption == 'default') ? 'selected' : ''; ?>>Default</option>
                        <option value="az" <?php echo ($sortOption == 'az') ? 'selected' : ''; ?>>A-Z</option>
                        <option value="za" <?php echo ($sortOption == 'za') ? 'selected' : ''; ?>>Z-A</option>
                    </select>
                </div>
            </form>

            <form method="get" action="products.php">
                <div class="price-filter mt-3">
                    <h5><b>By Price:</b></h5>
                    <label class="form-label" for="minPrice">Min Price:</label>
                    <input class="form-control" type="number" name="minPrice" id="minPrice" value="<?php echo isset($_GET['minPrice']) ? $_GET['minPrice'] : ''; ?>" min="0">
                    <label class="form-label" for="maxPrice">Max Price:</label>
                    <input class="form-control" type="number" name="maxPrice" id="maxPrice" value="<?php echo isset($_GET['maxPrice']) ? $_GET['maxPrice'] : ''; ?>" min="0">
                    <button type="submit" class="btn btn-primary mt-3">Apply Price Range</button>
                </div>
            </form>

            <!-- Clear Filters Button -->
            <form method="get" action="products.php">
                <button type="submit" class="btn btn-secondary mt-2">Clear Filters</button>
            </form>
        </div>  

        <div class="col-md-9 ps-5"> 
            <div class="row">
                <?php foreach ($products as $product) { 
                    if ($product['price'] >= $minPrice && $product['price'] <= $maxPrice) {
                ?>
                    <div class="col col-md-3 mb-5">
                        <div class="book-block">
                        <div class="book-image ">
                            <a href="eyeweargenix.php?product_id=<?php echo $product['productID']; ?>">
                                <img class="img-responsive img-thumbnail" src="admin/<?php echo $product['productImg']; ?>">
                            </a>
                        </div>
                        <div class="book-content-wrap">
                            <h3><?php echo $product['productName']; ?></a>
                            </h3>
                            <div class="book-info-wrap">
                                <div class="book-info-bed">
                                    <span class="book-bed"><?php echo $product['productName']; ?></span>
                                </div>
                            </div>
                            
                            
                            <div class="book-bottom">
                                <div class="book-price-wrap">
                                    <span class="book-price"><b>$<?php echo $product['price']; ?></b></span>
                                </div>
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
                                    <button class="btn btn-primary add-to-cart-button" type="submit" name="addToCart">Buy Now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    </div>
                <?php 
                    } 
                }
                ?>

                
            </div>
        </div>
    </div>
</section>

<?php
                
    if(isset($conn)) { mysqli_close($conn); }
    require_once "./template/footer.php";
?>
      