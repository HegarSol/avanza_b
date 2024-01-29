<?php

   defined('BASEPATH') or exit('No direct script access allowed');

   class Precios_model extends CI_Model
   {

	  public function getPrecioUnitario($cant){
		 $query = $this->db->select(array('precio'))
		 ->from('precios')
		 ->where('inicial <=', $cant)
		 ->where('final >=', $cant)
		 ->get();
		 if($query->num_rows() > 0){
			return $query->row()->precio;
		 }
		 return 0;
	  }

	  public function getImporte($cant){
		 $precio = $this->getPrecioUnitario($cant);
		 return $precio * $cant;
	  }
   }
