<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Certificados_model extends CI_Model 
{
  public function get_all($empresa)
  {
    $query = $this->db->where('empresa', $empresa)
    ->from('certificados')
    ->get();
    return $query->result();
  }

  public function add($data)
  {
    $this->db->trans_start();
    $this->db->insert('certificados', $data);
    $this->db->trans_complete();
    return $this->db->trans_status();
  }

  public function delete($empresa, $no_certificado)
  {
    $this->db->where('empresa', $empresa)
    ->where('no_certificado', $no_certificado)
    ->delete('certificados');
    return $this->db->affected_rows();
  }

  public function get_valid($empresa)
  {
    $query = $this->db->select(['pfx', 'pass'])
    ->from('certificados')
    ->where('empresa', $empresa)
    ->where('fecha_vence >= NOW()', NULL, FALSE)
    ->limit(1);

    return $query->get()->row();

  }
}

/* End of file Certificados_model.php */
