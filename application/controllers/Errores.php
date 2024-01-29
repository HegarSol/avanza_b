<?php defined('BASEPATH') or exit('No direct script access allowed');

   class Errores extends MY_Controller{

      public function __construct(){
         parent::__construct();
         $this->load->model('Errores_model', 'errores');
      }

      public function index()
      {
         $data['errores'] = $this->errores->getByRfc($this->session->userdata('rfc_empresa'));
         $this->load->view('errores/index', $data);
      }
   }
