<?php if (! defined('BASEPATH')) {
	  exit('No direct script access allowed');
   }

   class Tools extends CI_Controller
   {
	  public function __construct()
	  {
		 parent::__construct();
		 // Solo puede ser llamada desde la consola
		 if (!is_cli()) {
			exit('No esta permitido el acceso directo. Esta es una herramienta de consola. Usa la terminal');
		 }
	  }

	  public function index()
	  {
		 $this->help();
	  }

	  public function help()
	  {
		 echo "Estos son los comandos disponibles en la interface\n\n" . PHP_EOL;
		 echo "php index.php tools migration \"nombre_archivo\"   -> Crea un nuevo archivo de migration." . PHP_EOL;
		 echo "php index.php tools check_mails                    -> Revisa y descarga los correos para ser analizados y almacenados." . PHP_EOL;
		 echo "php index.php tools new_encryption_key             -> Genera una nueva llave para la encriptacion de informacion" . PHP_EOL;
	  }

	  public function migration($name)
	  {
		 $this->make_migration_file($name);
	  }

	  protected function make_migration_file($name, $cliente = FALSE)
	  {
		 $date = new DateTime();
		 $timestamp = $date->format('YmdHis');
		 $table_name = strtolower($name);
		 $path = APPPATH . "migrations/$timestamp" . "_" . "$name.php";
		 $class = "CI_Migration";
		 if($cliente){
			$path = APPPATH . "migrations/clientes/$timestamp" . "_" . "$name.php";
			$class = 'MY_Migration';
		 }
		 $my_migration = fopen($path, 'w') or die("No se puede crear el archivo de migracion");

		 $migration_template = "<?php
			class Migration_$name extends $class{
			   public function up()
			   {
				  }

				  public function down()
				  {
					 }
				  }";
				  fwrite($my_migration, $migration_template);
				  fclose($my_migration);

				  echo "$path migration creada correctamente" . PHP_EOL;
			   }

			   public function check_mails()
			   {
				  $this->load->model('Empresas_model', 'empresas');
				  $this->load->library('LecturaCfdi');
          $emp = $this->empresas->get_activas();
				  foreach($emp as $empresa)
				  {
					  $this->lecturacfdi->get_new_mails($empresa->rfc);
				  }
			   }

			   public function new_encryption_key()
			   {
				  echo bin2hex($this->encryption->create_key(16)) . PHP_EOL;
			   }

			   /** 

			   Funcion para recuperar de la carpeta de temporales los archivos que no se almacenaron en la carpeta destino
			   **/
			   public function check_files()
			   {
				  $this->load->helper('file');

				  $archivos = get_dir_file_info('./tmp/');
				  foreach($archivos as $archivo){
					 // Busca solo los arvhivos XML
					 $fileInfo = pathinfo($archivo['server_path']);
					 if($fileInfo['extension'] == 'xml'){
						$pdfFileName = $fileInfo['dirname'] . '/' . $fileInfo['filename'] . '.pdf';
						if(is_file($pdfFileName)){
						   $this->save_tmp_files($archivo['server_path'], $pdfFileName);
						}
					 }
				  }
			   }

			   protected function save_tmp_files($xmlFile, $pdfFile){
				  $this->load->library('cfdi');
				  $xmlContent = file_get_contents($xmlFile);
				  if(!$this->cfdi->loadXml($xmlContent)){
					 echo 'No se puede cargar el XML: ' . $xmlFile . PHP_EOL;
					 return FALSE;
				  }
				  $uuid = $this->cfdi->get_uuid();
				  $this->load->model('Comprobantes_model', 'comp');
				  $comprobante = $this->comp->get_by_uuid($uuid);
				  if(is_null($comprobante)){
					 echo 'No se encontro Informacion del comprobante: ' . $xmlFile . PHP_EOL;
					 return FALSE;
				  }
				  $this->config->load('hegarss');
				  $basePath = $this->config->item('path_save');
				  $fullPath = $basePath . DIRECTORY_SEPARATOR . $comprobante->empresa . DIRECTORY_SEPARATOR . $comprobante->rfc_emisor .
				  DIRECTORY_SEPARATOR . date('Y', strtotime($comprobante->fecha)) . DIRECTORY_SEPARATOR . date('m', strtotime($comprobante->fecha));
				  if(!is_dir($fullPath) && !mkdir($fullPath, 0777, TRUE)){
					 echo 'No se encuentra el directorio y no se puede crear: ' . $fullPath . PHP_EOL;
					 return FALSE;
				  }
				  $Destino = $fullPath . DIRECTORY_SEPARATOR . strtolower($uuid);
				  if(!copy($xmlFile, $Destino . '.xml')){
					  return FALSE;
				  }
				  unlink($xmlFile);
				  rename($pdfFile, $Destino . '.pdf');
				  $this->comp->update_comprobante($uuid, array('path' => $Destino));
				  return TRUE;
			   }

			   public function check_xml_files(){
				$this->load->helper('file');
				$archivos = get_dir_file_info('./tmp/');
				foreach ($archivos as $archivo) {
					$fileInfo = pathinfo($archivo['server_path']);
					if($fileInfo['extension'] == 'xml'){
						$this->save_tmp_files($archivo['server_path'], '');
					}
				}
			}
			}

			/* End of file Tools.php */
			/* Location: ./application/controllers/Tools.php */
