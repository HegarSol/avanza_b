<?php
   defined('BASEPATH') or exit('No direct script access allowed');

   class Comprobantes_proveedor extends MY_Controller
   {
	  public function __construct(){
		 parent::__construct();
          $this->load->model('Empresas_model', 'empresa');
	  }

	  public function index($rfc = ''){
          $data['rfc'] = $rfc;
          $data['modo_estricto'] = $this->empresa->getModoEstricto($this->session->rfc_empresa);
		 $this->load->view('reportes/Comprobantes_proveedor', $data);
	  }

    public function list(){
      $this->load->model('Reportes_model', 'reportes');
      $data['comprobantes'] = $this->reportes->comprobantesPorProveedor(
        $this->session->rfc_empresa,
        $this->input->post('rfc_proveedor'),
        $this->input->post('rfc_receptor'),
        $this->input->post('fechaInicial'),
        $this->input->post('fechaFinal'),
        $this->input->post('status_sat'),
        $this->input->post('status')
      );
      $this->load->view('reportes/comprobantes_proveedor/tabla', $data);
    }
   }
