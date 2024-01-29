<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class PendientesProcesar extends REST_Controller
{
  
  public function __construct()
  {
    parent::__construct('rest_web');
    $this->load->model('Certificados_model');
    $this->load->model('Acuse_model');
  }

  public function procesa_peticion_post()
  {
    ini_set("soap.wsdl_cache_enabled", "0");
    $this->form_validation->set_rules('uuid', 'UUID', 'required');
    $this->form_validation->set_rules('accion', 'Accion', 'required');
    if($this->form_validation->run() == FALSE){
      $this->response(['error' => validation_errors()],REST_Controller::HTTP_BAD_REQUEST);
    }
    $aceptar = $this->post('accion') == 'A' ? 'Aceptacion' : 'Rechazo';
    $certificado = $this->Certificados_model->get_valid($this->session->rfc_empresa);
    if(!$certificado){
      $this->response(['error' => 'No cuentas con un certificado vigente para realizar la operacion'], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    }
    $context = array(
      'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false
      )
    );

    try{

        $curl = curl_init('http://timbrado.hegarss.com/rest/Comprobantes/SolicitudAceptarRechazar');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, "uuid=" . $this->post('uuid'). "&action=". $aceptar ."&password=".$this->encryption->decrypt($certificado->pass)."&rfc=".$this->session->rfc_empresa."&b64Pfx=".urlencode($certificado->pfx));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($curl);
        //var_dump($response);
        $result = json_decode($response);

      if($result->status == true)
      {
          $this->response(['data' => true], REST_Controller::HTTP_OK);
      }
      else 
      {
          $this->response(['error' => $result->data], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
       }

    } 
    catch( Exception $e) 
    {
      $this->response(['error' => 'No se puede establecer la conexion con el servidor de timbrado' . $e->getMessage()], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}

/* End of file PendientesProcesar.php */
