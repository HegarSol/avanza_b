<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
	   $this->load->model('Comprobantes_model', 'comprobantes');
	   $this->load->model('Empresas_model','empresas');
	   $empresa = $this->session->userdata('rfc_empresa');
	   $currentMonth = date('n');
	   $currentYear = date('Y');
	   $data['total_comprobantes'] = $this->comprobantes->get_total_comprobantes_periodo($empresa, $currentMonth, $currentYear);
	   $data['sin_validar_sat'] = $this->comprobantes->get_total_pendientes_validar_sat($empresa);
	   $data['sin_aprobar'] = $this->comprobantes->get_count_by_status($empresa, 'P');
	   $data['rechazados'] = $this->comprobantes->get_count_by_status($empresa, 'R');
	   $data['dmcmasiva'] = $this->empresas->getmasiva($empresa);
       $this->load->view('templates/header');
       $this->load->view('dashboard', $data);
       $this->load->view('templates/footer');
	}
}
