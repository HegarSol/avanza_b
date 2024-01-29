<?php
defined("BASEPATH") or exit('No direct script access allowed');
class Comprobantes extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->model('Comprobantes_model', 'Comp');
      $this->load->model('Empresas_model', 'emp');
   }

   public function index()
   {
      $this->load->view('comprobantes/index');
   }

   public function ajax_table()
   {
      $this->load->library('Datatable', array('model' => 'Dt_Comprobantes_model'));
      $json = $this->datatable->datatableJson();
      $this->output->set_header("Pragma: no-cache");
      $this->output->set_header("Cache-Control: no-store, no-cache");
      $this->output->set_content_type('application/json')->set_output(json_encode($json));
   }

   public function ver($uuid)
   {
     $comp = $this->Comp->get_by_uuid(($uuid));
     if(!$comp){
       show_error('No se encontro el comprobante especificado', 200, 'Error');
     }
      $data['comprobante'] = $this->Comp->get_by_uuid($uuid);

      $this->load->view('comprobantes/ver', $data);
   }
   public function descargarmultiplepdf($ini,$fin)
   {

      // $CI =& get_instance();
      // $CI->config->load('hegarss', TRUE);
      // $base_path = $CI->config->item('xml_base_path', 'hegarss');


      // $this->load->helper('download');
      // $empresa = $this->session->userdata('rfc_empresa');
      
      $zipname = $ini.'-'.$fin. '_PDF'.'.zip';
      $zip = new ZipArchive;
      $zip->open($zipname, ZipArchive::CREATE);

      $comp = $this->Comp->get_by_fecha($ini,$fin);

      foreach($comp as $comps)
      {
            $fileName = $comps->path . '.pdf';
            if(!is_file($fileName)){
               
            }
            else
            {
                  $zip->addFile($fileName,'PDF/'. $comps->uuid . '.pdf');               
            }      
      }
      $zip->close();

      // $nuevaruta =  $base_path . $empresa . DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR . $ini.'-'.$fin . DIRECTORY_SEPARATOR;
      // if(!file_exists($nuevaruta))
      // {
      //    mkdir($nuevaruta,0777,TRUE);
      // }
      //   $nombrearchivo = $ini.'-'.$fin.'.zip';
      //   $atar = file_get_contents($zipname);
      //   file_put_contents($nuevaruta . $nombrearchivo, $atar);
      
 
      header("Content-type: application/octet-stream");
      header("Content-disposition: attachment; filename=".$zipname);
 
      // leemos el archivo creado
      readfile($zipname);
      unlink($zipname);
      //   $rutaarchivo = $nuevaruta . $nombrearchivo;
      //   $obtener = file_get_contents($rutaarchivo);
      //   force_download($nombrearchivo,$obtener);
     
   }
   public function descargarmultiplexml($ini,$fin)
   {

      // $CI =& get_instance();
      // $CI->config->load('hegarss', TRUE);
      // $base_path = $CI->config->item('xml_base_path', 'hegarss');

      // $this->load->helper('download');
      // $empresa = $this->session->userdata('rfc_empresa');

      $zipname = $ini .' - '. $fin. '_XML'.'.zip';
      $zip = new ZipArchive;
      $zip->open($zipname, ZipArchive::CREATE);

      $comp = $this->Comp->get_by_fecha($ini,$fin);

      foreach($comp as $comps)
      {
            $fileName = $comps->path . '.xml';
            if(!is_file($fileName)){
               
            }
            else
            {
                  $zip->addFile($fileName,'XML/'. $comps->uuid. '.xml');  
            }      
      }
      $zip->close();

      // $nuevaruta = $base_path . $empresa . DIRECTORY_SEPARATOR . 'xml' . DIRECTORY_SEPARATOR .$ini.'-'.$fin . DIRECTORY_SEPARATOR;
      // if(!file_exists($nuevaruta));
      // {
      //    mkdir($nuevaruta,0777,TRUE);
      // }
      // $nombrearchivo = $ini.'-'.$fin.'.zip';
      // $atar = file_get_contents($zipname);
      // file_put_contents($nuevaruta.$nombrearchivo,$atar);
      header("Content-type: application/octet-stream");
      header("Content-disposition: attachment; filename=".$zipname);
 
      // leemos el archivo creado
      readfile($zipname);
      unlink($zipname);

      //   header('Content-type: application/zip');
      //   $rutaarchivo = $nuevaruta . $nombrearchivo;
      //   $obtener = file_get_contents($rutaarchivo);
      //   force_download($nombrearchivo,$obtener);

   }
   public function descargarXML($uuid)
   {
      $this->load->helper('download');
      $comp = $this->Comp->get_by_uuid($uuid);
      if(!$comp){
           echo "No se encontro el registro del comprobante";
           return;
      }
      $fileName = $comp->path . '.xml';
      if(!is_file($fileName)){
         echo 'No se encontro el documento solicitado';
         return;
      }
       $content = file_get_contents($fileName);

       header('Content-Type: text/xml; charset=UTF-8');
       //echo $content;
       force_download($uuid.'.xml',$content);
   }
   public function descargarPDF($uuid)
   {

    $this->load->helper('download');
       $comp = $this->Comp->get_by_uuid($uuid);
       if(!$comp){
            echo "No se encontro el registro del comprobante";
            return;
       }
       $fileName = $comp->path . '.pdf';
       if(!is_file($fileName)){
          echo 'No se encontro el documento solicitado';
          return;
       }
        $content = file_get_contents($fileName);

        header('Content-type: application/pdf; base64');
        //echo $content;
        force_download($uuid.'.pdf',$content);
   }
   public function pdf($uuid)
   {
	  $comp = $this->Comp->get_by_uuid($uuid);
	  if(!$comp){
		 echo 'No se encontro el registro del comprobante';
		 return;
	  }
	  $fileName = $comp->path . '.pdf';
	  if(!is_file($fileName)){
		 echo 'No se encontro el documento solucitado';
		 return;
	  }
	  $content = file_get_contents($fileName);
	  header('Content-type: application/pdf; base64');
	  echo $content;
   }

   public function xml($uuid)
   {
	  $comp = $this->Comp->get_by_uuid($uuid);
	  if(!$comp){
		 echo 'No se encontro el registro del comprobante';
		 return;
	  }
	  $fileName = $comp->path . '.xml';
	  if(!is_file($fileName)){
		 echo 'No se encontro el documento solicitado';
		 return;
	  }
	  $content = file_get_contents($fileName);
	  header('Content-Type: text/xml; charset=UTF-8');
	  echo $content;
   }

   public function load_modal()
   {
	  if(!$this->input->is_ajax_request()){
		 echo 'No se puede ver la vista directamente';
		 exit();
	  }
	  $this->load->view('comprobantes/modal');
   }

   public function delete(){
     if(!$this->input->is_ajax_request()){
       exit('No se puede accesar al metodo ditectamente');
     }
     $this->load->library('Cfdi');
     header('Content-Type: application/json');
     echo json_encode(
       array(
        'success' => $this->cfdi->delete($this->input->post('uuid')),
        'error' => $this->cfdi->lastError
       )
     );
   }
}
?>
