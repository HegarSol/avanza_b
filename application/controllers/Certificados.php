<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Certificados extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Certificados_model');
  }

  public function index()
  {
    $data['certificados'] = $this->Certificados_model->get_all($this->session->rfc_empresa);
    $this->load->view('certificados/index', $data);
  }

}

/* End of file Certificados.php */
