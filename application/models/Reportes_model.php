<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportes_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  public function comprobantesPorProveedor($rfc_empresa,
    $rfc_proveedor,
    $rfcReceptor = '',
    $fechaInicial = '',
    $fechaFinal = '',
    $estadoSat = '',
    $status = ''
  ){
    $this->db->from('comprobantes')
    ->where('empresa', $rfc_empresa)
    ->where('rfc_emisor', $rfc_proveedor);
    if(!empty($rfcReceptor)){
      $this->db->where('rfc_receptor', $rfcReceptor);
    }
    if(!empty($fechaInicial)){
      $this->db->where('date(fecha) >=', $fechaInicial);
    }
    if(!empty($fechaFinal)){
      $this->db->where('date(fecha) <=', $fechaFinal);
    }
    if(!empty($estadoSat)){
      $this->db->where('estado_sat', $estadoSat);
    }
    if(!empty($status)){
      $this->db->where('status', $status);
    }
    return $this->db->get()->result();
  }
}

/* End of file Reportes_model.php */
/* Location: ./application/models/Reportes_model.php */
