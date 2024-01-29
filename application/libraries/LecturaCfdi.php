<?php
   defined('BASEPATH') or exit('No direct script access allowed');

   class LecturaCfdi
   {
	  const NO_ATTACHMENTS = 'El correo no contiene archivos adjuntos para procesar.';
	  const NO_PDF_FILE = 'No se encontro un documento PDF para la factura';
	  const NO_XML_FOUND = 'No se encontraron archivos xml para procesar';

	  protected $CI;
	  protected $rfc;
	  protected $uuid;
	  protected $fecha;
	  protected $emisor;
	  protected $datosEmp;

	  protected $mailman;
	  protected $originalMail;

	  public $lastError;


	  public function __construct()
	  {
		 $this->CI =& get_instance();
		 $this->mailman = new CkMailMan;
		 $this->mailman->put_ImmediateDelete(true);
     $this->mailman->put_ReadTimeout(60);
     $unlock = ENVIRONMENT == 'production' ? 'FRANCIMAILQ_4bW5HnfRoT9f' : 'FREE';
		 $success = $this->mailman->UnlockComponent($unlock);
		 if($success != TRUE){
			$this->lasError = 'Error al desbloquear el componente';
			log_message('error', $this->lastError);
			return FALSE;
		 }
		 $this->CI->load->model('Empresas_model','empresas');
		 $this->CI->load->model('Error_model', 'errores');
	  }

	  public function get_new_mails($rfc){
		 $this->rfc = $rfc;
		 $this->set_pop_params();
		 $this->set_smtp_params();
		 $this->set_configurations();
		 return $this->get_mails();
	  }

	  protected function set_pop_params()
	  {
		 $param = $this->CI->empresas->get_pop_params($this->rfc);
		 $this->mailman->put_MailHost($param->host_pop);
		 $this->mailman->put_PopUsername($param->user_pop);
		 $this->mailman->put_PopPassword($this->CI->encryption->decrypt($param->pass_pop));
		 $this->mailman->put_PopSsl($param->ssl_pop);
		 $this->mailman->put_MailPort($param->port_pop);
	  }

	  protected function set_smtp_params()
	  {
		 $param = $this->CI->empresas->get_smtp_params($this->rfc);
		 $this->mailman->put_SmtpHost($param->host_smtp);
		 $this->mailman->put_SmtpUsername($param->user_smtp);
		 $this->mailman->put_SmtpPassword($this->CI->encryption->decrypt($param->pass_smtp));
		 $this->mailman->put_SmtpSsl($param->ssl_smtp);
		 $this->mailman->put_SmtpPort($param->port_smtp);
		 if( $param->ssl_smtp == 1 ){
			 $this->mailman->put_SmtpSsl(TRUE);
		 }
		 if( $param->ssl_smtp == 2 ){
			 $this->mailman->put_StartTLS(TRUE);
		 }
	  }

	  protected function set_configurations()
	  {
		 $conf = $this->CI->empresas->get_by_rfc($this->rfc);
		 $this->datosEmp = $conf;
	  }

	  protected function get_mails()
	  {

     $bundle = $this->mailman->CopyMail();
		 if(is_null($bundle))
		 {
			$this->lastError = $this->mailman->lastErrorText();
			log_message('error', $this->lastError);
			return FALSE;
		 }
		 for($i = 0; $i <= $bundle->get_MessageCount() - 1; $i++)
		 {
			$this->originalMail = $bundle->GetEmail($i);
			if(is_null($this->originalMail))
			{
			   $this->lastError = $this->mailman->lastErrorText();
			   log_message('error', $this->lastError);
			   return FALSE;
			}
			$this->process_mail();
			$this->mailman->DeleteEmail($this->originalMail);
		 }
		 $success = $this->mailman->Pop3EndSession();
		 return $success;
	  }

	  protected function process_mail()
	  {
		 if($this->originalMail->get_NumAttachments() <= 0)
		 {
			log_message('error', self::NO_ATTACHMENTS);
			$this->saveLog(self::NO_ATTACHMENTS);
			return FALSE;
		 }
		 $this->process_attachments();
	  }

	  protected function process_attachments()
	  {
		 $arr_xml = array();
		 $arr_pdf = array();
		 for($i = 0; $i < $this->originalMail->get_NumAttachments(); $i++)
		 {
			$data['id'] = $i;
			$data['filename'] = $this->originalMail->getAttachmentFilename($i);
			$index = pathinfo($data['filename'], PATHINFO_FILENAME);
			$index = strtolower($index);
			switch(strtolower(pathinfo($data['filename'], PATHINFO_EXTENSION)))
			{
			   case 'xml':
			   $arr_xml[$index] = $data;
			   break;
			   case 'pdf':
			   $arr_pdf[$index] = $data;
			   break;
			   default:
			   continue;
			}
		 }
		 if(count($arr_xml) < 1)
		 {
			log_message('error', self::NO_XML_FOUND);
			$this->saveLog(self::NO_XML_FOUND);
			return FALSE;
		 }
		 foreach($arr_xml as $key => $file)
		 {
			if(!array_key_exists($key, $arr_pdf))
			{
			   $error = "El archivo: " . $file['filename'] . " No contiene un archivo PDF asociado";
			   log_message('error', $error);
			   $this->sendError($error);
			   continue;
			}
			$this->originalMail->SaveAttachedFile($file['id'], './tmp');
			$xmlContent = file_get_contents('./tmp/' . $file['filename']);
			if(!$this->process_xml($xmlContent))
			{
			   $error = $this->lastError . ": " . $file['filename'];
			   log_message('error', $error);
			   $this->sendError($error);
			   continue;
			} else {
			   $this->originalMail->SaveAttachedFile($file['id'], './tmp');
			   $this->originalMail->SaveAttachedFile($arr_pdf[$key]['id'], './tmp');
			   if(!$this->saveToDisk('./tmp/' . $file['filename'], './tmp/' . $arr_pdf[$key]['filename']))
			   {
				  log_message('error',$this->lastError);
			   }
			   $this->sendSuccess($file['filename']);
			}
		 }
	  }

	  protected function process_xml($xml)
	  {
			$encoding = mb_detect_encoding($xml);
			if ($encoding !== 'UTF-8'){
				$xml = utf8_encode($xml);
			}

		 $this->CI->load->library('cfdi');
		 if(!$this->CI->cfdi->loadXml($xml))
		 {
			$this->lastError = "Error al tratar de cargar el archivo para procesarlo";
			return FALSE;
		 }
		 if($this->datosEmp->estricto && $this->rfc != $this->CI->cfdi->get_receptor())
		 {
			$this->lastError = 'El RFC receptor del comprobante no corresponde al RFC de la empresa.';
			return FALSE;
		 }
		 // Valida el Sello del XML procesado
		 if(!$this->CI->cfdi->valida_sello())
		 {
			$this->lastError = "El Sello del comprobante no se encuentra bien formado o el documento fue alterado";
			return FALSE;
     }
     $this->CI->cfdi->referencia = $this->get_referencia($this->originalMail->subject());
		 // Intentamos almacenarlo en la base de datos
		 if(!$this->CI->cfdi->save_to_db($this->rfc,$xml))
		 {
			$this->lastError = "Error al almacener el comprobante. " . $this->CI->cfdi->lastError;
			return FALSE;
		 }
		 $this->uuid = $this->CI->cfdi->uuid;
		 $this->fecha = $this->CI->cfdi->fecha;
		 $this->emisor = $this->CI->cfdi->emisor;
		 return TRUE;
    }
    
    /**
     * Obtiene la referencia del asunto del correo
     * El asunto debe de contener el texto REFERENCIA:
     * 
     * @return string Referencia capturada en el asunto del correo
     */
    public function get_referencia($asunto)
    {
      if(strpos($asunto, 'REFERENCIA:') === false)
      {
        return null;
      }
      $pos = strpos($asunto, 'REFERENCIA:');
      $referencia = substr($asunto, $pos, strlen($asunto) - $pos);
      $referencia = substr_replace($referencia, "", 0, 11);
      return trim($referencia);
    }

	  protected function sendError($error)
	  {
		 $email = $this->genMail();
		 $data['proveedor'] = array('nombre' => $this->originalMail->fromName());
		 $data['aceptada'] = FALSE;
		 $data['nombreEmpresa'] = $email->fromName();
		 $data['motivo'] = $error;
		 $body = $this->CI->load->view('mail_messages/respuesta', $data, TRUE);
		 $email->SetHtmlBody($body);
		 $success = $this->mailman->SendEmail($email);
		 if($success == FALSE){
			$this->lastError = $this->mailman->lastErrorText();
			return FALSE;
		 }
		 $this->saveLog($error);
		 return TRUE;
	  }

	  protected function sendSuccess($fileName)
	  {
		 $email = $this->genMail();
		 $data['filename'] = $fileName;
		 $data['proveedor'] = array('nombre' => $this->originalMail->fromName());
		 $data['aceptada'] = TRUE;
		 $data['nombreEmpresa'] = $email->fromName();
		 $body = $this->CI->load->view('mail_messages/respuesta', $data, TRUE);
		 $email->SetHtmlBody($body);
		 $success = $this->mailman->SendEmail($email);
		 if($success == FALSE)
		 {
			log_message('error', $this->mailman->lastErrorText());
			return FALSE;
		 }
		 return TRUE;
	  }

	  protected function genMail()
	  {
		 $mail = new CkEmail();
		 $mail->put_Subject('Re: ' . $this->originalMail->Subject());
		 $mail->put_FromAddress($this->mailman->smtpUsername());
		 $mail->put_FromName($this->CI->empresas->get_nombre($this->rfc)->nombre);
		 $correos = 0;
		 // Buscamos si el RFC tiene direccionamiento de correos registrados
		 if(!empty($this->emisor))
		 {
			$this->CI->load->model('Correos_model', 'correos');
			$listado = $this->CI->correos->getByEmisor($this->rfc, $this->emisor);
			foreach($listado as $row)
			{
			   $mail->AddTo($this->originalMail->fromName(), $row->email);
			   $correos++;
			}
		 }
		 if($correos == 0)
		 {
			$mail->AddTo($this->originalMail->fromName(), $this->originalMail->fromAddress());
		 }
		 return $mail;
	  }

	  protected function saveLog($error){
		 /**
		 ** Proceso para almacenar en la base de datos el log de los errores
		 **/
		 $this->CI->load->helper('date');
		 $data['rfc'] = $this->rfc;
		 $data['from'] = $this->originalMail->fromAddress();
		 $data['when'] = date('Y-m-d H:i:s', strtotime($this->originalMail->emailDateStr()));
		 $data['subject'] = $this->originalMail->Subject();
		 $data['log'] = $error;
		 $this->CI->errores->add_error($data);
	  }

	  /**
	  ** Proceso para almacenar el XML y FTP en la carpeta local que se especifico en la configuracion
	  **/
	  protected function saveToDisk($xml, $pdf)
	  {
		 $this->CI->config->load('hegarss');
		 $config = $this->CI->config->item('path_save');
		 $path = $config  . DIRECTORY_SEPARATOR . $this->rfc . DIRECTORY_SEPARATOR . $this->emisor
		 . DIRECTORY_SEPARATOR . date('Y', strtotime($this->fecha)) . DIRECTORY_SEPARATOR . date('m', strtotime($this->fecha));
		 if(!is_dir($path) && !mkdir($path, 0777, TRUE)){
			$this->lastError = 'No se puede crear la ruta para almacenar los archivos';
			return FALSE;
		 }
		 $Destino = $path . DIRECTORY_SEPARATOR . strtolower($this->uuid);
		 if(!copy($xml, $Destino . '.xml')){
			 $this->lastError = 'No se puede copiar el archivo XML';
			 return FALSE;
		 }
		 if(!copy($pdf, $Destino . '.pdf')){
			 $this->lastError = 'No se puede copiar al archivo PDF';
			 return FALSE;
		 }
		 unlink($xml);
		 unlink($pdf);
		 $this->CI->load->model('Comprobantes_model','comp');
		 $this->CI->comp->update_comprobante($this->uuid, array('path' => $Destino));
		 return TRUE;
	  }

   }
