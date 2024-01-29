<?php defined('BASEPATH') or exit('No direct script access allowed');

class UsuariosEmpresas_model extends CI_Model
{
   public function add($id_usuario, $rfc_empresa)
   {
      $data['id_usuario'] = $id_usuario;
      $data['rfc_empresa'] = $rfc_empresa;
      $this->db->trans_start();
      $this->db->insert('usuario_empresa', $data);
      $this->db->trans_complete();
      return $this->db->trans_status();
   }

   public function remove($id_usuario, $rfc_empresa)
   {
      $this->db->trans_start();
      $this->db->where('id_usuario', $id_usuario)
      ->where('rfc_empresa', $rfc_empresa)
      ->delete('usuario_empresa');
      $this->db->trans_complete();
      return $this->db->trans_status();
   }

   public function get_nombre_usuario($id)
   {
      return $this->db->select(array('name'))
      ->from('aauth_users')
      ->where('id', $id)
      ->get()
      ->row()
      ->name;
      }

}
