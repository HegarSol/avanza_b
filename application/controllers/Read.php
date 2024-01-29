<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Read extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->library('LecturaCfdi');
	  error_reporting(-1);
	  ini_set('display_errors', 1);
      $this->output->enable_profiler(TRUE);
   }

   public function index()
   {
     echo $this->lecturacfdi->get_referencia("Asunto del correo REFERENCIA: 123456789      ");
      
   }

   public function show_error()
   {
      $data['nombreEmpresa'] = 'Juan B. Carranza y Cia.';
      $data['proveedor'] = array('nombre' => 'TRANSPORTES S.A. DE C.V.');
      $data['aceptada'] = FALSE;
      $this->load->view('mail_messages/error',$data);
   }

   public function test_cfdi()
   {
      $this->load->library('Cfdi');
      if(!$this->cfdi->loadXml(file_get_contents(base_url('public/xmls/test.xml'))))
      {
         echo $this->cfdi->lastError;
      }
      //if(!$this->cfdi->valida_sello())
      //{
       //  exit('El sello del comprobante no es valido');
      //}
      if(!$this->cfdi->save_to_db('GAMG880406V7A'))
      {
         echo $this->cfdi->lastError;
      }
   }

   public function test_complemento()
   {
     $this->load->library('Cfdi');
     if(!$this->cfdi->loadXml(file_get_contents(base_url('public/xmls/test_cp.xml'))))
     {
       echo $this->cfdi->lastError;
     }
     if(!$this->cfdi->save_to_db('GAMG880406V7A'))
     {
       echo $this->cfdi->lastError;
     }
   }

   public function valida_sat(){
      $this->load->helper('hegarss');
      $res = valida_uuid_sat('178E6DC2-1E81-4CE1-81D2-DB0CE4E870B2','HSS1306229V2','AEC050309KY1',1452.260000);
      if(!$res){
         echo 'No se puede comprobar el status del comprobante';
      } else {
         echo var_dump($res);
      }
   }
}
