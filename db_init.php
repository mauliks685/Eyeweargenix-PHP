<?php
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'ecommercedemo');


    $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
        OR die('Could not connect to MySQL: ' . mysqli_connect_error());
    mysqli_set_charset($dbc, 'utf8');

   
    function prepare_string($dbc, $string) {
        $string_trimmed = trim($string);
        $string = mysqli_real_escape_string($dbc, $string_trimmed);
        return $string;
    }

    $createDB = "CREATE DATABASE IF NOT EXISTS DB_NAME";
    if($dbc->query($createDB) === TRUE) {
        //echo "Database Created <br>";
    } else {
        echo "Error creating database". $dbc->error. "<br>";
    }

    // $createTableShoes = "
    // CREATE TABLE IF NOT EXISTS shoes(
    //     shoesID INT PRIMARY KEY AUTO_INCREMENT,
    //     shoesName varchar(30) NOT NULL,
    //     shoesDescription varchar(50) NOT NULL,
    //     quantityAvailable INT NOT NULL,
    //     price decimal(8,2),
    //     productAddedBy varchar(25) DEFAULT 'Maulik Shah' NOT NULL)";

    // $stmt_create_table = $dbc->prepare($createTableShoes);
    // if($stmt_create_table->execute() === TRUE) {
    //     //echo "Table Shoes Created. <br>";
    // }   else {
    //     echo "Error creating table" .$stmt_create_table->error. "<br>";
    // }
    // $stmt_create_table->close();
?>