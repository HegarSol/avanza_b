<?php
   defined('BASEPATH') or exit('No direct script access alloew');
   class Login extends CI_Controller
   {
	  public function __construct()
	  {
		 parent::__construct();
		 $this->load->library('form_validation');
	  }

	  public function index()
	  {
		 if($this->aauth->is_loggedin()){
			redirect('Welcome');
		 }
		 $this->load->view('templates/header');
		 $this->load->view('login/index');
		 $this->load->view('templates/footer');
	  }

	  public function login_user()
	  {
		 $this->form_validation->set_rules('user', 'Usuario', 'trim|required|valid_email');
		 $this->form_validation->set_rules('pass', 'Contrase&ntilde;a', 'trim|required|callback_check_user');
		 if(!$this->form_validation->run())
		 {
			$this->index();
			return;
		 }
		 redirect('welcome');
	  }

	  public function check_user($pass)
	  {
		 $email = $this->input->post('user');
		 $remember = !is_null($this->input->post('remember'));
		 if($this->aauth->login($email, $pass, $remember))
		 {
			return TRUE;
		 }
		 $this->form_validation->set_message('check_user', "Usuario o Contrase&ntilde;a Incorrecto");
		 return FALSE;
	  }

	  public function logout_user()
	  {
		 $this->aauth->logout();
		 redirect('login');
	  }

	  public function seleccionar_empresa(){
		 if(!$this->aauth->is_loggedin())
		 {
			redirect('login');
		 }
		 $this->load->model('Empresas_model', 'empresas');
		 $empresas = $this->empresas->get_permitidas($this->aauth->get_user_id(), $this->aauth->is_admin());
		 if(count($empresas) == 0){
			$this->session->sess_destroy();
			show_error("Su usuario no cuenta con una empresa asignada, favor de comunicarse con el
			administrador",200,"No se encuentra empresa");
		 }
		 if(count($empresas) == 1){
			$row = $empresas[0];
			$this->session->set_userdata('rfc_empresa', $row->rfc);
			$this->session->set_userdata('nombre_empresa', $row->nombre);
			$this->session->set_userdata('unica_empresa' , TRUE);
			$this->session->set_userdata('usa_api_contabilidad', $row->contabilidad_api);
			redirect('welcome');
		 }
		 $data['empresas'] = $empresas;
		 $this->load->view('selecciona_empresa', $data);
	  }

	  public function set_empresa(){
		 if(!$this->aauth->is_loggedin())
		 {
			redirect('login');
		 }
		 $this->load->model('Empresas_model', 'empresa');
		 $this->session->set_userdata('rfc_empresa', $this->input->post('empresa'));
		 $this->session->set_userdata('nombre_empresa', $this->empresa->get_nombre($this->input->post('empresa')));
		 $this->session->set_userdata('unica_empresa', FALSE);
		 $this->session->set_userdata('usa_api_contabilidad',
		 	$this->empresa->getApiConfig($this->input->post('empresa'))
		 );
		 redirect('welcome');
	  }

	  public function cambia_empresa(){
		 $this->session->unset_userdata(array('rfc_empresa', 'nombre_empresa', 'unica_empresa'));
		 redirect('login/seleccionar_empresa');
		 }
   }
