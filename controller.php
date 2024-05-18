<?php
include "model.php";

class Controller extends Model {
    
    // Function to Insert User Details
    public function insert_user() {
        $error = "";
    
        $name = isset($_POST['txtName']) ? $_POST['txtName'] : '';
        $email = isset($_POST['txtEmail']) ? $_POST['txtEmail'] : '';
        $password = isset($_POST['txtPassword']) ? $_POST['txtPassword'] : '';
        $cellNumber = isset($_POST['contact_number']) ? $_POST['contact_number'] : '';
    
        // Check if any required field is empty
        if (empty($name) || empty($email) || empty($password) || empty($cellNumber)) {
            $error = "All fields are required.";
        } else {
            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Invalid email format.";
            } else {
                $dataToInsert = array(
                    'userName' => $name,
                    'userEmail' => $email,
                    'password' => md5($password),
                    'contactNumber' => $cellNumber
                );
    
                $this->insertData('user_details', $dataToInsert);
                header('Location: index.php');
            }
        }
    
        // Display the error message
        return $error;
    }
    
    

    // Function for Login
    public function userLogin(){
        $error = "";
        $email = $_POST['txtEmail'];
        $password = $_POST['txtPassword'];
    
        if (!empty($email) && !empty($password)) {
            // Checking the user in the database
            if ($email == "admin@mystore.com" && $password == "Admin@123") {
                session_start();
                $_SESSION['email'] = $email;
                header("Location: admin/index.php");
            } else {
                // Checking user email in the database
                session_start();
                $selectParams = [
                    'userEmail' => $email,
                    'password' => md5($password)
                ];
                $condition = 'userEmail = :userEmail AND password = :password';
                $res = $this->selectData('user_details', '*', $condition, $selectParams);
                $rows = count($res);
                if ($rows > 0) {
                    $_SESSION['email'] = $email;
                    header("Location: home.php");
                } else {
                    $error = "Invalid Email or Password";
                }
            }
        } else {
            $error = "Email and password are required";
        }
    
        // Display the error message
        return $error;
    }
    

    // Add Product
    public function addProduct(){
        $productName = $_POST['productName'];
        $productQty = $_POST['productQtyAvailable'];
        $productPrice = $_POST['productPrice'];

        $imageDir = "images/";
        $uploadedFile = $imageDir . basename($_FILES['productImg']['name']);

        //logic for file upload
        if(($_FILES['productImg']['type'] == 'image/jpg') || 
            ($_FILES['productImg']['type'] == 'image/jpeg') || 
            ($_FILES['productImg']['type'] == 'image/png') && 
            ($_FILES['productImg']['size'] < 500000)) {
                if($_FILES['productImg']['error'] === 0 &&(!file_exists($uploadedFile)) &&
                move_uploaded_file($_FILES['productImg']['tmp_name'], $uploadedFile)){
                    $dataToInsert = array(
                        'productName' => $productName,
                        'productImg' => $uploadedFile,
                        'quantityAvailable' => $productQty,
                        'price' => $productPrice
                    );
                    $this->insertData('products', $dataToInsert);
                    header('Location: index.php');
                } else {
                    echo "Failed to upload Image";
                }
        } else {
            echo "Invalid File type";
        }
    }

    //Get Product
    public function getProducts(){
        $selectParams = [];
        $condition = "";
        return $this->selectData('products', '*', $condition, $selectParams);
    }

    //Get Product
    public function getVisibleProducts(){
        $selectParams = [];
        $condition = 'isProductApproved = :isProductApproved';
        $selectParams['isProductApproved'] = 1;
    
        return $this->selectData('products', '*', $condition, $selectParams);
    }
    
    //Latest Product
    // Get Product
    public function getLatestVisibleProducts($limit = 4)
    {
        $selectParams = [];
        $condition = 'isProductApproved = :isProductApproved';
        $selectParams['isProductApproved'] = 1;

        $orderBy = 'productID DESC'; 

        return $this->selectData('products', '*', $condition, $selectParams, $orderBy, $limit);
    }


    //Get product by ID
    public function getProductById()
    {
        $productID = $_GET['product_id'];
        $selectParams = ['productID' => $productID];
        $condition = 'productID = :productID';
        $product = $this->selectData('products', '*', $condition, $selectParams);

        if ($product) {
            return $product[0]; // Assuming there is only one product with the given ID
        } else {
             echo "No product Found";
        }
    }

    //Edit product
    public function editProduct()
    {
        $productID = $_POST['productID'];
        $productName = $_POST['productName'];
        $productQty = $_POST['productQtyAvailable'];
        $productPrice = $_POST['productPrice'];

        $imageDir = "images/";
        $uploadedFile = $imageDir . basename($_FILES['productImg']['name']);

        //logic for file upload
        if(($_FILES['productImg']['type'] == 'image/jpg') || 
            ($_FILES['productImg']['type'] == 'image/jpeg') || 
            ($_FILES['productImg']['type'] == 'image/png') && 
            ($_FILES['productImg']['size'] < 500000)) {
                if($_FILES['productImg']['error'] === 0  &&
                move_uploaded_file($_FILES['productImg']['tmp_name'], $uploadedFile)){
                    $dataToUpdate = array(
                        'productID' => $productID,
                        'productName' => $productName,
                        'productImg' => $uploadedFile,
                        'quantityAvailable' => $productQty,
                        'price' => $productPrice
                    );
                    $condition = 'productID = :productID';
                    $params = ['productID' => $productID]; 
                    print_r($dataToUpdate);
                    $this->updateData('products', $dataToUpdate, $condition, $params);
                    header('Location: index.php');
                } else {
                    echo "Failed to upload Image";
                }
        } else {
            echo "Invalid File type";
        }
    }

    //delete product
    public function deleteProductById(){
        $productID = $_GET['product_id'];
        $this->deleteData('products', 'productID = :productID', ['productID' => $productID]);
        header('Location: index.php');
    }


    //Add To Cart
    public function addToCart(){
        $productID = $_POST['productId'];
        $qty = $_POST['quantity'];
        $price = $_POST['price'];
        $userEmail = $_SESSION['email'];
        $userID = $this->getUserIdByEmail($userEmail);
    
        if($userID) {
            $dataToInsert = array(
                'userID' => $userID,
                'productID' => $productID,
                'quantity' => $qty,
                'price' => $price
            );
            print_r($dataToInsert);
    
            $this->insertData('cart', $dataToInsert);
            header('Location: cart.php');
            
        } else {
            echo "User not found";
        } 
    }

    //View Cart
    public function viewCart() {
    
        $userEmail = $_SESSION['email'];
        $userID = $this->getUserIdByEmail($userEmail);
    
        if ($userID) {
            $cartItems = $this->getCartItems($userID);
    
            return $cartItems;
        } else {
            echo "User not found";
        }
    }

    //Empty Cart
    public function emptyCart($userEmail) {
        $userId = $this->getUserIdByEmail($userEmail);
        $result = $this->deleteCartItems($userId);
        if($result) {
            header("location: index.php");
        } else {
            echo "Cart is Empty";
        }
    }

    // Validations 
    public function is_valid_email($user_email) {
        if(filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
      
    public function is_valid_password($password) {
        if (strlen($password) >= 8 && strlen($password) <= 16) {
            return true;
        } else {
            return false;
        }
    }
      
    public function is_valid_number($input_number) {
        if(preg_match("/^[0-9]{10}+$/",$input_number)) {
            return true;
        } else { 
            return false;
        }
    }
}
?>