<?php
   defined('BASEPATH') or exit('No direct script access allowed');

   class Reportes_admin extends MY_Controller {

	  public function __construct(){
		 parent::__construct();
		 $this->load->model('Precios_model', 'precios');
	  }

	  public function index() {
		 $this->load->view('reportes_admin/index');
	  } 

	  public function facturarPeriodo($mes, $anio){
		 if(!$this->aauth->is_admin()){
			show_error('No tiene permiso para el reporte');
		 }
		 $this->load->model('Comprobantes_model', 'comp');
		 $datos = $this->comp->getSumatoriaFactura($mes, $anio);
		 if(!$datos){
			show_error('No se encontraron registros para mostrar', 404, 'Sin informacion');
		 }
		 $this->load->library('pdf');
		 $this->pdf = new Pdf();
		 $this->pdf->AddPage();
		 $this->pdf->AliasNbPages();

		 $this->pdf->SetTitle('Reporte de Totales del Periodo');

		 $this->pdf->SetLeftMargin(15);
		 $this->pdf->SetRightMargin(15);
		 $this->pdf->SetFillColor(200,200,200);
		 $this->pdf->SetAutoPageBreak(true);


		 $this->pdf->SetFont('Arial','B', 9);
		 $this->pdf->Cell(60);
		 $this->pdf->Cell(0,10,'Reporte de Totales del Periodo');
		 $this->pdf->Ln();
		 $this->pdf->Cell(0,10,'Mes: ' . $mes . " del " . $anio);
		 $this->pdf->Ln();

		 // Encabezado de la tabla
		 $this->pdf->Cell(25,7,'R.F.C.', 1, 'C', 1);
		 $this->pdf->Cell(80,7,'NOMBRE', 1, 'C', 1);
		 $this->pdf->Cell(25,7,'CANTIDAD', 1, 'C', 1);
		 $this->pdf->Cell(25,7,'P.U', 1, 'C', 1);
		 $this->pdf->Cell(25,7,'IMPORTE', 1, 'C', 1);
		 $this->pdf->Ln(7);

		 $this->pdf->SetFont('Arial', '',8);

		 // Ciclo de resultados
		 foreach($datos as $row){
			$this->pdf->Cell(25,5,$row->empresa,0,'L');
			$this->pdf->Cell(80,5,$row->nombre,0,'L',1);
			$this->pdf->Cell(25,5,$row->cantidad,0,'C');
			$this->pdf->Cell(25,5,$this->precios->getPrecioUnitario($row->cantidad), 0, 'C');
			$this->pdf->Cell(25,5,$this->precios->getImporte($row->cantidad) + 263, 0, 'C');
			$this->pdf->Ln(5);
		 }

		 $this->pdf->Output('FactruasDelMes.pdf', 'I');
	  }
   }
