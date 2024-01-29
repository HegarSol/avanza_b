<?php
class MY_Controller extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
      //$this->output->enable_profiler(ENVIRONMENT == 'development');
      if(!$this->aauth->is_loggedin()){
         redirect('login');
      }

      if(!$this->session->userdata('rfc_empresa')){
         redirect('login/seleccionar_empresa');
      }
   }
}
