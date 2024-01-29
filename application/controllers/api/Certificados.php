<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Certificados extends REST_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Certificados_model');
    $this->load->helper('hegarss');
  }

  public function index_post()
  {
   
    $this->form_validation->set_rules('password', 'Contraseña', 'required');
    $this->form_validation->set_rules('pass_pfx', 'Clave PFX', 'required');
    if($this->form_validation->run() == FALSE){
      $this->response(['success' => FALSE, 'error' => validation_errors()], 400);
    }
    // validamos que se suba correctamente los archivos
    $config['allowed_types'] = '*';
    $config['upload_path'] = sys_get_temp_dir();
    $config['encrypt_name'] = true;

    $this->load->library('upload', $config);
    if (!$this->upload->do_upload('certificado')) {
      $this->response([
        'status' => false,
        'error' => $this->upload->display_errors('', '') . ' Certificado'],400);
    }
    $cerFile = $this->upload->data('full_path');
    if (!$this->upload->do_upload('llave_privada')) {
      $this->response(
        [
          'status' => FALSE,
          'error' => $this->upload->display_errors('','') . ' Llave Privada'
        ],
        REST_Controller::HTTP_BAD_REQUEST
      );
    }
    $keyFile = $this->upload->data('full_path'); 
    $oCer = new CkCert();
    $oKey = new CkPrivateKey();

    if($oKey->LoadPkcs8EncryptedFile($keyFile, $this->input->post('password')) == FALSE){
      $this->response(['status' => FALSE, 'error' => 'No se puede abrir la llave privada'], REST_Controller::HTTP_BAD_REQUEST);
    }
    if($oCer->LoadFromFile($cerFile) == FALSE)
    {
      $this->response(['status' => FALSE, 'error' => 'No se puede cargar la llave publica'], REST_Controller::HTTP_BAD_REQUEST);
    }
    //VALIDAMOS QUE PERTENESCA A LA EMPRESA
    if(strpos($oCer->subjectDN(), $this->session->rfc_empresa) === FALSE)
    {
      $this->response(['error' => 'El CSD no pertenece a su RFC'], REST_Controller::HTTP_BAD_REQUEST);
    }
    // Validamos que el .cer y el .key sean parejas
    if(!csd_match($oCer->ExportPublicKey()->getXml(), $oKey->getXml()))
    {
      $this->response(['error' => 'El Certificado y la Llave Privada no concuerdan'], REST_Controller::HTTP_BAD_REQUEST);
    }
    $oCer->SetPrivateKey($oKey);
    $oChunk = new CkByteData();
    $oCer->ExportToPfxData($this->post('pass_pfx'), TRUE, $oChunk);
    $data['empresa'] = $this->session->rfc_empresa;
    $data['no_certificado'] = hex2bin($oCer->SerialNumber());
    $data['fecha_inicio'] = $oCer->GetValidFromDt()->getAsTimestamp(FALSE);
    $data['fecha_vence'] = $oCer->GetValidToDt()->getAsTimestamp(FALSE);
    $data['pfx'] = $oChunk->getEncoded('base64');
    $data['pass'] = $this->encryption->encrypt($this->post('pass_pfx'));
    if(!$this->Certificados_model->add($data))
    {
      $this->response(['status' => FALSE, 'error' => 'Error al almacenar el CSD'], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    }
    $this->response(['status' => TRUE, 'data' => 'CSD almacenado correctamente']);


  }

  public function index_delete($no_cert)
  {
    if(!$this->Certificados_model->delete($this->session->rfc_empresa, $no_cert))
    {
      $this->response(['error' => 'No se puede eliminar el CSD'], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    }
    $this->response([]);
  }
}



/* End of file Certificados.php */
