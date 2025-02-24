<?php
require APPPATH . 'libraries/REST_Controller.php';

header('Access-Control-Allow-Origin: *');

class Comprobantes extends REST_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Comprobantes_model', 'Comp');
    $this->load->helper('hegarss');
    $this->load->model('Empresas_model', 'emp');
  }

  public function pendientes_get()
  {
    if (!$this->get('empresa')) {
      $this->response([
        'status' => false,
        'error' => 'No se especifico la clave de la empresa'], 400);
    }
    $dataEmpresa = $this->emp->get_by_rfc($this->get('empresa'));
    if (!$dataEmpresa) {
      $this->response([
        'status' => false,
        'error' => 'No se encuentra habilitado el módulo de Buzón Electrónico' .
          ' para la empresa especificada. Favor de contactar al administrador' .
          ' para su activación: info@hegarss.com', 400]);
    }
    $comp = $this->Comp->get_faltantes_by_empresa($this->get('empresa'));
    if ($comp) {
      $this->response(['status' => true, 'data' => $comp], 200);
    } else {
      $this->response([
        'status' => false,
        'error' => 'No se encontraron registros'], 404);
    }
  }
  public function actualicontra_post()
  {
       if(!$this->post('uuid')){
           $this->response([
               'status' => false,
               'error' => 'No se especifico el uuid a actualizar'
           ],400);
       }
       $data = array('no_contrare' => $this->post('sumtori'),'fecha_contra'=>date('Y-m-d H:i:s'));
       $success = $this->Comp->update_comprobante($this->post('uuid'), $data);
    if (!$success) {
      $this->response([
        'status' => false,
        'error' => 'No se encontro el comprobante'], 404);
    }
    $this->response(array('status' => true), 200);
  }
  public function acepta_post()
  {
    if (!$this->post('uuid')) {
      $this->response([
        'status' => false,
        'error' => 'No se especifico el uuid a actualizar'], 400);
    }
    $data = array('status' => 'A');
    if ($this->post('descripcion')) {
      $data['descripcion'] = $this->post('descripcion');
    }
    // if ($this->post('departamento')) {
    //   $data['departamento'] = $this->post('departamento');
    // }
    $success = $this->Comp->update_comprobante($this->post('uuid'), $data);
    if (!$success) {
      $this->response([
        'status' => false,
        'error' => 'No se encontro el comprobante'], 404);
    }
    $this->response(array('status' => true), 200);
  }

  public function rechaza_post()
  {
    if (!$this->post('uuid')) {
      $this->response([
        'status' => false,
        'error' => 'No se especifico el uuid a actualizar'], 400);
    }
    $data = array('status' => 'R');
    if ($this->post('razon')) {
      $data['error'] = $this->post('razon');
    }
    $success = $this->Comp->update_comprobante($this->post('uuid'), $data);
    if (!$success) {
      $this->response([
        'status' => false,
        'error' => 'No se encontro el comprobante'], 404);
    }
    $this->response(array('status' => true), 200);
  }

  public function poliza_pago_post()
  {
    if (!$this->post('uuid')) {
      $this->response([
        'status' => false,
        'error' => 'No se especifico el uuid a actualizar'], 400);
    }
    if (!$this->post('poliza')) {
      $this->response([
        'status' => false,
        'error' => 'No se especifico la poliza de pago'], 400);
    }
    if (!$this->post('fecha')) {
      $this->response([
        'status' => false,
        'error' => 'No se especifico la fecha de la poliza de pago'], 400);
    }
    $data = array(
      'poliza_pago' => $this->post('poliza'),
      'fecha_pago' => date('Y-m-d', strtotime($this->post('fecha'))),
    );
    $success = $this->Comp->update_comprobante($this->post('uuid'), $data);
    if (!$success) {
      $this->response([
        'status' => false,
        'error' => 'No se encontro el comprobante.'], 404);
    }
    $this->response(array('status' => true));
  }

  public function contabiliza_post()
  {
    if (!$this->post('uuid')) {
      $this->response([
        'status' => false,
        'error' => 'No se especifico el uuid a actualizar'], 400);
    }
    if (!$this->post('poliza')) {
      $this->response([
        'status' => false,
        'error' => 'No se especifico la poliza de contabilidad'], 400);
    }
    if (!$this->post('fecha')) {
      $this->response([
        'status' => false,
        'error' => 'No se especifico la fecha de la poliza de contabilidad'
      ], 400);
    }
    $data = array(
      'poliza_contabilidad' => $this->post('poliza'),
      'fecha_contabilidad' => date('Y-m-d', strtotime($this->post('fecha')))
    );
    $success = $this->Comp->update_comprobante($this->post('uuid'), $data);
    if (!$success) {
      $this->response([
        'status' => false,
        'error' => 'No se encontro el comprobante.'], 404);
    }
    $this->response(array('status' => true));
  }

  public function programa_pago_post()
  {
    if (!$this->post('uuid')) {
      $this->response([
        'status' => false,
        'error' => 'No se especifico un UUID a actualizar'], 400);
    }
    if (!$this->post('fecha_pago')) {
      $this->response([
        'status' => false,
        'error' => 'No se especifico la fecha de pago del comprobante'], 400);
    }

    $data = array(
      'fecha_programada' => date('Y-m-d', strtotime($this->post('fecha_pago')))
    );
    $success = $this->Comp->update_comprobante($this->post('uuid'), $data);
    if (!$success) {
      $this->response([
        'status' => false,
        'error' => 'No se encontro el comprobante'], 404);
    }
    $this->response(array('status' => true));
  }

  public function valida_uuid_get()
  {
    if (!$this->get('uuid')) {
      $this->response([
        'status' => false,
        'error' => 'No se especifico el uuid a validar'], 400);
    }
    $comp = $this->Comp->get_by_uuid($this->get('uuid'));
    if (!$comp) {
      $this->response([
        'status' => false,
        'error' => 'No se encontro el UUID especificado'], 404);
    }
    $resp = valida_uuid_sat(
      $comp->uuid, 
      $comp->rfc_emisor,
      $comp->rfc_receptor,
      $comp->total
    );
    if (!$resp) {
      $this->response([
        'status' => false,
        'error' => 'No se puede validar el comprobante. Intente mas tarde'
      ], 400);
    }
    $data = array(
      'codigo_sat' => $resp['codigo_estatus'],
      'estado_sat' => $resp['estado'],
    );
    $this->Comp->update_comprobante($this->get('uuid'), $data);
    $this->response(
      array(
        'status' => true,
        'codigoEstatus' => $resp['codigo_estatus'],
        'estado' => $resp['estado'],
        'esCancelable' => $resp['es_cancelable']
      )
    );
  }

  public function archivos_get()
  {
    if (!$this->get('uuid')) {
      $this->response([
        'status' => false,
        'error' => 'No se especifico el UUID a recuperar'], 400);
    }
    $comp = $this->Comp->get_by_uuid($this->get('uuid'));
    if (!$comp) {
      $this->response([
        'status' => false,
        'error' => 'No se encontro el comprobante'], 400);
    }
    $path = $comp->path;
    $response['xml'] = false;
    $response['pdf'] = false;
    if (is_file($path . '.xml')) {
      $response['xmlContent'] = file_get_contents($path . '.xml');
      $response['xml'] = true;
    }
    if (is_file($path . '.pdf')) {
      $response['pdfContent'] = base64_encode(file_get_contents($path . '.pdf'));
      $response['pdf'] = true;
    }
    $this->response($response, 200);
  }

  public function uploadpdf_post()
  {
      $empresa = $this->post('empresa');
      $tipo_com = $this->post('tipo_com');
      $versi = $this->post('versio');
      $foli = $this->post('foli');
      $seri = $this->post('seri');
      $fecha = $this->post('fecha');
      $fom_pa = $this->post('fom_pa');
      $met_pa = $this->post('met_pa');
      $cta = $this->post('cta');
      $est = $this->post('est');
      $cod_sat = $this->post('cod_sat');
      $mone = $this->post('mone');
      $tipo_cam = $this->post('tipo_cam');
      $rfc = $this->post('rfc');
      $nom = $this->post('nom');
      $recep = $this->post('recep');
      $subto = $this->post('subto');
      $tasaiva = $this->post('tasaiva');
      $iva = $this->post('iva');
      $retiva = $this->post('retiva');
      $reisar = $this->post('reisar');
      $tasaiep = $this->post('tasaiep');
      $ieps = $this->post('ieps');
      $total = $this->post('total');
      $referencia = $this->post('referencia');

      $valoe = $this->Comp->crearuuid();

      $config['allowed_types'] = 'xml|pdf';
      $config['upload_path'] = sys_get_temp_dir();
      $config['encrypt_name'] = true;

      $this->load->library('upload', $config);

      $xmlFile = $this->upload->data('full_path');
      $pdfFile = NULL;
      if ($this->upload->do_upload('pdf')) {
        $pdfFile = $this->upload->data('full_path'); 
      }

      $existe = $this->Comp->existecomprobante($this->post('foli'),$this->post('seri'),$this->post('rfc'));
      if (count($existe)>0) {
        $this->response([
          'status' => false,
          'error' => 'La informacion proporcionada ya se encuentra almacenada.'], 400);
      }

      if (!$this->post('empresa')) {
        $this->response([
          'status' => false,
          'error' => 'Debe proporcionar el RFC de la empresa a la que pertenece' .
            ' el Comprobante'], 400);
      }
      $datosEmp = $this->emp->get_by_rfc($this->post('empresa'));
      if (!$datosEmp) {
        $this->response([
          'status' => false,
          'error' => 'No se encontro informacion de la empresa especificada'
        ], 400);
      }
      $this->load->library('cfdi');
      $valor = $this->cfdi->save_to_dbpdf($valoe[0]->uuid,$datosEmp->rfc,$empresa,$tipo_com,$versi,$foli,$seri,$fecha,$fom_pa,$met_pa,$cta,$est,$cod_sat,$mone,$tipo_cam,$rfc,$nom,$recep,$subto,$tasaiva,$iva,$retiva,$reisar,$tasaiep,$ieps,$total,$referencia);
       if(!$valor) {
        $this->response([
          'status' => false,
          'error' => 'No se puede almacenar el comprobante: ' .
            $this->cfdi->lastError], 400);
      }

      $this->config->load('hegarss');
      $config = $this->config->item('path_save');
      $path = $config . DIRECTORY_SEPARATOR . $this->post('empresa') .
        DIRECTORY_SEPARATOR . $this->cfdi->emisor . DIRECTORY_SEPARATOR .
        date('Y', strtotime($this->cfdi->fecha)) . DIRECTORY_SEPARATOR .
        date('m', strtotime($this->cfdi->fecha));
      if (!is_dir($path) && !mkdir($path, 0777, true)) {
        $this->response([
          'status' => false,
          'error' => 'No se puede crear la ruta para almacenar el documento'
        ], 500);
      }
      $destino = $path . DIRECTORY_SEPARATOR . strtolower($valoe[0]->uuid);
      //rename($xmlFile, $destino . '.xml');
      if($pdfFile) {
        rename($pdfFile, $destino . '.pdf');
      }
      $this->Comp->update_comprobante(
        $valoe[0]->uuid,
        array('path' => $destino)
      );

      $this->response(array('status' => true, 'data' => 'Registrado correctamente'));
  }
  public function uploadxmlmulti_post()
  {
     if(!$this->post('empresa')){
       $this->response([
         'status' => false,
         'error' => 'No se especifico la empresa a la que pertenece el comprobante'], 400);
     }
     $datosEmp = $this->emp->get_by_rfc($this->post('empresa'));
     if (!$datosEmp) {
       $this->response([
         'status' => false,
         'error' => 'No se encontro informacion de la empresa especificada'
       ], 400);
     }
    // validamos que se suba correctamente los archivos
    $config['allowed_types'] = 'xml';
    $config['upload_path'] = sys_get_temp_dir();
    $config['encrypt_name'] = true;

    $this->load->library('upload', $config);
    if (!$this->upload->do_upload('xml')) {
      $this->response([
        'status' => false,
        'error' => $this->upload->display_errors('', '') . ' XML'], 400);
    }
    $xmlFile = $this->upload->data('full_path');
    $pdfFile = NULL;
    if ($this->upload->do_upload('pdf')) {
      $pdfFile = $this->upload->data('full_path'); 
    }
    $this->load->library('cfdi');
    $xmlData = file_get_contents($xmlFile);
    if (!$this->cfdi->loadXml($xmlData)) {
      $this->response([
        'status' => false,
        'error' => 'No se puede cargar el XML para su validacion: ' .
          $this->cfdi->lastError], 400);
    }

    if ($datosEmp->estricto && $this->cfdi->get_receptor() != $datosEmp->rfc) {
      $this->response([
        'status' => false,
        'error' => 'El Receptor del comprobante debe de corresponder al RFC' .
          ' de la empresa especificada'], 400);
    }
    if(!$this->cfdi->timbrada($xmlData))
    {
      $this->response([
        'status' => false,
        'error' => 'El comprobante no se encuentra timbrado'], 400);
    }
    if (!$this->cfdi->valida_sello()) {
      $this->response([
        'status' => false,
        'error' => 'El Sello del comprobante no se encuentra bien formado o ' .
          'fue alterado'], 400);
    }
   $st = $this->post('aceptar');
   $status = $st == 'true' ? 'A' : 'P';
    if (!$this->cfdi->save_to_db($datosEmp->rfc,$xmlData,$status)) {
      $this->response([
        'status' => false,
        'error' => 'No se puede almacenar el comprobante: ' .
          $this->cfdi->lastError], 400);
    }
    $this->config->load('hegarss');
    $config = $this->config->item('path_save');
    $path = $config . DIRECTORY_SEPARATOR . $this->post('empresa') .
      DIRECTORY_SEPARATOR . $this->cfdi->emisor . DIRECTORY_SEPARATOR .
      date('Y', strtotime($this->cfdi->fecha)) . DIRECTORY_SEPARATOR .
      date('m', strtotime($this->cfdi->fecha));
    if (!is_dir($path) && !mkdir($path, 0777, true)) {
      $this->response([
        'status' => false,
        'error' => 'No se puede crear la ruta para almacenar el documento'
      ], 500);
    }
    $destino = $path . DIRECTORY_SEPARATOR . strtolower($this->cfdi->uuid);
    rename($xmlFile, $destino . '.xml');
    if($pdfFile) {
      rename($pdfFile, $destino . '.pdf');
    }
    $this->Comp->update_comprobante(
      $this->cfdi->uuid,
      array('path' => $destino)
    );
    $this->response('Comprobante Cargado Correctamente');

  }
  public function upload_post()
  {
    if (!$this->post('empresa')) {
      $this->response([
        'status' => false,
        'error' => 'Debe proporcionar el RFC de la empresa a la que pertenece' .
          ' el Comprobante'], 400);
    }
    $datosEmp = $this->emp->get_by_rfc($this->post('empresa'));
    if (!$datosEmp) {
      $this->response([
        'status' => false,
        'error' => 'No se encontro informacion de la empresa especificada'
      ], 400);
    }
    // validamos que se suba correctamente los archivos
    $config['allowed_types'] = 'xml|pdf';
    $config['upload_path'] = sys_get_temp_dir();
    $config['encrypt_name'] = true;

    $this->load->library('upload', $config);
    if (!$this->upload->do_upload('xml')) {
      $this->response([
        'status' => false,
        'error' => $this->upload->display_errors('', '') . ' XML'], 400);
    }
    $xmlFile = $this->upload->data('full_path');
    $pdfFile = NULL;
    if ($this->upload->do_upload('pdf')) {
      $pdfFile = $this->upload->data('full_path'); 
    }
    $this->load->library('cfdi');
    $xmlData = file_get_contents($xmlFile);
    if (!$this->cfdi->loadXml($xmlData)) {
      $this->response([
        'status' => false,
        'error' => 'No se puede cargar el XML para su validacion: ' .
          $this->cfdi->lastError], 400);
    }
    if ($datosEmp->estricto && $this->cfdi->get_receptor() != $datosEmp->rfc) {
      $this->response([
        'status' => false,
        'error' => 'El Receptor del comprobante debe de corresponder al RFC' .
          ' de la empresa especificada'], 400);
    }
    if(!$this->cfdi->timbrada($xmlData))
    {
      $this->response([
        'status' => false,
        'error' => 'El comprobante no se encuentra timbrado'], 400);
    }
    if (!$this->cfdi->valida_sello()) {
      $this->response([
        'status' => false,
        'error' => 'El Sello del comprobante no se encuentra bien formado o ' .
          'fue alterado'], 400);
    }
    $status = 'P';
    if (!$this->cfdi->save_to_db($datosEmp->rfc,$xmlData,$status)) {
      $this->response([
        'status' => false,
        'error' => 'No se puede almacenar el comprobante: ' .
          $this->cfdi->lastError], 400);
    }
    $this->config->load('hegarss');
    $config = $this->config->item('path_save');
    $path = $config . DIRECTORY_SEPARATOR . $this->post('empresa') .
      DIRECTORY_SEPARATOR . $this->cfdi->emisor . DIRECTORY_SEPARATOR .
      date('Y', strtotime($this->cfdi->fecha)) . DIRECTORY_SEPARATOR .
      date('m', strtotime($this->cfdi->fecha));
    if (!is_dir($path) && !mkdir($path, 0777, true)) {
      $this->response([
        'status' => false,
        'error' => 'No se puede crear la ruta para almacenar el documento'
      ], 500);
    }
    $destino = $path . DIRECTORY_SEPARATOR . strtolower($this->cfdi->uuid);
    rename($xmlFile, $destino . '.xml');
    if($pdfFile) {
      rename($pdfFile, $destino . '.pdf');
    }
    $this->Comp->update_comprobante(
      $this->cfdi->uuid,
      array('path' => $destino)
    );
    $this->response('Comprobante Cargado Correctamente');
  }

  public function get_xml_proveedor_get()
  {
      if(!$this->get('rfcpro')){
        $this->response([
          'status' => false,
          'error' => 'No se especifico la empresa del proveedor a consultar'], 400);
      }
      if(!$this->get('rfcempre')){
        $this->response([
          'status' => false,
          'error' => 'No se especifico la empresa a consultar'], 400);
      }

      $respuesta = $this->Comp->getxmlproveedor(
        $this->get('rfcpro'),
        $this->get('rfcempre')
      );
      if (!$respuesta) {
        $this->response([
          'status' => false,
          'error' => 'No se encontraron registros'], 404);
      }
      $this->response(array('status' => true, 'data' => $respuesta));
  }
  public function xml_get()
  {

    $uuid = $this->get('uuid');

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
   //$this->response(array('status' => true, 'data' => $content));
  }
  public function update_autorizacion_post()
  {
    if (!$this->post('empresa')) {
      $this->response([
        'status' => false,
        'error' => 'No se especifico la empresa a consultar'], 400);
    }
    
    $respuesta = $this->Comp->updateAutorizar(
      $this->post('empresa'),
      $this->post('uuid'),
      $this->post('id_usu')
     
    );
    if (!$respuesta) {
      $this->response([
        'status' => false,
        'error' => 'No se encontraron registros'], 404);
    }
    $this->response(array('status' => true, 'data' => $respuesta));    
  }
  public function reporte_autorizacion_get()
  {
    if (!$this->get('empresa')) {
      $this->response([
        'status' => false,
        'error' => 'No se especifico la empresa a consultar'], 400);
    }
    
    $respuesta = $this->Comp->reporteAutorizar(
      $this->get('empresa'),
      $this->get('autoriza')
     
    );
    if (!$respuesta) {
      $this->response([
        'status' => false,
        'error' => 'No se encontraron registros'], 404);
    }
    $this->response(array('status' => true, 'data' => $respuesta));
  }
  public function list_by_proveedor_poliza_get()
  {
    if (!$this->get('empresa')) {
      $this->response([
        'status' => false,
        'error' => 'No se especifico la empresa a consultar'], 400);
    }
    if (!$this->get('proveedor')) {
      $this->response([
        'status' => false,
        'error' => 'No se especifico el RFC del proveedor a consultar'], 400);
    }
    $poliza = '';
    if ($this->get('poliza')) {
      $poliza = $this->get('poliza');
    }
    $historico = false;
    if ($this->get('historico')) {
      $historico = $this->get('historico');
    }
    $formaDePago = null;
    if ($this->get('formaDePago')) {
      $formaDePago = $this->get('formaDePago');
    }
    $autorizado = 0;
    if($this->get('autorizado') == 1){
      $autorizado = 1;
    }

    $respuesta = $this->Comp->getPendientesByProveedor(
      $this->get('empresa'),
      $this->get('proveedor'),
      $poliza,
      $formaDePago,
      $historico,
      $autorizado
    );
    if (!$respuesta) {
      $this->response([
        'status' => false,
        'error' => 'No se encontraron registros'], 404);
    }
    $this->response(array('status' => true, 'data' => $respuesta));
  }

  public function list_by_proveedor_poliza_prueba_get()
  {
    if (!$this->get('empresa')) {
      $this->response([
        'status' => false,
        'error' => 'No se especifico la empresa a consultar'], 400);
    }
    if (!$this->get('proveedor')) {
      $this->response([
        'status' => false,
        'error' => 'No se especifico el RFC del proveedor a consultar'], 400);
    }
    $poliza = '';
    if ($this->get('poliza')) {
      $poliza = $this->get('poliza');
    }
    $historico = false;
    if ($this->get('historico')) {
      $historico = $this->get('historico');
    }
    $formaDePago = null;
    if ($this->get('formaDePago')) {
      $formaDePago = $this->get('formaDePago');
    }

    $respuesta = $this->Comp->getPendientesByProveedorPrueba(
      $this->get('empresa'),
      $this->get('proveedor'),
      $poliza,
      $formaDePago,
      $historico
    );
    if (!$respuesta) {
      $this->response([
        'status' => false,
        'error' => 'No se encontraron registros'], 404);
    }
    $this->response(array('status' => true, 'data' => $respuesta));
  }
  public function delete_post()
  {
    if (!$this->post('uuid')) {
      $this->response([
        'status' => false,
        'error' => 'No se proporciono el UUID a eliminar'], 400);
    }
    $this->load->library('Cfdi');
    $success = $this->cfdi->delete($this->post('uuid'));
    if (!$success) {
      $this->response([
        'status' => false,
        'error' => $this->cfdi->lastError], 400);
    }
    $this->response(array('status' => true), 200);
  }

