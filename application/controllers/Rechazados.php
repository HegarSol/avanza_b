<?php

   defined('BASEPATH') or exit('No direct script access allowed');

   class Rechazados extends MY_Controller
   {

	  public function __construct(){
		 parent::__construct();
		 $this->load->model('Comprobantes_model', 'comp');
		 $this->load->library('table');
		 $config = array(
			'table_open' => '<table class="table table-bordered table-striped" cellpadding="4" cellspacing="0" id="rechazados">'
		 );
		 $this->table->set_template($config);
	  }

	  public function index(){
		 $datos['Comprobantes'] = $this->comp->getRechazadosSinCancelar($this->session->userdata('rfc_empresa'));
		 $this->table->set_heading('Version', 'UUID', 'Fecha', 'Folio', 'Serie', 'RFC', 'Nombre', 'Estado');

		 $this->load->view('rechazados/index', $datos);
	  }
   }
