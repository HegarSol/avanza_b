<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

/*
   Funcion para validar los UUID ante el SAT usando el webservice proporcionado por ellos
   @autor   Ing. Guadalupe Garza Moreno
   @fecha   17/Julio/2017

   @param  $uuid       UUID del comprobante a validar
   @param  $emisor     RFC del emisor del comprobante
   @param  $receptor   RFC del receptor del comprobante
   @param  $total      Total del comprobante a validar

   @return array       Regresa el status del comprobante o NULL en caso de un error
*/
if(!function_exists('valida_uuid_sat')){

  function valida_uuid_sat($uuid, $emisor, $receptor, $total){
    $total = str_pad(number_format($total,6,".",""), 17, 0, STR_PAD_LEFT);

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://consultaqr.facturaelectronica.sat.gob.mx/ConsultaCFDIService.svc?wsdl=",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:tem=\"http://tempuri.org/\">\r\n   <soapenv:Header/>\r\n   <soapenv:Body>\r\n      <tem:Consulta>\r\n         <!--Optional:-->\r\n         <tem:expresionImpresa><![CDATA[?re=".$emisor."&rr=".$receptor."&tt=".$total."&id=".$uuid."]]></tem:expresionImpresa>\r\n      </tem:Consulta>\r\n   </soapenv:Body>\r\n</soapenv:Envelope>",
      CURLOPT_HTTPHEADER => array(
        "Accept: text/xml",
        "Cache-Control: no-cache",
        "Content-type: text/xml;charset=\"utf-8\"",
        "SOAPAction: http://tempuri.org/IConsultaCFDIService/Consulta"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      log_message($err);
    } else {
      return envelope_to_array($response);
    }
  }
}

/**
 * Funcion para formar el Objeto de respuesta de la consulta de UUID ante el SAT tomando un string XML de respuesta para
 * procesarlo
 * 
 * @param string $xml   Respuesta del servicio web con el Envelope
 * 
 * @return array 
 */
if(!function_exists('envelope_to_array'))
{
  function envelope_to_array($xml)
  {
    $dom = new DOMDocument('1.0','UTF-8');
    $dom->loadXML($xml);
    $result = array(
      'codigo_estatus' => $dom->getElementsByTagName('CodigoEstatus')[0]->nodeValue,
      'es_cancelable' => $dom->getElementsByTagName('EsCancelable')[0]->nodeValue,
      'estado' => $dom->getElementsByTagName('Estado')[0]->nodeValue,
    );
    return $result;
  }
}

/**
 * Funcion para determinar si un .cer y .key son pares, comparando sus estructuras XML
 * 
 * @autor Ing. Guadalupe Garza Moreno
 * @fecha 12 Nov 2018
 * 
 * @param string        $cert   XML del Archivo .cer
 * @param string        $priv   XML del Archivo .key
 */
if(!function_exists('csd_match'))
{
  function csd_match(string $cer, string $priv)
  {
    $xml_cer = new CkXml();
    $xml_key = new CkXml();

    $xml_cer->LoadXml($cer);
    $xml_key->LoadXml($priv);

    $modulus_cer = $xml_cer->FindChild("Modulus")->content();
    $modulus_key = $xml_key->FindChild("Modulus")->content();

    $exponent_cer = $xml_cer->FindChild("Exponent")->content();
    $exponent_key = $xml_key->FindChild("Exponent")->content();

  return ($modulus_cer == $modulus_key && $exponent_cer == $exponent_key);    
  }

}