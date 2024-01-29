<?php 
require(APPPATH . 'libraries/REST_Controller.php');

class Empresas extends REST_Controller
{
   public function __construct()
   {
      parent::__construct('rest_web');
      $this->load->model('Empresas_model', 'empresas');
      $this->load->library('Chilkat');
   }

   public function smtp_check_get($rfc)
   {
      $params = $this->empresas->get_by_rfc($rfc);

      if(!$params)
      {
         $this->response(array('status' => false, 'error' => 'No se encontraron los datos de conexion de la empresa'));
      }
      $mailman = new CkMailMan();
      $mailman->put_ReadTimeout(60);
      $success = $mailman->UnlockComponent('FRANCIMAILQ_4bW5HnfRoT9f');
      if(!$success)
      {
         $this->response(array('status' => false, 'error' => 'No se puede desbloquear al componente de correos'));
      }
      $mailman->put_SmtpHost($params->host_smtp);
      $mailman->put_SmtpUsername($params->user_smtp);
      $mailman->put_SmtpPassword($this->encryption->decrypt($params->pass_smtp));
      $mailman->put_SmtpPort($params->port_smtp);
      if($params->ssl_smtp == 1){
        $mailman->put_SmtpSsl(TRUE);
      }
      if($params->ssl_smtp == 2){
        $mailman->put_StartTLS(TRUE);
      }
      $success = $mailman->OpenSmtpConnection();
      if(!$success)
      {
		    $this->response(
          array(
            'status' => FALSE,
            'error' => $mailman->lastErrorText() . $mailman->smtpFailReason()
          )
        );
      }
      $mailman->CloseSmtpConnection();
      $this->response(array('status' => TRUE));
   }

   public function pop_check_get($rfc)
   {
      $params = $this->empresas->get_by_rfc($rfc);
      if(!$params)
      {
         $this->response(array('status' => FALSE, 'error' => 'No se puede recuperar la informacion de la empresa'));
      }
      $mailman = new CkMailMan();
      $success = $mailman->UnlockComponent('FRANCIMAILQ_4bW5HnfRoT9f');
      if(!$success)
      {
         $this->response(array('status' => false, 'error' => 'No se puede desbloquear al componente de correos'));
      }
      $mailman->put_MailHost($params->host_pop);
      $mailman->put_PopUsername($params->user_pop);
      $mailman->put_PopPassword($this->encryption->decrypt($params->pass_pop));
      $mailman->put_PopSsl($params->ssl_pop);
      $mailman->put_MailPort($params->port_pop);

	  $success = $mailman->Pop3BeginSession();
	  if(!$success){
		 $this->response(array('status' => FALSE, 'error' => 'No se puede conectar con el servidor: ' . $mailman->lastErrorText()));
	  }
	  $mailman->Pop3EndSession();
	  $this->response(array('status' => TRUE));
   }

   public function activar_post()
   {
      $data['activo'] = 1;
      $success = $this->empresas->update($this->post('rfc'), $data);
      if(!$success)
      {
         $this->response(array('status' => FALSE, 'error' => 'No se actualizo la informacion'));
      }
      $this->response(array('status' => TRUE));
   }
}
