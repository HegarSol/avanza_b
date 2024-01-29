<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Acuse_model extends CI_Model {

  public function add($data){
    $this->db->trans_start();
    $this->db->insert('acuse_cancelacion', $data);
    $this->db->trans_complete();
    return $this->db->trans_status();
  }

}

/* End of file Acuse_model.php */
