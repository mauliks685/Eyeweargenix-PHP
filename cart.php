<?php
include('./controller.php');
	session_start();
	
	// print out header here
    $overallTotal = 0;
	$title = "Your shopping cart";
	require "./template/header.php";
    $controllerObj = new Controller();
    $cartItems = $controllerObj->viewCart();
	if($cartItems === "User not found"){
        echo '<p class="text-warning text-center">Your cart is empty! Please make sure you add some books in it!</p>';
    } else {

    
?>
	<section class="cart-section">
		<div class="container">
      		<h2 class="section-title">Cart</h2>
			<form class="form-with-bg" action="cart.php" method="post">
				<table class="table bg-light">
					<tr>
						<th>Item</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Total</th>
					</tr>
					<?php
						foreach($cartItems as $key => $cartItem){
					?>
					<tr>
						<td><?php echo $cartItem['productName']; ?></td>
						<td><?php echo $cartItem['price']; ?></td>
                        <td><?php echo  $cartItem['quantity']; ?></td>
                        <td><?php $total = $cartItem['price'] * $cartItem['quantity'];
                        $overallTotal += $total;
                        echo $total ?> </td>
					</tr>
					<?php } ?>
					<tr>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th></th>
						<th><?php echo $overallTotal; ?></th>
					</tr>
				</table>
			</form>
			<br/><br/>
			<a href="checkout.php" class="btn btn-primary">Go To Checkout</a> 
			<a href="home.php" class="btn btn-primary">Continue Shopping</a>
		</div>
  </section>
<?php
	}
	require_once "./template/footer.php";
?>