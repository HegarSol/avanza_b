<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ValidacionComprobantes extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->model('Comprobantes_model', 'comp');
   }
   public function index()
   {
      $data['comprobantes'] = $this->comp->get_pendientes_validar_sat($this->session->userdata('rfc_empresa'));
      $this->load->view('ValidacionComprobantes/index', $data);
   }

   public function valida($uuid)
   {
      $comp = $this->comp->get_by_uuid($uuid);
      if(!$comp)
      {
         exit(json_encode(array('status' => FALSE, 'error' => 'No se encontro el comprobante')));
      }
      $this->load->helper('hegarss');
      $resp = valida_uuid_sat($comp->uuid, $comp->rfc_emisor, $comp->rfc_receptor, $comp->total);
      if(!$resp)
      {
         exit(json_encode(array('status' => FALSE, 'error' => 'No se puede validar el comprobante, intente mas tarde')));
      }
      $data['estado_sat'] = $resp['estado'];
      $data['codigo_sat'] = $resp['codigo_estatus'];
      $data['fecha_validacion'] = date('Y-m-d H:i:s');
      $this->comp->update_comprobante($uuid, $data);
      exit(json_encode(array(
         'status' => TRUE,
         'codigoEstatus' => $data['codigo_sat'],
         'estatus' => $data['estado_sat'],
         'esCancelable' => $resp['es_cancelable']
      )));
   }
}
