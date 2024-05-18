<?php

include_once('fpdf184/fpdf.php');

class generatePDF extends FPDF {
    private $name;
    private $email;
    private $address;
    private $city;
    private $zip_code;
    private $country;
    private $cartItems;

    // Constructor to receive user details
    public function __construct($name, $email, $address, $city, $zip_code, $country, $cartItems) {
        parent::__construct();
        $this->name = $name;
        $this->email = $email;
        $this->address = $address;
        $this->city = $city;
        $this->zip_code = $zip_code;
        $this->country = $country;
        $this->cartItems = $cartItems;
    }

    public function generate() {
        ob_clean(); // Clean the output buffer

        // PDF generation code
        $date = date('d-m-y');
        $this->AddPage();
        $this->SetFont('Arial', 'B', 16);
        $this->SetMargins(20,20,20);

        // Output user details in the PDF
        $this->Cell(10);
        $this->Cell(75,10,"Full Name: ". $this->name);
        $this->Ln();
        $this->Cell(75,10,"Email: ". $this->email);
        $this->Ln();
        $this->Cell(75,10,"Address: ". $this->address);
        $this->Ln();
        $this->Cell(75,10,"City: ". $this->city);
        $this->Ln();
        $this->Cell(75,10,"Zip Code: ". $this->zip_code);
        $this->Ln();
        $this->Cell(75,10,"Country: ". $this->country);
        $this->Ln();
        $this->Cell(75,10,"Date: ".$date);
        $this->Ln(20);

        $this->Cell(150,10,"","T");
        $this->Ln(10);

        $this->Cell(40,10,"Product Name: ");
        $this->Cell(100);
        $this->Cell(10,10,"Product Price: ");
        $this->Ln(5);

        // Output cart items in the PDF
        $this->Ln();
        foreach ($this->cartItems as $cartItem) {
            $this->Cell(40,10,$cartItem['productName']);
            $this->Cell(100);
            $this->Cell(10,10,$cartItem['quantity'] . ' x $' . $cartItem['price']);
            $this->Ln();
        }

        $this->Ln(5);

        // Calculate and display total price
        $totalPrice = array_reduce($this->cartItems, function ($carry, $item) {
            return $carry + ($item['quantity'] * $item['price']);
        }, 0);

        $this->Ln(25);
        $this->Cell(135);
        $this->Cell(25,10,"Total");
        $this->Ln();
        $this->Cell(135);
        $this->SetFont('Arial','B',20);
        $this->Cell(25,10,"$".$totalPrice);

        $this->Output();
        exit(); // Ensure no further code is executed after sending the PDF
    }
}

class PDF extends FPDF {
    // Page header
    function Header() {
        // Logo
        // $this->SetFont('Arial', 'B', 16);
        // $this->Cell(0, 10, 'EyeweargeniX', 0, 1, 'C');
        $this->Image('assets/img/header.jpg',0,0,210);
        $this->Ln(60);
    }
}