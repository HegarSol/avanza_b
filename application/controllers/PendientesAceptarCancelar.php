<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PendientesAceptarCancelar extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Comprobantes_model');

  }

  public function index()
  {
    $uuids = array();
    $pendientes = $this->_get_pendientes_sat();
    if(ENVIRONMENT == 'development')
    {
      $pendientes[] = '467A3078-5571-4C1A-B2EF-9969BB46EC45';
    }
    foreach($pendientes as $clave => $uuid )
    {
      $uuids[$uuid] = $this->Comprobantes_model->get_by_uuid($uuid);
    }
    $datos['uuids'] = $uuids;
    $this->load->view('pendientes_cancelar/index', $datos);
  }

  protected function _get_pendientes_sat()
  {

  $uuids = array();

  $rfc = $this->session->rfc_empresa;
    try
    {

       $curl = curl_init('http://timbrado.hegarss.com/rest/Comprobantes/getPendientes');
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
       curl_setopt($curl, CURLOPT_POSTFIELDS, "rfc=" . $rfc);
       curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
       curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

       $response = curl_exec($curl);
       $result = json_decode($response);


       if($result->status == 'success')
       {
          foreach($result->data->uuid as $uuid)
          {
             $uuids[] = $uuid;
          }
       }

    } catch(Exception $ex) {
      show_error($ex->getMessage());
    }
    return $uuids;
  }

}

/* End of file PendientesAceptarCancelar.php */
