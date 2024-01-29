<?php
/**
 * @autor Ing. Guadalupe Garza Moreno
 * @date 10 Oct 2017
 * 
 * Cotrolador para mostrar y procesar los comprobantes que no han sido aceptados
 * o rechazados del sistema. Este controlador solo esta disponible si la empresa
 * no se encuentra usando la API de Contabilidad. Esto con el fin de evitar que 
 * informacion se encuentre incorrecta en el sistema de contabilidad
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendientes extends MY_Controller {

    public function __construct(){
        parent::__construct();
        if($this->session->usa_api_contabilidad){
            show_error(
            'No se puede acceder a esta funcionalidad ya que se utliza la API',
            200,
            'Modulo desactivado'
        );
        }
        $this->load->model('Comprobantes_model', 'comprobantes');
    }

    public function index()
    {
        $data['comprobantes'] = $this->comprobantes->get_faltantes_by_empresa(
            $this->session->rfc_empresa
        );
        $this->load->view('pendientes/index', $data);    
    }

    /**
     * Funcion para aceptar un comprobante, la descripcion de la factua es 
     * opcional y solo se usa como referencia para identificarla mas facil.
     * Se debe de mandar llamar desde Ajax
     */
    public function acepta(){
        $this->form_validation->set_rules('uuid','UUID','required');
        if( $this->form_validation->run() == FALSE ){
            exit(json_encode(['success' => FALSE, 'errors' => validation_errors()]));
        }
        $data['status'] = 'A';
        $data['descripcion'] = $this->input->post('mensaje');
        $this->comprobantes->update_comprobante(
            $this->input->post('uuid'),
            $data
        );
        echo json_encode(array('success' => TRUE));
    }

    /**
     * Funcion para rechazar un comprobante mediante la aplicacion web
     * El motivo por el cual fue rechazada es obligatorio.
     * Se debe mandar llamar desde Ajax
     */
    public function rechaza(){
        $this->form_validation->set_rules('uuid', 'UUID', 'required');
        $this->form_validation->set_rules('mensaje', 'Motivo', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            exit(
                json_encode(
                    array('success' => FALSE, 'errors' => validation_errors())
                )
            );
        }
        $data['status'] = 'R';
        $data['error'] = $this->input->post('mensaje');
        $this->comprobantes->update_comprobante(
            $this->input->post('uuid'),
            $data
        );
        echo json_encode(array('success' => TRUE));
    }

}

/* End of file Pendientes.php */
