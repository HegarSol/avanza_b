<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config = [
   'empresas/add' => array(
      ['field' => 'rfc', 'label' => 'R.F.C.', 'rules' => 'required|min_length[12]|max_length[13]'],
      ['field' => 'nombre', 'label' => 'Nombre', 'rules' => 'required']
   ),
   'empresas/update' => array(
      ['field' => 'rfc', 'label' => 'R.F.C.', 'rules' => 'required|min_length[12]|max_length[13]'],
      ['field' => 'nombre', 'label' => 'Nombre', 'rules' => 'required']
   ),
   'empresas/save_config' => array(
      ['field' => 'smtp_host', 'label' => 'Host SMTP', 'rules' => 'required'],
      ['field' => 'smtp_port', 'label' => 'Puerto SMTP', 'rules' => 'required|numeric'],
      ['field' => 'smtp_user', 'label' => 'Usuario SMTP', 'rules' => 'required'],
      ['field' => 'pop_host', 'label' => 'Host POP', 'rules' => 'required'],
      ['field' => 'pop_port', 'label' => 'Puerto POP', 'rules' => 'required|numeric'],
	  ['field' => 'pop_user', 'label' => 'Usuario POP', 'rules' => 'required']
   )
];
