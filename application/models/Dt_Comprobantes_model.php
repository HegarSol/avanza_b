<?php defined("BASEPATH") or exit('No direct script access allowed');

class Dt_Comprobantes_model extends CI_Model implements DatatableModel
{
   public function appendToSelectStr()
   {
      return NULL;
   }

   public function fromTableStr()
   {
      return 'comprobantes c';
   }

   public function joinArray()
   {
      return NULL;
   }

   public function whereClauseArray()
   {
      return array('c.empresa' => $this->session->userdata('rfc_empresa'));
   }
}
?>
