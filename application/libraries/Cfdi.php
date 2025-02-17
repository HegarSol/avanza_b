<?php
   defined('BASEPATH') or exit('No direct script access allowed');

   class Cfdi
   {
      protected $CI;    // CodeIgniter Instance
      protected $xml;   // Archivo Xml que se va a validar
      protected $version;  // Version del comprobante a tratar
      public $lastError;     // Muestra el ultimo error generado
      protected $xpath;
      protected $cadena_original;
      protected $sello;
      protected $certificado;

      public $uuid;
      public $fecha;
      public $emisor;
      public $referencia;

      public function __construct()
      {
         $this->CI = & get_instance();
         $this->xml = new DOMDocument();
      }

      /**
       * Determina si el Comprbante es del tipo PPD
       * @return bool  true si es PPD, false si es PUE
       */
      protected function isPago()
      {
        $xpath = $this->getXpathObj();
        $query = 'cfdi:Comprobante/@TipoDeComprobante';
        $nodeset = $xpath->query($query, $this->xml);
        if($tipo = $nodeset[0])
        {
          return ($tipo->value == 'P');
        }
        return null;
      }

      public function loadXml($xml)
      {
         $this->uuid = NULL;
         $this->fecha = NULL;
         $this->version = NULL;
         $this->lastError = NULL;
         $this->cadena_original = NULL;
         $this->sello = NULL;
         $this->certificado = NULL;
         $this->xpath = NULL;
		 if($this->xml->loadXML($xml) === FALSE){
			$this->lastError = 'No se puede cargar el documento';
			return FALSE;
		 }
         return $this->isCfdi();
      }

      public function getVersion(){return $this->version;}

      public function get_cadena_original()
      {
         if(!is_null($this->cadena_original))
         {
            return $this->cadena_original;
         }
         libxml_use_internal_errors(TRUE);
         $xslt = $this->getXslt();
         $xsl = new DOMDocument;
         $xsl->load($xslt);
         $procesador = new XsltProcessor();
         $procesador->importStyleSheet($xsl);
         return $this->cadena_original =
         $procesador->transformToXML($this->xml);
      }

      public function get_sello()
      {
         if(!is_null($this->sello))
         {
            return $this->sello;
         }
         $xpath = $this->getXpathObj();
         $query = 'cfdi:Comprobante/@sello | cfdi:Comprobante/@Sello';
         $nodeset = $xpath->query($query,$this->xml);
         if($sello = $nodeset[0])
         {
            return $this->sello = $sello->value;
         }
         $this->lastError = "No se puede recuperar el Sello del XML";
         return NULL;
      }

      public function get_certificado($forOpenSsl = FALSE)
      {
         if(!is_null($this->certificado))
         {
            return $this->certificado;
         }
         $xpath = $this->getXpathObj();
         $query = 'cfdi:Comprobante/@certificado |
         cfdi:Comprobante/@Certificado';
         $nodeset = $xpath->query($query, $this->xml);
         if($certificado = $nodeset[0])
         {
            $this->certificado = $certificado->value;
            if($forOpenSsl)
            {
               $this->certificado = "-----BEGIN CERTIFICATE-----\r\n";
               $this->certificado .= wordwrap($certificado->value,64,"\r\n", TRUE);
               $this->certificado .= "\r\n-----END CERTIFICATE-----";
            }
            return $this->certificado;
         }
         $this->lastError = "No se puede recuperar el certificado del XML";
         return $this->certificado;
      }

      public function valida_sello()
      {
         $pub_key = openssl_pkey_get_public($this->get_certificado(TRUE));
         $cadena = $this->get_cadena_original();
         $sello = base64_decode($this->get_sello());
         switch($this->version)
         {
            case '3.2':
               return openssl_verify($cadena, $sello, $pub_key, OPENSSL_ALGO_SHA1);
               break;
            case '3.3':
               return openssl_verify($cadena, $sello, $pub_key, OPENSSL_ALGO_SHA256);
               break;
            case '4.0':
               return openssl_verify($cadena, $sello, $pub_key, OPENSSL_ALGO_SHA256);
            default:
               log_message('error', "El Comprobante no tiene una version soportada por el sistema: " . $this->version);
               return FALSE;
               break;
         }
      }
      public function save_to_dbpdf($uuid,$rfcempre,$empresa,$tipo_com,$versi,$foli,$seri,$fecha,$fom_pa,$met_pa,$cta,$est,$cod_sat,$mone,$tipo_cam,$rfc,$nom,$recep,$subto,$tasaiva,$iva,$retiva,$reisar,$tasaiep,$ieps,$total,$referencia)
      {

         $this->CI->load->model('Comprobantes_model', 'comprobantes');

        

         date_default_timezone_set("America/Mexico_City");

         if($this->already_in_db($uuid))
         {
            $this->lastError = "El Comprobante ya se encuentra registrado en el sistema";
            return FALSE;
         }
         $data['empresa'] = $empresa;
         $data['uuid'] = $uuid; 
         $data['version'] = $versi;
         $data['tipo_comprobante'] = $tipo_com;
         $data['folio'] = $foli;
         $data['serie'] = $seri;
         $data['fecha'] = date('Y-m-d H:i:s',strtotime($fecha));
         $data['no_certificado'] = '';
         $data['forma_pago'] = $fom_pa;
         $data['metodo_pago'] = $met_pa;
         $data['cuenta_bancaria'] = $cta;
         $data['tipo_cambio'] = $tipo_cam;
         $data['descuento'] = '';
         $data['moneda'] = $mone;
         $data['subtotal'] = $subto;
         $data['iva'] = $iva;
         $data['tasa_iva'] = $tasaiva;
         $data['ret_iva'] = $retiva;
         $data['ret_isr'] = $reisar;
         $data['ieps'] = $ieps;
         $data['tasa_ieps'] = $tasaiep;
         $data['total'] = $total;
         $data['rfc_emisor'] = $rfc;
         $data['rfc_receptor'] = $empresa;
         $data['fecha_timbrado'] = '';
         $data['no_certificado_sat'] = '';
         $data['fecha_ingreso'] = date('Y-m-d H:i:s');
         $data['valida'] = 1;
         if($tipo_com == 'P')
         {
            $data['status'] = 'A';
         }
         $data['path'] = '...';
         $data['nombre_emisor'] = $nom;
         $data['reg_emisor'] = '';
         $data['referencia'] = $referencia;

         return $this->CI->comprobantes->add_comprobante($data);
      }
      public function timbrada($xmlData)
      {
         $this->uuid = $this->getAttribute('cfdi:Comprobante/cfdi:Complemento/tfd:TimbreFiscalDigital/@UUID');
         return $this->uuid;
      }
      public function save_to_db($empresa,$xmlData,$status)
      {       

         try
         {

         
         $this->uuid = $this->getAttribute('cfdi:Comprobante/cfdi:Complemento/tfd:TimbreFiscalDigital/@UUID');
         $this->CI->load->model('Comprobantes_model', 'comprobantes');
         $this->CI->load->model('Receptores_model','receptores');
         $this->CI->load->model('Proveedores_model','proveedores');
         if($this->already_in_db($this->uuid))
         {
            $this->lastError = "El Comprobante ya se encuentra registrado en el sistema";
            return FALSE;
         }
         $queryImp = 'cfdi:Comprobante/cfdi:Impuestos';
         $queryTra = $queryImp . '/cfdi:Traslados/cfdi:Traslado';
         $queryRet = $queryImp . '/cfdi:Retenciones/cfdi:Retencion';
         $data['empresa'] = $empresa;
         $data['uuid'] = $this->uuid; 
         $data['version'] = $this->getAttribute('cfdi:Comprobante/@version | cfdi:Comprobante/@Version');
         $data['tipo_comprobante'] = $this->getAttribute('cfdi:Comprobante/@tipoDeComprobante | cfdi:Comprobante/@TipoDeComprobante');
         $data['folio'] = $this->getAttribute('cfdi:Comprobante/@folio | cfdi:Comprobante/@Folio');
         $data['serie'] = $this->getAttribute('cfdi:Comprobante/@serie | cfdi:Comprobante/@serie');
         $data['fecha'] = date('Y-m-d H:i:s',strtotime($this->getAttribute('cfdi:Comprobante/@fecha | cfdi:Comprobante/@Fecha')));
         $this->fecha = $data['fecha'];
         $data['no_certificado'] = $this->getAttribute('cfdi:Comprobante/@noCertificado | cfdi:Comprobante/@NoCertificado');
         $data['forma_pago'] = $this->getAttribute('cfdi:Comprobante/@formaDePago | cfdi:Comprobante/@FormaPago');
         $data['metodo_pago'] = $this->getAttribute('cfdi:Comprobante/@metodoDePago | cfdi:Comprobante/@MetodoPago');
         $data['cuenta_bancaria'] = $this->getAttribute('cfdi:Comprobante/@NumCtaPago');
         $data['tipo_cambio'] = $this->getAttribute('cfdi:Comprobante/@TipoCambio');
         $data['descuento'] = $this->getAttribute('cfdi:Comprobante/@descuento | cfdi:Comprobante/@Descuento');
         $data['moneda'] = $this->getAttribute('cfdi:Comprobante/@Moneda');
         $data['subtotal'] = $this->getAttribute('cfdi:Comprobante/@subTotal | cfdi:Comprobante/@SubTotal');
         $data['iva'] = $this->getSum($queryTra . "[@impuesto = 'IVA']/@importe | " . $queryTra . "[@Impuesto = '002']/@Importe");
         $data['tasa_iva'] = $this->getMax($queryTra . "[@impuesto = 'IVA']/@tasa | " . $queryTra . "[@Impuesto = '002']/@TasaOCuota");
         $data['ret_iva'] = $this->getSum($queryRet . "[@impuesto = 'IVA']/@importe | " . $queryRet . "[@Impuesto = '002']/@Importe");
         $data['ret_isr'] = $this->getSum($queryRet . "[@impuesto = 'ISR']/@importe | " . $queryRet . "[@Impuesto = '001']/@Importe");
         $data['ieps'] = $this->getSum($queryTra . "[@impuesto = 'IEPS']/@importe | " . $queryTra . "[@Impuesto = '003']/@Importe");
         $data['tasa_ieps'] = $this->getAttribute($queryTra . "[@impuesto = 'IEPS']/@tasa | " . $queryTra . "[@Impuesto = '003']/@TasaOCuota");
         $data['total'] = $this->getAttribute('cfdi:Comprobante/@total | cfdi:Comprobante/@Total');
         $data['rfc_emisor'] = $this->getAttribute('cfdi:Comprobante/cfdi:Emisor/@rfc | cfdi:Comprobante/cfdi:Emisor/@Rfc');
         $this->emisor = $data['rfc_emisor'];
         $data['rfc_receptor'] = $this->getAttribute('cfdi:Comprobante/cfdi:Receptor/@rfc | cfdi:Comprobante/cfdi:Receptor/@Rfc');
         $data['fecha_timbrado'] = date('Y-m-d H:i:s', strtotime($this->getAttribute('cfdi:Comprobante/cfdi:Complemento/tfd:TimbreFiscalDigital/@FechaTimbrado')));
         $data['no_certificado_sat'] = $this->getAttribute('cfdi:Comprobante/cfdi:Complemento/tfd:TimbreFiscalDigital/@noCertificadoSAT | cfdi:Comprobante/cfdi:Complemento/tfd:TimbreFiscalDigital/@NoCertificadoSAT');
         $data['valida'] = 1;
         if($this->getAttribute('cfdi:Comprobante/@tipoDeComprobante | cfdi:Comprobante/@TipoDeComprobante') == 'P')
         {
            $data['status'] = 'A';
         }
         else
         {
            if($status == 'A')
            {
               $data['status'] = 'A';
            }

         }
         $data['path'] = '...';
         $data['nombre_emisor'] = $this->getAttribute('cfdi:Comprobante/cfdi:Emisor/@nombre | cfdi:Comprobante/cfdi:Emisor/@Nombre');
         $data['reg_emisor'] = $this->getAttribute('cfdi:Comprobante/cfdi:Emisor/@RegimenFiscal');
         $nombreReceptor = $this->getAttribute('cfdi:Comprobante/cfdi:Receptor/@nombre | cfdi:Comprobante/cfdi:Receptor/@Nombre');
         $this->CI->receptores->add($empresa, $data['rfc_receptor'], $nombreReceptor);
         $this->CI->proveedores->add($empresa, $data['rfc_emisor'], $data['nombre_emisor']);
         if($this->isPago() === true)
         {
           $this->savePagos();
         }
         $relacionados = $this->getAttribute('cfdi:Comprobante/cfdi:CfdiRelacionados/@TipoRelacion');
          if($relacionados)
          {
             $this->saveRelacionado();
          }

      $xml2 = simplexml_load_string($xmlData);

      $impuestosR = $this->getAttribute('cfdi:Comprobante/cfdi:Impuestos/cfdi:Retenciones/cfdi:Retencion/@Impuesto');
      if($impuestosR)
      {
         $this->CI->load->model('Relacionados_model');
         foreach($xml2->children('cfdi',TRUE)->Impuestos->Retenciones->Retencion as $retencion)
         {

            // if($retencion->getAttribute('Base'))
            // {

            // }
            // else
            // {
               $dataRete = array();
               $dataRete['uuid'] = $this->uuid;
               $dataRete['ToR'] = 'Retencion';
               $dataRete['impuesto'] = $retencion->attributes()->Impuesto;
               $dataRete['importe'] = $retencion->attributes()->Importe;
               $this->CI->Relacionados_model->addRetencion($dataRete);

            // }
            
         }
      }
      $impuestosT = $this->getAttribute('cfdi:Comprobante/cfdi:Impuestos/cfdi:Traslados/cfdi:Traslado/@Impuesto');
      if($impuestosT)
      {
         $this->CI->load->model('Relacionados_model');
         foreach($xml2->children('cfdi',TRUE)->Impuestos->Traslados->Traslado as $traslado)
         {
            // if($traslado->getAttribute('Base'))
            // {

            // }
            // else
            // {
               $dataTras = array();
               $dataTras['uuid'] = $this->uuid;
               $dataTras['ToR'] = 'Traslado';
               $dataTras['impuesto'] = $traslado->attributes()->Impuesto;
               $dataTras['tipofactor'] = $traslado->attributes()->TipoFactor;
               $dataTras['tasaocuota'] = $traslado->attributes()->TasaOCuota;
               $dataTras['importe'] = $traslado->attributes()->Importe;
               $this->CI->Relacionados_model->addTrasla($dataTras);
            // }               
         }
      }

         $data['referencia'] = $this->referencia;
         return $this->CI->comprobantes->add_comprobante($data);
        }
        catch(Exception $ex)
        {
           return $ex->getMessage();
        }

      }
      protected function saveRelacionado()
      {
         $this->CI->load->model('Relacionados_model');
         try
         {
            
                $dataRelacion = array();
                $dataRelacion['uuid_comprobante'] = $this->uuid;
                $dataRelacion['tipoRelacion'] = $this->getAttribute('cfdi:Comprobante/cfdi:CfdiRelacionados/@TipoRelacion');
                $dataRelacion['uuid_relacionado'] = $relacionados = $this->getAttribute('cfdi:Comprobante/cfdi:CfdiRelacionados/cfdi:CfdiRelacionado/@UUID');
                $this->CI->Relacionados_model->add($dataRelacion);
            
         }
         catch(Exception $ex)
         {
            return $ex->getMessage();
         }
     }
      protected function savePagos()
      {
        $this->CI->load->model('Pagos_model');
        try
        {
            $pagosList = $this->xml->getElementsByTagName('Pago');
            foreach($pagosList as $pago)
            {
            $dataPago = array();
            $dataPago['uuid'] = $this->uuid;
            $dataPago['fecha_pago'] = $pago->getAttribute('FechaPago');
            $dataPago['forma_pago'] = $pago->getAttribute('FormaDePagoP');
            $dataPago['moneda'] = $pago->getAttribute('MonedaP');
            $dataPago['tipo_cambio'] = $pago->getAttribute('TipoCambioP');
            $dataPago['monto'] = $pago->getAttribute('Monto');
            $dataPago['num_operacion'] = $pago->getAttribute('NumOperacion');
            $dataPago['rfc_emisor_cta_ord'] = $pago->getAttribute('RfcEmisotCtaOrd');
            $dataPago['nom_banco_ord'] = $pago->getAttribute('NomBancoOrdEx');
            $dataPago['cta_ordenante'] = $pago->getAttribute('CtaOrdenante');
            $dataPago['rfc_emisor_cta_ben'] = $pago->getAttribute('RfcEmisorCtaBen');
            $dataPago['cta_beneficiario'] = $pago->getAttribute('CtaBeneficiario');
            $dataPago['tipo_cad_pago'] = $pago->getAttribute('TipoCadPago');
            $dataPago['cert_pago'] = $pago->getAttribute('CertPago');
            $dataPago['cad_pago'] = $pago->getAttribute('CadPago');
            $dataPago['sello_pago'] = $pago->getAttribute('SelloPago');
            $dataPagos = $this->get_array_pagos($pago->getElementsByTagName('DoctoRelacionado'));
            $this->CI->Pagos_model->add($dataPago, $dataPagos);
            }
        }
        catch (Exception $ex)
        {
            return $ex->getMessage();
        }
        
      }
      protected function get_array_pagos(DOMNodeList $nodes)
      {
        $regresa = array();
        foreach($nodes as $element)
        {
          $pago = array();
          $pago['id_documento'] = $element->getAttribute('IdDocumento');
          $pago['serie'] = $element->getAttribute('Serie');
          $pago['folio'] = $element->getAttribute('Folio');
          $pago['moneda'] = $element->getAttribute('MonedaDR');
          $pago['tipo_cambio'] = $element->getAttribute('TipoCambioDR');
          $pago['metodo_pago'] = $element->getAttribute('MetodoDePagoDR');
          $pago['num_parcialidad'] = $element->getAttribute('NumParcialidad');
          $pago['imp_saldo_anterior'] = $element->getAttribute('ImpSaldoAnt');
          $pago['imp_pagado'] = $element->getAttribute('ImpPagado');
          $pago['imp_saldo_insoluto'] = $element->getAttribute('ImpSaldoInsoluto');
          $regresa[] = $pago;
        }
        return $regresa;

      }

      protected function already_in_db($uuid)
      {
         $datos = $this->CI->comprobantes->get_by_uuid($uuid);
         return $datos;
      }

      protected function isCfdi()
      {
         $nodeset = $this->xml->getElementsByTagName('Comprobante');
         if($comprobante = $nodeset[0])
         {
            $version =
            $comprobante->getAttribute($comprobante->hasAttribute('version') ?
         'version' : 'Version');
            if(!in_array($version,array('3.2', '3.3', '4.0')))
            {
               $this->lastError = "La versi&oacute;n del comprobante no es soportada
               por el sistema";
               return FALSE;
            }
            $this->version = $version;
            return TRUE;
         }
         $this->lastError = "El XML proporcionado no es un Comprobante Fiscal";
         return FALSE;
      }

      protected function getAttribute($query)
      {
         $xpath = $this->getXpathObj();
         $nodeset = $xpath->query($query, $this->xml);
         if($regresa = $nodeset[0])
         {
            return $regresa->value;
         }
         return "";
      }

      protected function getSum($query)
      {
         $xpath = $this->getXpathObj();
         $query = "sum($query)";
         $val = (double) $xpath->evaluate($query, $this->xml);
         return $val;
      }

      protected function getMax($query){
            $xpath = $this->getXpathObj();
            $maxValue = 0.00;
            $nodeSet = $xpath->query($query, $this->xml);
            foreach ($nodeSet as $node) {
                  if( (double) $node->value > $maxValue){
                        $maxValue = (double) $node->value;
                  }
            }
            return $maxValue;
      }

      protected function getXpathObj()
      {
         if(empty($this->xpath) && !empty($this->xml))
         {
            if($this->version == '3.3' || $this->version == '3.2')
            {
               $this->xpath = new DOMXPath($this->xml);
               $this->xpath->registerNamespace('cfdi', 'http://www.sat.gob.mx/cfd/3');
               $this->xpath->registerNamespace('tfd', 'http://www.sat.gob.mx/TimbreFiscalDigital');
            }
            else
            {
               $this->xpath = new DOMXPath($this->xml);
               $this->xpath->registerNamespace('cfdi', 'http://www.sat.gob.mx/cfd/4');
               $this->xpath->registerNamespace('tfd', 'http://www.sat.gob.mx/TimbreFiscalDigital');
            }

         }
         return $this->xpath;
      }

      protected function getXslt()
      {
         $xslts = array(
            '3.2' => './public/xslt/3.2/cadenaoriginal_3_2.xslt',
            '3.3' => './public/xslt/3.3/cadenaoriginal_3_3.xslt',
            '4.0' => './public/xslt/4.0/cadenaoriginal_4.xslt'
         );
         return $xslts[$this->version];
      }

      public function get_receptor()
      {
         return $this->getAttribute('cfdi:Comprobante/cfdi:Receptor/@rfc | cfdi:Comprobante/cfdi:Receptor/@Rfc');
      }

	  public function get_uuid()
	  {
		 return $this->getAttribute('cfdi:Comprobante/cfdi:Complemento/tfd:TimbreFiscalDigital/@UUID');
        }
        
    public function delete($uuid){
      if(empty($uuid)){
        $this->lastError = 'No se especifico un UUID para eliminar';
        return FALSE;
      }
      $this->CI->load->model('Comprobantes','Comp');
      $comp = $this->CI->Comp->get_by_uuid($uuid);
      if(!$comp){
        $this->lastError = 'No se encontro el comprobante especificado';
        return FALSE;
      }         
      // Borramos los documentos del directorio
      if(is_file($comp->path . '.xml')){
        unlink($comp->path . '.xml');
      }
      if(is_file($comp->path . '.pdf')){
        unlink($comp->path . '.pdf');
      }
      $success = $this->CI->Comp->delete($uuid);
      if(!$success){
        $this->lastError = 'No se pudo eliminar el comprobante de la base de datos';
        return FALSE;
      }
      return TRUE;
    }
   }
