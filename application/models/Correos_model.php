<?php 
   defined('BASEPATH') or exit('No direct script access allowed');

   class Correos_model extends CI_Model
   {
      public function get($rfc_empresa)
      {
         return $this->db->where('rfc_empresa', $rfc_empresa)->from('correos')->get()->result();
      }

      public function delete($id)
      {
         $this->db->delete('correos', array('id' => $id));
         return $this->db->affected_rows();
      }

      public function add($data)
      {
         $this->db->insert('correos', $data);
         return $this->db->affected_rows();
      }

      public function getById($id)
      {
         return $this->db->from('correos')->where('id', $id)->get()->row();
      }

      public function update($id, $data)
      {
         $this->db->where('id', $id)->update('correos', $data);
         return $this->db->affected_rows();
      }

      public function getByEmisor($rfc_empresa, $rfc_emisor)
      {
         return $this->db->where('rfc_empresa', $rfc_empresa)
         ->where('rfc_emisor', $rfc_emisor)
         ->from('correos')
         ->get()
         ->result();
      }
   }
?>
