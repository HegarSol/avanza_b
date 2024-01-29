<?php defined('BASEPATH') or exit('No direct script access allowed');

   class Errores_model extends CI_Model{
      public function getByRfc($rfc)
      {
         return $this->db->where('rfc', $rfc)
         ->from('error_log')
         ->get()->result();
      }
   }
