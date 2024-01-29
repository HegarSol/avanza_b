<?php
// Mostrar todos los errores
error_reporting(1);
ini_set('display_errors', 1);

// Obtener configuracion de ejemplo
$config = require 'config.php';

// Preparar variables
$rutaDescarga = $config['rutaDescarga'];
$maxDescargasSimultaneas = $config['maxDescargasSimultaneas'];

// Instanciar clases principales
require dirname(dirname(__FILE__)).'/lib/DescargaMasivaCfdi.php';
$descargaCfdi = new DescargaMasivaCfdi();

// Preparar datos para busqueda de recibidos
$busqueda = new BusquedaRecibidos();
$busqueda->establecerFecha(2018, 10); // $anio, $mes, $dia=null
// $busqueda->establecerHoraInicial($hora=0, $minuto=0, $segundo=0);
// $busqueda->establecerHoraFinal($hora='23', $minuto='59', $segundo='59');
// $busqueda->establecerRfcEmisor($rfc);
// $busqueda->establecerEstado($estado); // Ejemplo: BusquedaRecibidos::ESTADO_VIGENTE
// $busqueda->establecerFolioFiscal($uuid);

// Preparar datos para busqueda de emitidos
// $busqueda = new BusquedaEmitidos();
// $busqueda->establecerFechaInicial(2017, 10, 1); // $anio, $mes, $dia
// $busqueda->establecerFechaFinal(2017, 10, 15); // $anio, $mes, $dia
// $busqueda->establecerHoraInicial($hora='0', $minuto='0', $segundo='0');
// $busqueda->establecerHoraFinal($hora='0', $minuto='0', $segundo='0');
// $busqueda->establecerRfcReceptor($rfc);
// $busqueda->establecerEstado($estado); // Ejemplo: BusquedaEmitidos::ESTADO_VIGENTE
// $busqueda->establecerFolioFiscal($uuid);

// Instanciar la clase necesaria para uso de certificados FIEL
require dirname(dirname(__FILE__)).'/lib/UtilCertificado.php';
$certificado = new UtilCertificado();

// En ocasiones es necesario establecer manualmente la ruta de OpenSSL
// UtilCertificado::establecerRutaOpenSSL('ruta/a/openssl');

// Cargar certificado
$ok = $certificado->loadFiles(
    dirname(__FILE__).'/certificado.cer',
    dirname(__FILE__).'/certificado.key',
    'password'
);
if(!$ok) {
    die('Error al cargar el certificado FIEL proporcionado.');
}

// Iniciar sesión en el SAT con el certificado
$ok = $descargaCfdi->iniciarSesionFiel($certificado);
if(!$ok) {
    die('Error al iniciar sesión con FIEL.');
}

// Si hay una sesion previa, se recomienda restaurarla en lugar
// de iniciar sesión nuevamente. Esto acelera el proceso.
// $ok = $descargaCfdi->restaurarSesion($sess);

// Mostrar la sesion recien iniciada. Puede guardarla para restaurarla
// y utilizarlo en busquedas posteriores sin necesidad de volver a iniciar sesion.
// var_dump($descargaCfdi->obtenerSesion()); // sesion como String

// Obtener los datos de los CFDIs encontrados
$xmlInfoArr = $descargaCfdi->buscar($busqueda);
if(empty($xmlInfoArr)){
    die('No se han encontrado CFDIS.');
}

// Preparar herramienta para descarga asincrona
$descarga = new DescargaAsincrona($maxDescargasSimultaneas);

// Recorrer array de resultados
foreach ($xmlInfoArr as $xmlInfo) {

    // Mostrar datos del comprobante
    print_r($xmlInfo);

    // Agregar XML a la cola de descarga
    $descarga->agregarXml(
        $xmlInfo->urlDescargaXml,
        $rutaDescarga,
        $xmlInfo->folioFiscal,
        $xmlInfo->folioFiscal
    );

    // Agregar Representación Impresa a la cola de descarga (si aplica)
    if(!empty($xmlInfo->urlDescargaRI)) {
        $descarga->agregarRepImpr(
            $xmlInfo->urlDescargaRI,
            $rutaDescarga,
            $xmlInfo->folioFiscal,
            $xmlInfo->folioFiscal
        );
    }

    // Agregar Acuse a la cola de descarga (si aplica)
    if(!empty($xmlInfo->urlDescargaAcuse)) {
        $descarga->agregarAcuse(
            $xmlInfo->urlDescargaAcuse,
            $rutaDescarga,
            $xmlInfo->folioFiscal,
            $xmlInfo->folioFiscal.'-acuse'
        );
    }
}

// Iniciar proceso de descarga
$descarga->procesar();

// Mostra totales de la descarga
$totalDescargados = $descarga->totalDescargados();
$totalErrores = $descarga->totalErrores();
$segundosTranscurridos = $descarga->segundosTranscurridos();
echo "Descargados: $totalDescargados.\n";
echo "Errores: $totalErrores.\n";
echo "Duración: $segundosTranscurridos segundos.\n";

// Mostrar detalle de la descarga
print_r($descarga->resultado());
echo "\n";
