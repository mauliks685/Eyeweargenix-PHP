<?php
  session_start();
  include('./controller.php');
  $controllerObj = new Controller();
  $product = $controllerObj->getProductById();

  $title = $product['productName'];
  require "./template/header.php";

  if(isset($_POST['addToCart'])){
    $controllerObj->addToCart();
  }
?>
<section class="books-details-section">
    <div class="container">
      <h2 class="section-title">Latest Eyewear</h2>
      <!-- Example row of columns -->
      <p class="lead" style="margin: 25px 0"><a href="eyewaregenix.php">Eyeweargenix</a> > <?php echo $product['productName']; ?></p>
      <div class="row">
        <div class="col-md-4 text-center">
          <img class="img-responsive img-thumbnail" src="admin/<?php echo $product['productImg']; ?>">
        </div>
        <div class="col-md-8">
          <h4>Product Details</h4>
          <table class="table">
          	<?php foreach($product as $key => $value){
              if($key == "productImg" || $key == "productName"){
                continue;
              }
              switch($key){
                case "productID":
                  $key = "productID";
                  break;
                case "price":
                  $key = "price";
                  $value = "$ " . $value;
                  break;
              }
            ?>
            <tr>
              <td><?php echo $key; ?></td>
              <td><?php echo $value; ?></td>
            </tr>
            <?php 
              } 
            
            ?>
          </table>
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
  </section>
<?php
  require "./template/footer.php";
?>