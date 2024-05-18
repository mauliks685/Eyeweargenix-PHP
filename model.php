<?php
Class Model{

    private $host = 'localhost';
    private $dbname = 'ecommercedemo';
    private $username = 'root';
    private $password = '';
    private $conn;
    // Constructor function is created for database connection
    public function __construct()
    {
        try
        {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e)
        {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    // Function to Insert Data
    function insertData($table, $data) {
        $columns = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        echo $sql;
        $stmt = $this->conn->prepare("INSERT INTO $table ($columns) VALUES ($values)");
        foreach ($data as $key => $value)
        {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
    }

    public function selectData($table, $columns, $condition, $data = [])
    {
        if ($columns === '*') {
            $selectedColumns = '*';
        } else {
            // Convert array to comma-separated string
            $selectedColumns = implode(", ", (array) $columns);
        }
        $sql = "SELECT $selectedColumns FROM $table";
    
        // Add condition if provided
        if (!empty($condition)) {
            $sql .= " WHERE $condition";
        }

        //echo $sql;  // For debugging purposes, you can remove this in a production environment
        
        $stmt = $this->conn->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    //function to update prodcut approval
    public function updateProductApproval($productId, $isChecked)
    {
        $stmt = $this->conn->prepare("UPDATE products SET isProductApproved = :isProductApproved WHERE productID = :productID");
        $stmt->bindParam(':isProductApproved', $isChecked, PDO::PARAM_BOOL);
        $stmt->bindParam(':productID', $productId, PDO::PARAM_INT);
        $stmt->execute();
    }

    //Update Product
    public function updateData($table, $data, $condition, $params)
    {
        // Retrieve the old file path before updating the data
        $selectParams = ['productImg']; // Update with the actual column name
        $selectCondition = $condition; // Assuming the condition uniquely identifies the product
        $oldFileToDelete = $this->selectData($table, $selectParams, $selectCondition, $params);

        // Execute UPDATE query
        $setClause = implode(", ", array_map(function ($key) {
            return "$key = :$key";
        }, array_keys($data)));

        $sql = "UPDATE $table SET $setClause WHERE $condition";
        $stmt = $this->conn->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();

        // Delete the old associated file
        if (!empty($oldFileToDelete)) {
            $oldFilePath = $oldFileToDelete[0]['productImg']; // Update with the actual column name
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }
    }


    //DElete product
    public function deleteData($table, $condition, $data = [])
    {
        // Retrieve the file path before deleting the data
        $selectParams = ['productImg']; // Update with the actual column name
        $selectCondition = $condition; // Assuming the condition uniquely identifies the product
        $fileToDelete = $this->selectData($table, $selectParams, $selectCondition, $data);

        // Execute DELETE query
        $sql = "DELETE FROM $table WHERE $condition";
        $stmt = $this->conn->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();

        // Delete the associated file
        if (!empty($fileToDelete)) {
            $filePath = $fileToDelete[0]['productImg']; // Update with the actual column name
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }



    //Get user By Email for Cart
    public function getUserIdByEmail($email) {
        $sql = "SELECT userID FROM user_details WHERE userEmail = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['userID'];
        } else {
            return null; // User not found
        }
    }

    //Get Cart Items
    public function getCartItems($userID) {
        $sql = "SELECT cart.*, products.productName, (cart.price * cart.quantity) AS totalPrice
                FROM cart
                JOIN products ON cart.productID = products.productID
                WHERE cart.userID = :userID";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Delete Cart Items
    public function deleteCartItems($userID){
        $sql = "DELETE from cart where userID = :userID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
    }

}

?>