<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proveedores_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  public function get_all($empresa){
    return $this->db->select(array('rfc_proveedor', 'nombre_proveedor'))
    ->from('proveedores')
    ->where('rfc_empresa', $empresa)
    ->get()
    ->result();
  }

  public function add($rfcEmpresa, $rfcProveedor, $nombreProvedor){
    if($this->exists($rfcEmpresa, $rfcProveedor)){
      return FALSE;
    }
    $data = array(
      'rfc_empresa' => $rfcEmpresa,
      'rfc_proveedor' => $rfcProveedor,
      'nombre_proveedor' => $nombreProvedor
    );

    $this->db->insert('proveedores', $data);
    return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
  }

  public function exists($rfcEmpresa, $rfcProveedor){
    $this->db->from('proveedores')
    ->where('rfc_empresa', $rfcEmpresa)
    ->where('rfc_proveedor', $rfcProveedor);
    return ($this->db->count_all_results() > 0) ? TRUE : FALSE;
  }
}

/* End of file Proveedores_model.php */
/* Location: ./application/models/Proveedores_model.php */
