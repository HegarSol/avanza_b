<?php
defined("BASEPATH") or exit('No direct script access allowed');

class Usuarios extends MY_Controller
{

   public function __construct()
   {
      parent::__construct();
      if(!$this->aauth->is_admin()){
         redirect('welcome');
      }
      $this->load->model('UsuariosEmpresas_model', 'usEmp');
   }

   public function index()
   {
      $this->load->view('usuarios/index');
   }

   public function add()
   {
      $this->form_validation->set_rules('email','E-Mail', 'required|valid_email');
      $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
      $this->form_validation->set_rules('password', 'Contrase&ntilde;a', 'trim|required');
      $this->form_validation->set_rules('confirmacion', 'Confirmaci&oacute;n de
      Contrase&ntilde;a', 'trim|required|matches[password]');
      if(!$this->form_validation->run())
      {
         echo json_encode(['correcto' => FALSE, 'mensaje' =>
         validation_errors()]);
         return;
      }
      $correcto = $this->aauth->create_user($this->input->post('email'),
         $this->input->post('password'),
         $this->input->post('nombre')
      );
      if(!$correcto){
         echo json_encode(['correcto' => FALSE, 'mensaje' =>
         $this->aauth->get_errors_array()[0]]);
         return;
      }
      echo json_encode(['correcto' => TRUE]);
   }

   public function asignacion_empresas($id_usuario)
   {
      $this->load->model('Empresas_model', 'empresas');
      $data['empresas'] = $this->empresas->get_list_select($id_usuario);
      $data['asignadas'] = $this->empresas->get_permitidas($id_usuario);
      $data['id_usuario'] = $id_usuario;
      $data['nombre_usuario'] = $this->usEmp->get_nombre_usuario($id_usuario);
      $this->load->view('usuarios/asignacion', $data);
   }

   public function asignacion_empresas_save()
   {
      $id_usuario = $this->input->post('id_usuario');
      $rfc_empresa = $this->input->post('rfc_empresa');
      $accion = $this->input->post('accion');
      switch($accion)
      {
         case 'agrega':
            $success = $this->usEmp->add($this->input->post('id_usuario'), $this->input->post('rfc_empresa'));
            break;
         case 'borra':
            $success = $this->usEmp->remove($this->input->post('id_usuario'), $this->input->post('rfc_empresa'));
            break;
         default:
            $success = FALSE;
            break;
      }

      echo json_encode($success);
   }
}
