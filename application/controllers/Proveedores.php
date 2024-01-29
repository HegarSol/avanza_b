<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proveedores extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Proveedores_model','proveedores');
  }

  public function index()
  {
    show_404();
  }

  public function search(){
    $data['proveedores'] = $this->proveedores->get_all($this->session->rfc_empresa);
    $this->load->view('proveedores/modal_search',$data);
  }

}

/* End of file Provedores.php */
/* Location: ./application/controllers/Provedores.php */
