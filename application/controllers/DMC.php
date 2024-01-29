<?php
defined("BASEPATH") or exit('No direct script access allowed');

class DMC extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
   }
   public function index()
   {

        $this->load->model('Empresas_model','empresas');
        $empresa = $this->session->userdata('rfc_empresa');
        $data = $this->empresas->getmasiva($empresa);

        if($data->activaMasiva == 1)
        {
            $this->load->view('dmc/index');
        }
        else
        {
            redirect('welcome');
        }
         
   }
   public function descargapdfrecibidos()
   {
        $valor = $_POST['valor2'];

        $uuids = explode(',',$valor);

        $zipname = date('Y-m-d').'_PDF_recibidos'.'.zip';
        $zip = new ZipArchive;
        $zip->open($zipname,ZipArchive::CREATE);
        foreach($uuids as $archi)
        {
            if('descargas'.DIRECTORY_SEPARATOR.$archi.'.pdf')
            {
                $algo = 'descargas'.DIRECTORY_SEPARATOR.$archi.'.pdf';
            }
                    
            $zip->addFile($algo);
        }
    
        $zip->close();

        header('Content-Type: text/xml; charset=UTF-8');
        header("Content-disposition: attachment; filename=".$zipname);
        
        readfile($zipname);
        unlink($zipname);

        foreach($uuids as $archi)
        {
            unlink('descargas'.DIRECTORY_SEPARATOR.$archi.'.pdf');          
        }       
   }
   public function descargaxmlrecibidos()
   {        
       $valor = $_POST['valor'];
        
        $uuids = explode(',',$valor);

        $zipname = date('Y-m-d').'_XML_recibidos'.'.zip';
        $zip = new ZipArchive;
        $zip->open($zipname,ZipArchive::CREATE);
        foreach($uuids as $archi)
        {
                if('descargas'.DIRECTORY_SEPARATOR.$archi.'.xml')
                {
                    $algo = 'descargas'.DIRECTORY_SEPARATOR.$archi.'.xml';
                }
                        
            $zip->addFile($algo);
        }
    
        $zip->close();

        header('Content-Type: text/xml; charset=UTF-8');
        header("Content-disposition: attachment; filename=".$zipname);
        
        readfile($zipname);
        unlink($zipname);

            foreach($uuids as $archi)
            {
                unlink('descargas'.DIRECTORY_SEPARATOR.$archi.'.xml');          
            }
    }
    public function descargaxmlemitidos()
    {

        $valor = $_POST['valor3'];

        $uuids = explode(',',$valor);

        $zipname = date('Y-m-d').'_XML_emitidos'.'.zip';
        $zip = new ZipArchive;
        $zip->open($zipname,ZipArchive::CREATE);
        foreach($uuids as $archi)
        {
                if('descargas'.DIRECTORY_SEPARATOR.$archi.'.xml')
                {
                    $algo = 'descargas'.DIRECTORY_SEPARATOR.$archi.'.xml';
                }
                        
            $zip->addFile($algo);
        }
    
        $zip->close();

        header('Content-Type: text/xml; charset=UTF-8');
        header("Content-disposition: attachment; filename=".$zipname);
        
        readfile($zipname);
        unlink($zipname);

            foreach($uuids as $archi)
            {
                unlink('descargas'.DIRECTORY_SEPARATOR.$archi.'.xml');          
            }
    }
    public function descargapdfemitidos()
    {
        $valor = $_POST['valor4'];

        $uuids = explode(',',$valor);

        $zipname = date('Y-m-d').'_PDF_emitidos'.'.zip';
        $zip = new ZipArchive;
        $zip->open($zipname,ZipArchive::CREATE);
        foreach($uuids as $archi)
        {
                if('descargas'.DIRECTORY_SEPARATOR.$archi.'.pdf')
                {
                    $algo = 'descargas'.DIRECTORY_SEPARATOR.$archi.'.pdf';
                }
                        
            $zip->addFile($algo);
        }
    
        $zip->close();

        header('Content-Type: text/xml; charset=UTF-8');
        header("Content-disposition: attachment; filename=".$zipname);
        
        readfile($zipname);
        unlink($zipname);

            foreach($uuids as $archi)
            {
                unlink('descargas'.DIRECTORY_SEPARATOR.$archi.'.pdf');          
            }
    }
}

?>