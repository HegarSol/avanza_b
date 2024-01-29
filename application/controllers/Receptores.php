<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Receptores extends MY_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->model('Receptores_model');
    }
    public function index()
    {
        show_404();
    }

    public function search(){
        $data['receptores'] = $this->Receptores_model->getAll($this->session->rfc_empresa);
        $this->load->view('receptores/modal_search', $data);
    }

}

/* End of file Receptores.php */
