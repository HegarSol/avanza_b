<?php

class Receptores_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
    }

    public function getAll($rfc_empresa){
        return $this->db->from('receptores')
        ->where('rfc_empresa', $rfc_empresa)
        ->get()
        ->result();
    }

    public function add($rfcEmpresa, $rfcReceptor, $nombreReceptor){
        if($this->exists($rfcEmpresa, $rfcReceptor)){
            return FALSE;
        }
        $data = array(
            'rfc_empresa' => $rfcEmpresa,
            'rfc_receptor' => $rfcReceptor,
            'nombre_receptor' => $nombreReceptor
        );

        $this->db->insert('receptores', $data);
        return ($this->db->affected_rows() != 1) ? FALSE : TRUE;
    }

    public function exists($rfcEmpresa, $rfcReceptor){
        $this->db->from('receptores')
        ->where('rfc_empresa', $rfcEmpresa)
        ->where('rfc_receptor', $rfcReceptor);
        return ($this->db->count_all_results() > 0) ? TRUE : FALSE;
    }
}