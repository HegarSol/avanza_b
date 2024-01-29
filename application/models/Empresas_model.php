<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Empresas_model extends CI_Model
{
   public function get_all()
   {
      $this->db->from('empresas');
      $query = $this->db->get();
      return $query->result();
   }

   public function get_list_select($id_usuario)
   {
      $asignados = $this->db->select(array('rfc_empresa'))
      ->where('id_usuario', $id_usuario)
      ->from('usuario_empresa')
      ->get_compiled_select();

      return $this->db->select(array('rfc', 'nombre'))
      ->from('empresas')
      ->where("`rfc` NOT IN ($asignados)", NULL, FALSE)
      ->get()
      ->result();
   }

   public function get_activas()
   {
      return $this->db->select(array('rfc'))->from('empresas')->where('activo' , 1)->get()->result();
   }

   public function add($data)
   {
      $this->db->insert('empresas', $data);
      return $this->db->insert_id();
   }

   public function update($rfc, $data)
   {
      $this->db->where('rfc', $rfc)
      ->update('empresas', $data);
      return $this->db->affected_rows();
   }

   public function delete($rfc)
   {
      $this->db->where('rfc', $rfc)->delete('empresas');
      return $this->db->affected_rows();
   }

   public function get_pop_params($rfc)
   {
      $this->db->select(['host_pop','user_pop','pass_pop','port_pop', 'ssl_pop']);
      $this->db->from('empresas');
      $this->db->where('rfc',$rfc);
      $query = $this->db->get();
      return $query->row();
   }

   public function get_smtp_params($rfc)
   {
      $this->db->select(['host_smtp', 'user_smtp', 'pass_smtp', 'port_smtp', 'ssl_smtp']);
      $this->db->from('empresas');
      $this->db->where('rfc', $rfc);
      $query = $this->db->get();
      return $query->row();
   }

   public function get_ftp_params($rfc)
   {
      return $this->db->select(['ftp_host', 'ftp_user', 'ftp_pass', 'ftp_port', 'ftp_path'])
      ->from('empresas')
      ->where('rfc' , $rfc)
      ->get()->row();

   }

   public function get_nombre($rfc)
   {
      $this->db->select(['nombre','activaMasiva','fechaMasiva']);
      $this->db->from('empresas');
      $this->db->where('rfc', $rfc);
      $query = $this->db->get();
      return $query->row();
   }

   public function get_permitidas($id_user, $admin = FALSE){
      $this->db->select(array('rfc', 'nombre', 'contabilidad_api'))
      ->from('empresas');
      if(!$admin)
      {
         $this->db->join('usuario_empresa', 'empresas.rfc = usuario_empresa.rfc_empresa');
         $this->db->where('usuario_empresa.id_usuario', $id_user);
      }
      $query = $this->db->get();
      return $query->result();
   }

   public function get_by_rfc($rfc)
   {
      return $this->db->from('empresas')
      ->where('rfc', $rfc)
      ->get()
      ->row();
   }
   public function getmasiva($rfc)
   {
      return $this->db
      ->from('empresas')
      ->where('rfc',$rfc)
      ->get()
      ->row();
   }
    
    public function getModoEstricto($rfc_empresa){
        return $this->db->select(array('estricto'))
            ->from('empresas')
            ->where('rfc', $rfc_empresa)
            ->get()
            ->row()
            ->estricto;
    }

    public function getApiConfig($rfc_empresa){
        return $this->db->select(array('contabilidad_api'))
        ->from('empresas')
        ->where('rfc', $rfc_empresa)
        ->get()
        ->row()
        ->contabilidad_api;
    }
}
