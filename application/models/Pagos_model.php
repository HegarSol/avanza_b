<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pagos_model extends CI_Model {
  
  public function add($data, $dctos)
  {
    $this->db->trans_start();
    $this->db->insert('pagos', $data);
    $id_pago = $this->db->insert_id();
    foreach($dctos as $dcto)
    {
      $dcto['pago_id'] = $id_pago;
      $this->db->insert('pagos_dcto_relacionado', $dcto);
    }
    $this->db->trans_complete();
    return $this->db->trans_status();
  }
}

/* End of file Pagos_model.php */
