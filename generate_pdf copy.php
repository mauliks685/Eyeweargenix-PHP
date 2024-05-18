<?php

include_once('fpdf184/fpdf.php');
class generatePDF {
   public function generate() {
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(40,10,'Hello World!');
    $pdf->Output();
   } 

}
class PDF extends FPDF
    {
        // Page header
        function Header()
        {
            // Logo
            $this->SetFont('Arial', 'B', 16);
            $this->Cell(0, 10, 'EyeweargeniX', 0, 1, 'C');
            $this->Ln(60);
        }
    }


?>