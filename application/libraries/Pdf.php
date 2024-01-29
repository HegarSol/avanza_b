<?php
   defined('BASEPATH') or exit('No direct script access allowed');

   require_once APPPATH . "/third_party/fpdf/fpdf.php";

   class Pdf extends FPDF{

	  public function __construct(){
		 parent::__construct('P','mm','Letter');
		 $this->SetAuthor('HEGAR Soluciones en Sistemas S. de R.L.');
	  }

	  //Encabezado del PDF
	  public function Header(){
		 $this->SetFont('Arial','B',13);
		 $this->Cell(30);
		 $this->Cell(120,10,'HEGAR SOLUCIONES EN SISTEMAS S. DE R.L.',0,0,'C');
		 $this->Ln(5);
	  }

	  public function Footer(){
		 $this->SetY(-15);
		 $this->SetFont('Arial','I',8);
		 $this->Cell(0,10,'Pagina: ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
		 }
   }
