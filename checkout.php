<?php
include('./controller.php');
session_start();
$overallTotal = 0;
$title = "Checking Out";
require "./template/header.php";
?>

<?php


include_once('fpdf184/fpdf.php');
include_once('generate_pdf.php'); 

if (isset($_POST['btnSubmit'])) {
    // Form validation
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $zip_code = trim($_POST['zip_code']);
    $country = trim($_POST['country']);

    $errors = [];

    // Check if required fields are empty
    if (empty($name) || empty($email) || empty($address) || empty($city) || empty($zip_code) || empty($country)) {
        $errors[] = 'All fields are required.';
    }

    // Additional validation if needed...

    if (empty($errors)) {
        // Get cart items
        $controllerObj = new Controller();
        $cartItems = $controllerObj->viewCart();

        // Create an instance of generatePDF
        $pdfGenerator = new generatePDF($name, $email, $address, $city, $zip_code, $country, $cartItems);

        $controllerObj->emptyCart($_SESSION['email']);
        
        // Generate and display the PDF
        $pdfGenerator->generate();
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo '<p class="text-danger">' . $error . '</p>';
        }
    }
} else {
    // Print out header here
    $controllerObj = new Controller();
    $cartItems = $controllerObj->viewCart();
    // print_r($cartItems);

    if ($cartItems === "User not found") {
        echo '<p class="text-warning text-center">Your cart is empty! Please make sure you add some books in it!</p>';
    } else {
?>
        <section class="checkout-section">
            <div class="container">
                <h2 class="section-title">Cart</h2>
                <table class="table">
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                    <?php
                    foreach ($cartItems as $key => $cartItem) {
                    ?>
                        <tr>
                            <td><?php echo $cartItem['productName']; ?></td>
                            <td><?php echo $cartItem['price']; ?></td>
                            <td><?php echo $cartItem['quantity']; ?></td>
                            <td><?php
                                $total = $cartItem['price'] * $cartItem['quantity'];
                                $overallTotal += $total;
                                echo $total;
                                ?> </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th></th>
                        <th><?php echo $overallTotal; ?></th>
                    </tr>
                </table>

                <form method="post" action="" class="form-horizontal form-with-bg">
                    <h4>Enter your details</h4>
                    <?php if (isset($_SESSION['err']) && $_SESSION['err'] == 1) { ?>
                        <p class="text-danger">All fields have to be filled</p>
                    <?php } ?>
                    <div class="form-group mb-3">
                        <label for="name" class="control-label col-md-4">Name</label>
                        <input type="text" name="name" class="col-md-4 form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="name" class="control-label col-md-4">Email</label>
                        <input type="text" name="email" class="col-md-4 form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="address" class="control-label col-md-4">Address</label>
                        <input type="text" name="address" class="col-md-4 form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="city" class="control-label col-md-4">City</label>
                        <input type="text" name="city" class="col-md-4 form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="zip_code" class="control-label col-md-4">Zip Code</label>
                        <input type="text" name="zip_code" class="col-md-4 form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="country" class="control-label col-md-4">Country</label>
                        <input type="text" name="country" class="col-md-4 form-control">
                        <input type="hidden" name="overallTotal" value="<?php echo $overallTotal; ?>" class="col-md-4 form-control">
                    </div>
                    <div class="form-group mb-3">
                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Purchase" class="btn btn-primary">
                    </div>
                    <p class="form-note">Please press Purchase to confirm your purchase, or Continue Shopping to add or remove items.</p>
                </form>
            </div>
        </section>
<?php
    }
    require_once "./template/footer.php";
}
?>
