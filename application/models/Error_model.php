<?php
   defined('BASEPATH') or exit('No direct script access allowed');

   class Error_model extends CI_Model
   {
      public function add_error($data)
      {
         $this->db->insert('error_log', $data);
         return $this->db->insert_id();
      }
   }
