<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Relacionados_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  public function add($data)
  {
    $this->db->trans_start();
    $this->db->insert('compro_docs_relacionados', $data);
    $this->db->trans_complete();
    return $this->db->trans_status();
  }
  public function addRetencion($dataRete)
  {
    $this->db->trans_start();
    $this->db->insert('compro_impuestos', $dataRete);
    $this->db->trans_complete();
  }
  public function addTrasla($dataTras)
  {
    $this->db->trans_start();
    $this->db->insert('compro_impuestos', $dataTras);
    $this->db->trans_complete();
  }
}

/* End of file Proveedores_model.php */
/* Location: ./application/models/Proveedores_model.php */
