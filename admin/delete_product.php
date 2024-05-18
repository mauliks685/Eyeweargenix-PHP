<?php
include('../controller.php');
session_start();
if(isset($_REQUEST['product_id'])){
    $controllerObj = new Controller();
    $controllerObj->deleteProductById();
}
?>