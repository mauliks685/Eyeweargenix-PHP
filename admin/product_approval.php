
<?php
include('../model.php');

if (isset($_GET['productId']) && isset($_GET['isChecked'])) {
    // Sanitize input values
    $productId = filter_var($_GET['productId'], FILTER_SANITIZE_NUMBER_INT);
    $isChecked = filter_var($_GET['isChecked'], FILTER_VALIDATE_BOOLEAN);

    // Ensure that $productId is a valid integer
    if ($productId !== false && $productId > 0) {
        // Convert boolean to integer (0 or 1)
        $isChecked = $isChecked ? 1 : 0;

        // Update product approval using prepared statement
        $model = new Model();
        $model->updateProductApproval($productId, $isChecked);
    } else {
        // Handle invalid productId
        echo "Invalid productId";
    }
}
?>
