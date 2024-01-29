<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Correos extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->model('Correos_model', 'correos');
   }

   public function index()
   {
      $data['correos'] = $this->correos->get($this->session->userdata('rfc_empresa'));
      $this->load->view('correos/index', $data);
   }

   public function delete()
   {
      $response['success'] = TRUE;
      $success = $this->correos->delete($this->input->post('id'));
      if(!$success)
      {
         $response['success'] = FALSE;
         $response['message'] = 'No se puede eliminar el registro del correo';
      }
      echo json_encode($response);
   }

   public function add()
   {
      $this->set_validation();
      if($this->form_validation->run() == FALSE){
         exit(json_encode(['success' => FALSE, 'errors' => validation_errors()]));
      }
      $data['rfc_empresa'] = $this->session->userdata('rfc_empresa');
      $data['rfc_emisor'] = $this->input->post('rfc_emisor');
      $data['email'] = $this->input->post('email');
      $success = $this->correos->add($data);
      if($success)
      {
         $response['success'] = TRUE;
      } else {
         $response['success'] = FALSE;
         $response['errors'] = 'No se puede almacenar la informacion en estos momentos';
      }
      echo json_encode($response);
   }

   public function get($id)
   {
      echo json_encode($this->correos->getById($id));

   }

   public function edit()
   {
      $this->set_validation();
      if($this->form_validation->run() == FALSE)
      {
         exit(json_encode(['success' => FALSE, 'errors' => validation_errors()]));
      }
      $data['rfc_emisor'] = $this->input->post('rfc_emisor');
      $data['email'] = $this->input->post('email');
      $success = $this->correos->update($this->input->post('id'), $data);
      if($success)
      {
         $response['success'] = TRUE;
      } else {
         $response['success'] = FALSE;
         $response['errores'] = 'No se puede almacenar la informacion en estos momentos';
      }
      echo json_encode($response);
   }

   protected function set_validation()
   {
      $this->form_validation->set_rules('rfc_emisor', 'R.F.C.', 'required|min_length[12]|max_length[13]');
      $this->form_validation->set_rules('email', 'Correo Electr&oacute;nico', 'required|valid_email');
   }
}
?>