/**
 * REPORTE GET
 *
 * Obtiene el reporte de los comprobantes registrados en el sistema para
 * mostrarlos en pantalla
 *
 * @param string empresa    RFC de la empresa a la que pertenecen lo comprobantes
 * @param string proveedor  RFC del proveedor del que se quiere el reporte
 * @param int status     Si filtra por el estatus de los comprobantes:
 *                          1 = pendientes, 2 = pagados, 3 = ambos
 * @param boolean acumulado Acumulado o Detallado por proveedor
 * @param date    fecha_inicial Fecha inicial del reporte
 * @param date    fecha_final   Fecha final del reporte
 *
 * @return json Registro de los comprobantes que complen con el criterio de
*              Busqueda
*/
  public function reporte_get()
  {
    $empresa = $this->get('empresa');
    $proveedor = $this->get('proveedor');
    $status = $this->get('status');
    $fecha_inicial = $this->get('fecha_inicial');
    $fecha_final = $this->get('fecha_final');
    $acumulado = $this->get('acumulado');
    switch ($status) {
      case 1:
        $status = 'PE';
        break;
      case 2:
        $status = 'PA';
        break;
      default:
        $status = 'AMBOS';
        break;
    }
    if (!$empresa) {
      $this->response(
        array('status' => false, 'error' => 'No se especifico la empresa'),
        REST_Controller::HTTP_BAD_REQUEST
      );
    }
    $result = $this->Comp->reporte(
      $empresa,
      $status,
      $proveedor,
      $fecha_inicial,
      $fecha_final,
      $acumulado
    );
    if (!$result) {
      $this->response([
        'status' => false,
        'error' => 'No se encontraron registros'],
        REST_Controller::HTTP_NOT_FOUND
      );
    }
    $this->response([
      'status' => true,
      'data' => $result], REST_Controller::HTTP_OK);
  }
  /** 
   * Obtiene el reporte de los complementos de pago que se debe
   * @param string empresa    RFC de la empresa a la que pertenecen lo comprobantes
   * @param string proveedor  RFC del proveedor del que se quiere el reporte
  */
  public function reporte_pagos_get()
  {
     $empresa = $this->get('empresa');
     $proveedor = $this->get('proveedor');
     $fechaini = $this->get('fechaini');
     $fechafin = $this->get('fechafin');
     if(!$empresa)
     {
        $this->response(
            array('status' => false, 'error' => 'No se especifico la empresa'),
            REST_Controller::HTTP_BAD_REQUEST
        );
     }
     $result = $this->Comp->reportecomp(
       $empresa,
       $proveedor,
       $fechaini,
       $fechafin
     );
     if(!$result)
     {
         $this->response([
          'status' => false,
          'error' => 'No se encontraron registros'],
          REST_Controller::HTTP_NOT_FOUND 
        );
     }
     $this->response([
       'status' => true,
       'data' => $result],REST_Controller::HTTP_OK);
  }

  /**
   * QUITA POLIZA PAGO
   *
   * Borra la poliza de pago de los comprobantes para que puedan ser agregados
   * a otra poliza
   *
   * @param string empresa  RFC de la empresa a la que pertenece
   * @param string poliza   # de poliza que se desea quitar
   */

  public function quita_poliza_pago_post()
  {
    $empresa = $this->post('empresa');
    $poliza = $this->post('poliza');
    $uuid = $this->post('uuid');

    if (empty($uuid)) {
      $success = $this->Comp->libera_comprobante_de_poliza($empresa, $poliza);
    } else {
      $update = array('poliza_pago' => null, 'fecha_pago' => null);
      $success = $this->Comp->update_comprobante($uuid, $update);
    }

    if (!$success) {
      $this->response(
        array(
          'status' => false,
          'error' => 'No se encontraron registros a actualizar',
        )
      );
    }
    $this->response(array('status' => true, 'mensaje' => 'Correcto'));
  }

  /**
   * LIST BY CONTABILIDAD
   *
   * Recupera los comprobantes que se encuentren dentro de una poliza de
   * contabilidad
   *
   * @param string empresa  RFC de la empresa que consulta
   * @param string poliza   Poliza de contabilidad de filtro
   */
  public function list_by_contabilidad_get()
  {
    $empresa = $this->get('empresa');
    $poliza = $this->get('poliza');
    if (!$empresa) {
      $this->response(
        array(
          'status' => false,
          'error' => 'No se especifico el RFC de la empresa',
        ),
        REST_Controller::HTTP_BAD_REQUEST
      );
    }
    if (!$poliza) {
      $this->response(
        array(
          'status' => false,
          'error' => 'No se especifico la poliza de contabilidad',
        ), REST_Controller::HTTP_BAD_REQUEST
      );
    }
    $listado = $this->Comp->get_by_contabilidad($empresa, $poliza);
    if (!$listado) {
      $this->response(
        array(
          'status' => false,
          'error' => 'No se encontraron registros',
        ), REST_Controller::HTTP_NOT_FOUND
      );
    }
    $this->response(
      array(
        'status' => true,
        'data' => $listado,
      ), REST_Controller::HTTP_OK
    );
  }

  /** 
   * UPLOAD NO FISCAL
   * 
   * Almacena comprobantes no fiscales en la base de datos para reportes de
   * costos
   * 
   * @param string empresa RFC de la empresa a la que pertenece el comprobante 
   * @param string folio    Numero de folio del comprobante
   * @param string serie    Serie identificadora del comprobante
   * @param string fecha    Fecha de emision del comprobante
   * @param string metodo_pago Metodo con el que se pago el comprobante
   * @param number tipo_cambio Tipo de cambio del comprobante en caso de que sea
   *                            una moneda diferente a MXN
   * @param string moneda   Moneda del comprobante
   * @param number subtotal Subtotal del comprobante
   * @param number iva      Monto del IVA
   * @param number tasa_iva Tasa para el calculo del IVA
   * @param number ret_iva  Monto de la retencion de IVA
   * @param number ret_isr  Monto de la retencion de ISR
   * @param number ieps     Monto del IEPS
   * @param number tasa_ieps Monto de la tasa del IEPS
   * @param number total    Monto total del comprobante
   * @param string rfc_emisor RFC o Numero de registro del emisor
   * @param string rfc_receptor RFC del contribuyente al que va dirijido el comp
   * @param string nombre_emisor Nombre del contribuyente emisor del comp.
   * @param file  pdf Archivo pdf del comprobante en base64
   * 
   **/
  function upload_no_fiscal_post() {
    $id_empresa = $this->post('empresa');
    $datosEmpresa = $this->emp->get_by_rfc($id_empresa);
    if(!$datosEmpresa) {
      $this->response([
        'status' => FALSE,
        'error' => 'No se encontro la informacion de la empresa especificada'
      ], REST_Controller::HTTP_BAD_REQUEST);

    }
    if($datosEmpresa->estricto && $rfc_receptor != $datosEmpresa->rfc) {
      $this->response([
        'status' => FALSE,
        'error' => 'El RFC Receptor no corresponde a la empresa'
      ], REST_Controller::HTTP_BAD_REQUEST);
    }
    $data = $this->_get_post_data();
    if($this->Comp->valida_existencia_no_fiscal(
        $id_empresa,
        $data['rfc_emisor'],
        $data['serie'],
        $data['folio'])
      ) {
      $this->response([
        'status' => FALSE,
        'error' => 'El comprobante ya se encuentra registrado'
      ], REST_Controller::HTTP_BAD_REQUEST);
    }
    if(isset($_FILES['pdf'])) {
      $destination = $this->_get_destination_path(
        $id_empresa,
        $data['rfc_emisor'],
        $data['fecha']
      );
      $destination .= DIRECTORY_SEPARATOR . $data['uuid'];
      $this->_upload_and_save_file('pdf', 'pdf', $destination . '.pdf');
      $data['path'] = $destination;
    }
    if (!$this->Comp->add_comprobante($data)) {
      $this->response([
        'status' => FALSE,
        'error' => 'No se puede almacenar el comprobante en la base de datos'
      ], REST_Controller::HTTP_BAD_REQUEST);
    }
    $this->response([
      'status' => TRUE,
      'error' => NULL,
      'mensaje' => 'Documento almacenado correctamente'
    ]);
  }
  
  /**
   * GET POST DATA
   * 
   * Obtiene la informacion enviada por post para insertar el comprobante no
   * fiscal
   * 
   * @return array Arreglo con todos los campos requeridos enviados por POST
   */
  private function _get_post_data() {
    $uuid = empty($this->post('uuid')) ? $this->Comp->get_uuid() : $this->post('uuid');
    $data = array(
      'empresa' => $this->post('empresa'),
      'uuid' => strtoupper($uuid),
      'version' => 'XXX',
      'tipo_comprobante' => 'I',
      'folio' => $this->post('folio'),
      'serie' => $this->post('serie'),
      'fecha' => $this->post('fecha'),
      'no_certificado' => str_repeat('0', 20),
      'forma_pago' => '99',
      'metodo_pago' => 'XXX',
      'cuenta_bancaria' => '',
      'tipo_cambio' => $this->post('tipo_cambio'),
      'moneda' => $this->post('moneda'),
      'subtotal' => $this->post('subtotal'),
      'iva' => $this->post('iva'),
      'tasa_iva' => $this->post('tasa_iva'),
      'ret_iva' => $this->post('ret_iva'),
      'ret_isr' => $this->post('ret_isr'),
      'ieps' => $this->post('ieps'),
      'tasa_ieps' => $this->post('tasa_ieps'),
      'total' => $this->post('total'),
      'rfc_emisor' => $this->post('rfc_emisor'),
      'rfc_receptor' => $this->post('rfc_receptor'),
      'fecha_timbrado' => $this->post('fecha'),
      'no_certificado_sat' => str_repeat('0', 20),
      'valida' => 1,
      'nombre_emisor' => $this->post('nombre_emisor')
    );
    return $this->_check_no_fiscal_data($data);
  }

  /**
   * CHECK NO FISCAL DATA
   * 
   * Revisa que toda la informacion requerida del comprobante se encuentre
   * registrada correctamente en el array a insertar
   * 
   * @param array $data  Array con los campos a insertar
   * @return array      Array procesado con los campos validados
   */
  private function _check_no_fiscal_data($data) {
    // Revisamos los campos obligatorios
    if($data['folio'] == ''){
      $this->response([
        'status' => FALSE,
        'error' => 'No se especifico el folio del comprobante'
      ],REST_Controller::HTTP_BAD_REQUEST);
    }
    $this->load->helper('date');
    if(!check_date($data['fecha'], 'Y-m-d H:i:s')){
      $this->response([
        'status' => FALSE,
        'error' => 'La fecha del comprobante no es valida'
      ], REST_Controller::HTTP_BAD_REQUEST);
    }
    // Revisamos los importes o los ponemos en 0.00
    if(!isset($data['tipo_cambio']) || $data['tipo_cambio'] == 0.00) {
      $data['tipo_cambio'] = 1.00;
    }
    if(!isset($data['subtotal'])) {
      $data['subtotal'] = 0.00;
    }
    if(!isset($data['iva'])) {
      $data['iva'] = 0.00;
    }
    if(!isset($data['tasa_iva'])) {
      $data['tasa_iva'] = 0.00;
    }
    if(!isset($data['ret_iva'])) {
      $data['ret_iva'] = 0.00;
    }
    if(!isset($data['ret_isr'])) {
      $data['ret_isr'] = 0.00;
    }
    if (!isset($data['ieps'])) {
        $data['ieps'] = 0.00;
    }
    if (!isset($data['tasa_ieps'])) {
        $data['tasa_ieps'] = 0.00;
    }
    if (!isset($data['total'])) {
        $data['total'] = 0.00;
    }
    //Revisamos las fechas
    $data['fecha'] = date('Y-m-d H:i:s', strtotime($data['fecha']));
    $data['fecha_timbrado'] = $data['fecha'];
    //Revisamos lo demas
    if(!isset($data['metodo_pago'])) {
      $data['metodo_pago'] = '';
    }
    if(!isset($data['moneda'])) {
      $data['moneda'] = 'MXN';
    }
    if(!isset($data['serie'])){
      $data['serie'] = '';
    }
    return $data;
  }

  /**
   * UPLOAD AND SAVE FILE
   * 
   * Realiza y valida la subida de un archivo especificado y su formato.
   * Almacenando el contenido en la ruta especificada
   * 
   * @param string $name  Nombre de la variable del archivo a subir
   * @param string $type  Tipo de archivo a procesar
   * @param string $path  Ruta y nombre de archivo donde se almacena el archivo
   * 
   * @return bool   TRUE/FALSE si el archivo se almaceno correctamente
   */
  private function _upload_and_save_file($name, $type, $path){
    $config['allowed_types'] = $type;
    $config['upload_path'] = sys_get_temp_dir();
    $config['encrypt_name'] = TRUE;
    $this->load->library('upload', $config);
    if(!$this->upload->do_upload($name)) {
      $this->response([
        'status' => FALSE,
        'error' => 'No se puede realizar la carga del documento'
      ]);
    }
    $tempFile = $this->upload->data('full_path');
    rename($tempFile, $path);
  }

  /**
   * GET DESTINATION PATH
   * 
   * Obtiene el path y el nombre del documento
   * 
   * @param string $empresa Nombre de la empresa a la que pertenece
   * @param string $emisor  RFC del emisor del comprobante
   * @param datetime $fecha Fecha de emision del comprobante
   */
  private function _get_destination_path($empresa, $emisor, $fecha) {
    $this->config->load('hegarss');
    $basePath = $this->config->item('path_save');
    $ds = DIRECTORY_SEPARATOR;
    $fullPath = $basePath . DIRECTORY_SEPARATOR . $empresa .
      DIRECTORY_SEPARATOR . $emisor . DIRECTORY_SEPARATOR .
      date('Y', strtotime($fecha)) . DIRECTORY_SEPARATOR . date('m', strtotime($fecha));
    $this->_check_directory($fullPath);
    return $fullPath;
  }

  /**
   * CHECK DIRECTORY
   * 
   * Revisa que exista el directorio especificado si no lo intenta crear
   * 
   * @param string $directory Directorio que se desea revisar
   */
  private function _check_directory($directory) {
    $oldMask = umask(0);
    if(!is_dir($directory)) {
      $correct = mkdir($directory, 0774, TRUE);
      umask($oldMask);
      if(!$correct){
        $this->response([
          'status' => FALSE,
          'error' => 'No se puede crear la ruta para almacenar el documento' . $directory
        ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
      }
    }
  }
   public function datos_cliente_post()
  {
    $usu = $this->post('usu');
    $pass = $this->post('pass');
    $rfc = $this->post('rfc');

    $datos = $this->Comp->obtenertable($usu,$pass,$rfc);
    echo json_encode($datos);
    
  }
  public function descargarcomprobantespdf_post($uuid)
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
  public function descargarcomprobantesxml_post($uuid)
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

     force_download($uuid.'.xml',$content);
  }
 

}
