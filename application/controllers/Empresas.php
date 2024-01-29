<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Empresas extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->model('empresas_model','empresas');
   }

   public function index()
   {
      if(!$this->aauth->is_admin()){
         $this->load->view('login/denied');
         return;
      }
      $data['empresas'] = $this->empresas->get_all();
      $this->load->view('empresas/index',$data);
   }

   public function add()
   {
      $response['status'] = TRUE;
      if($this->form_validation->run() === FALSE)
      { 
         $response['status'] = FALSE;
         $response['errors'] = validation_errors();
      } else {

         $data = array(
            'rfc' => $this->input->post('rfc'),
            'activo' => 0,
            'nombre' => $this->input->post('nombre'),
            'contabilidad_api' => $this->input->post('api_cont'),
            'activaMasiva' => $this->input->post('dmc'),
            'fechaMasiva' => $this->input->post('fechadmc')
         );
         $insert = $this->empresas->add($data);
      }
      header('Content-type: application/json');
      exit(json_encode($response));
   }

   public function update()
   {
      $response['status'] = TRUE;
      if($this->form_validation->run() === FALSE)
      {
         $response['status'] = FALSE;
         $response['errors'] = validation_errors();
      } else {
         $data['nombre'] = $this->input->post('nombre');
         $data['contabilidad_api'] = $this->input->post('api_cont');
         $data['activaMasiva'] = $this->input->post('dmc');
         $data['fechaMasiva'] = $this->input->post('fechadmc');
         $success = $this->empresas->update($this->input->post('rfc'), $data);
         if(!$success)
         {
            $response['status'] = FALSE;
            $response['errors'] = 'No se enviaron cambios para almacenar';
         }
      }
      header('Content-type: application/json');
      echo json_encode($response);
   }
   
   public function get($rfc_empresa)
   {
      header('Content-type: application/json');
      $data = $this->empresas->get_nombre($rfc_empresa);
      if(!$data){
         exit(json_encode(array('status' => FALSE, 'errors' => 'No se encontro la empresa especificada')));
      }
      $response['status'] = TRUE;
      $response['nombre'] = $data->nombre;
      $response['activaMasiva'] = $data->activaMasiva;
      $response['fechaMasiva'] = $data->fechaMasiva;
      $response['api'] = $this->empresas->getApiConfig($rfc_empresa);
      exit(json_encode($response));
   }

   public function delete()
   {
      $response['status'] = TRUE;
      $success = $this->empresas->delete($this->input->post('rfc'));
      if(!$success)
      {
         $response['status'] = FALSE;
         $response['errors'] = 'No se puede eliminar el registro';
      }
      header('Content-type: application/json');
      echo json_encode($response);
   }

   public function desactivar()
   {
      $response['status'] = TRUE;
      $success = $this->empresas->update($this->input->post('rfc'), array('activo' => 0));
      if(!$success)
      {
         $response['status'] = FALSE;
         $response['error'] = 'No se puede desactivar la empresa seleccionada';
      }
      header('Content-type: application/json');
      echo json_encode($response);
   }

   public function config($rfc = NULL)
   {
      if(!$rfc)
      {
         $rfc = $this->session->userdata('rfc_empresa');
      }
      $data['emp'] = $this->empresas->get_by_rfc($rfc);
      $this->load->view('empresas/configuracion',$data);
   }

   public function save_config()
   {
      $response['status'] = TRUE;
      if($this->form_validation->run() == FALSE)
      {
         $response['status'] = FALSE;
         $response['errors'] = validation_errors();
      } else 
      {
         $data = array();
         // Datos POP
         $data['host_pop'] = $this->input->post('pop_host');
         $data['user_pop'] = $this->input->post('pop_user');
         $data['port_pop'] = $this->input->post('pop_port');
         $data['ssl_pop'] = 0;
         if($this->input->post('pop_ssl'))
         {
            $data['ssl_pop'] = $this->input->post('pop_ssl');
         }
         if(!empty($this->input->post('pop_pass')))
         {
            $data['pass_pop'] = $this->encryption->encrypt($this->input->post('pop_pass'));
         }
         // Datos SMTP
         $data['host_smtp'] = $this->input->post('smtp_host');
         $data['user_smtp'] = $this->input->post('smtp_user');
         $data['port_smtp'] = $this->input->post('smtp_port');
         $data['ssl_smtp'] = 0;
         if($this->input->post('smtp_ssl'))
         {
            $data['ssl_smtp'] = $this->input->post('smtp_ssl');
         }
         if(!empty($this->input->post('smtp_pass')))
         {
            $data['pass_smtp'] = $this->encryption->encrypt($this->input->post('smtp_pass'));
         }

         // Otras Configuraciones
         $data['estricto'] = 0;
         if($this->input->post('estricto'))
         {
            $data['estricto'] = 1;
         }
         $update = $this->empresas->update($this->input->post('rfc_empresa'), $data);
         if(!$update)
         {
            $response['status'] = FALSE;
            $response['errors'] = 'No se modifico la informacion';
         }
      }
      header('Content-type: application/json');
      exit(json_encode($response));
   }
}
