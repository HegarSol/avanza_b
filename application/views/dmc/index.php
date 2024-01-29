<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$tipo = null;
switch (empty($_GET['tipo']) ? null : $_GET['tipo']) {
	case 'ciec':
		$tipo = 'ciec';
		break;
	case 'fiel':
		$tipo = 'fiel';
		break;
	case 'ciecc':
	default:
		$tipo = 'ciecc';
		require dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'DescargaMasivaCfdi.php';
		$descargaCfdi = new DescargaMasivaCfdi;
		break;
	
}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Descarga Masiva de CFDIs</title>
		<link href="<?php echo base_url("public/dmc/css/bootstrap.min.css")?>" rel="stylesheet">
		<link href="<?php echo base_url("public/dmc/css/styles.css")?>" rel="stylesheet">
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<span class="navbar-brand">Avanza - DMC</span> <span class="navbar-brand"><a href="<?php echo base_url("welcome")?>" style="color:gray">Inicio</a></span> 
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav navbar-right">
						<li class="<?php echo ($tipo == 'ciecc') ? 'active' : '' ?>"><a href="?tipo=ciecc">CIEC con Captcha</a></li>
						<li class="<?php echo ($tipo == 'fiel') ? 'active' : '' ?>"><a href="?tipo=fiel">FIEL</a></li>
					</ul>
				</div>
			</div>
		</nav>

	    <div id="main">
			<div class="container-fluid">
<?php
if($tipo == 'ciec') {
}elseif($tipo == 'fiel'){
	echo '<h2>Inicio de sesión con FIEL</h2>';
	require 'form-login-fiel.inc.php';
}else{
	echo '<h2>Inicio de sesión con CIEC/Captcha</h2>';
	require 'form-login-ciec-captcha.inc.php';	
}
?>

				<hr/>

				<h2>Descarga</h2>
				<div class="tablas-resultados">
					<div class="overlay"></div>
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#recibidos" aria-controls="recibidos" role="tab" data-toggle="tab">Recibidos</a></li>
						<li role="presentation"><a href="#emitidos" aria-controls="emitidos" role="tab" data-toggle="tab">Emitidos</a></li>
					</ul>
					<div class="tab-content">
					    <div role="tabpanel" class="tab-pane active" id="recibidos">
					    	<?php require 'form-recibidos.inc.php' ?>
							<form method="POST" class="descarga-form">
								<input type="hidden" name="accion" value="descargar-recibidos" />
								<input type="hidden" name="sesion" class="sesion-ipt" />
								<div style="overflow:auto">
									<table class="table table-hover table-condensed" id="tabla-recibidos">
										<thead>
											<tr>
												<th class="text-center">XML</th>
												<th class="text-center">R. Imp.</th>
												<th>Efecto</th>
												<th>Razón Social</th>
												<th>RFC</th>
												<th>Estado</th>
												<th>Folio Fiscal</th>
												<th>Emisión</th>
												<th>Total</th>
												<th>Certificación</th>
												<th>Cancelación</th>
												<th>PAC</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
								<div class="text-right">
									<a href="#" class="btn btn-primary excel-export" download="cfdi_emitidos.xls">Exportar a Excel</a>
									<button type="submit" class="btn btn-success">Descargar seleccionados</button>
									
								</div>
							</form>
							<div class="row">
							    <label for="">Para descargar los archivos ZIP de PDF o XML primero presione "Descargar seleccionados"</label>
								<form action="DMC/descargapdfrecibidos" method="POST">
									<input type="hidden" id="valor2" name="valor2">
									<button type="submit" class="btn btn-info" id="descargarzippdfreci" onclick="descargarzippdfrecibidos()">Descargar ZIP PDF</button>
								</form>
								<br>
								<form action="DMC/descargaxmlrecibidos" method="POST">
									<input type="hidden" id="valor" name="valor">
									<button type="submit" class="btn btn-info" id="descargarzipxmlreci" onclick="descargarzipxmlrecibidos()" >Descargar ZIP XML</button>
								</form>
							</div>
					    </div>
					    <div role="tabpanel" class="tab-pane" id="emitidos">
							<?php require 'form-emitidos.inc.php' ?>
							<form method="POST" class="descarga-form">
								<input type="hidden" name="accion" value="descargar-emitidos" />
								<input type="hidden" name="sesion" class="sesion-ipt" />
								<div style="overflow:auto">
									<table class="table table-hover table-condensed" id="tabla-emitidos">
										<thead>
											<tr>
												<th class="text-center">XML</th>
												<th class="text-center">R. Imp.</th>
												<th class="text-center">Acuse</th>
												<th>Efecto</th>
												<th>Razón Social</th>
												<th>RFC</th>
												<th>Estado</th>
												<th>Folio Fiscal</th>
												<th>Emisión</th>
												<th>Total</th>
												<th>Certificación</th>
												<th>PAC</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
								<div class="text-right">
									<a href="#" class="btn btn-primary excel-export" download="cfdi_emitidos.xls">Exportar a Excel</a>
									<button type="submit" class="btn btn-success">Descargar seleccionados</button>
									
								</div>
							</form>
							<div class="row">
							<label for="">Para descargar los archivos ZIP de PDF o XML primero presione "Descargar seleccionados"</label>
							    <form action="DMC/descargapdfemitidos" method="POST">
								    <input type="hidden" id="valor4" name="valor4">
									<button type="submit" class="btn btn-info" id="descargarzippdfemi" onclick="descargarzippdfemitidos()">Descargar ZIP PDF</button>
								</form>
								<br>
							    <form action="DMC/descargaxmlemitidos" method="POST">
								    <input type="hidden" id="valor3" name="valor3">
									<button type="submit" class="btn btn-info" id="descargarzipxmlemi" onclick="descargarzipxmlemitidos()">Descargar ZIP XML</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script src="<?php echo base_url("public/dmc/js/jquery-3.1.1.min.js")?>"></script>
		<script src="<?php echo base_url("public/dmc/js/bootstrap.min.js")?>"></script>
		
	</body>
</html>

<script>
function descargarzippdfemitidos()
{
	var detallereci = [];
	   $("input[type=checkbox]:checked").each(function(){
            var recibo = [];
			var uuid = $(this).parent().parent().find('td').eq(7).html();
			recibo = [uuid];
			detallereci.push(recibo);
	   });

         document.getElementById('valor4').value = '';
         document.getElementById('valor4').value = detallereci;
}
function descargarzipxmlemitidos()
{
	var detallereci = [];
	     $("input[type=checkbox]:checked").each(function(){
              var recibo = [];
			  var uuid = $(this).parent().parent().find('td').eq(7).html();
			  recibo = [uuid];
			  detallereci.push(recibo);
		 });

		 document.getElementById('valor3').value = '';
         document.getElementById('valor3').value = detallereci;
}
function descargarzipxmlrecibidos()
{

	var detallereci = [];
          $("input[type=checkbox]:checked").each(function(){
                var recibo = [];
				
                var uuid = $(this).parent().parent().find('td').eq(6).html();
                recibo = [uuid];
                detallereci.push(recibo);

			});
			document.getElementById('valor').value = '';
            document.getElementById('valor').value = detallereci;

       
       
}
function descargarzippdfrecibidos()
{
	var detallereci = [];
	  $("input[type=checkbox]:checked").each(function(){
          var recibo = [];
		  var uuid = $(this).parent().parent().find('td').eq(6).html();
		  recibo = [uuid];
		  detallereci.push(recibo);
	  });

	  document.getElementById('valor2').value = '';
	  document.getElementById('valor2').value = detallereci;
}

function disableInputs() {
	$('#main select, #main input, #main .btn').attr('disabled', 'disabled');
}
function enableInputs() {
	$('#main select, #main input, #main .btn').removeAttr('disabled');
}

var tableToExcel = (function() {
    var uri = 'data:application/vnd.ms-excel;base64,',
            template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">'
                             + '<head><meta http-equiv="Content-type" content="text/html;charset=UTF-8" /><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/>'
                             + '</x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
            base64 = function(s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            },
            format = function(s, c) {
                return s.replace(/{(\w+)}/g, function(m, p) {
                    return c[p];
                })
            };
 
    return function(table, name) {
        var ctx = {
            worksheet : name || 'Worksheet',
            table : table.innerHTML
        }
        return uri + base64(format(template, ctx));
    }
})();

$('.excel-export').on('click', function() {
	var $this = $(this);
	var table = $this.closest('.descarga-form').find('.table').get(0);
	var fn = $this.attr('download');
    $this.attr('href', tableToExcel(table, fn));
	// window.location.href = tableToExcel(table, fn);
});

$('.login-form').on('submit', function() {
	var form = $(this);
	var formData = new FormData(form.get(0));

	window.sesionDM = null;
	
	disableInputs();
	$('.tablas-resultados').removeClass('listo');
	$('.tablas-resultados tbody').empty();

	

	$.post({
		url: "async.php",
		dataType: "json",
		data: formData,
		contentType: false,
		processData: false,
		success: function(response) {
			console.debug(response);
			if(response.success && response.data) {
				if(response.data.sesion) {
					window.sesionDM = response.data.sesion;
				}
				$('.tablas-resultados').addClass('listo');
			}
			if(response.data && response.data.mensaje) {
				alert(response.data.mensaje);				
			}
        }
    }).always(function() {
		enableInputs();
		descargarzippdfreci.disabled = true;
		descargarzipxmlreci.disabled = true;
		descargarzippdfemi.disabled = true;
		descargarzipxmlemi.disabled = true;
	});

    return false;
});

$('#recibidos-form').on('submit', function() {
	var form = $(this);
	var formData = new FormData(form.get(0));
	formData.append('sesion', window.sesionDM);

	var tablaBody = $('#tabla-recibidos tbody');

	tablaBody.empty();
	disableInputs();

	$.post({
		url: "async.php",
		dataType: "json",
		data: formData,
		contentType: false,
		processData: false,
		success: function(response) {
			console.debug(response);

			if(response.success && response.data) {
				if(response.data.sesion) {
					window.sesionDM = response.data.sesion;
				}

				var items = response.data.items;
				var html = '';

				for(var i in items) {
					var item = items[i];
					html += '<tr>'
						+ '<td class="text-center">'+(item.urlDescargaXml ? '<input type="checkbox" checked="checked" name="xml['+item.folioFiscal+']" value="'+item.urlDescargaXml+'"/>' : '-')+'</td>'
						+ '<td class="text-center">'+(item.urlDescargaRI ? '<input type="checkbox" checked="checked" name="ri['+item.folioFiscal+']" value="'+item.urlDescargaRI+'"/>' : '-')+'</td>'
						+ '<td>'+item.efecto+'</td>'
						+ '<td class="blur">'+item.emisorNombre+'</td>'
						+ '<td class="blur">'+item.emisorRfc+'</td>'
						+ '<td>'+item.estado+'</td>'
						+ '<td class="blur">'+item.folioFiscal+'</td>'
						+ '<td>'+item.fechaEmision+'</td>'
						+ '<td>'+item.total+'</td>'
						+ '<td>'+item.fechaCertificacion+'</td>'
						+ '<td>'+(item.fechaCancelacion || '-')+'</td>'
						+ '<td class="blur">'+item.pacCertifico+'</td>'
						+ '</tr>'
					;
				}

				tablaBody.html(html);
			}
			if(response.data && response.data.mensaje) {
				alert(response.data.mensaje);				
			}
        }
    }).always(function() {
		enableInputs();
		descargarzippdfreci.disabled = true;
		descargarzipxmlreci.disabled = true;
		descargarzippdfemi.disabled = true;
		descargarzipxmlemi.disabled = true;
	});

    return false;
});

$('#emitidos-form').on('submit', function() {
	var form = $(this);
	var formData = new FormData(form.get(0));
	formData.append('sesion', window.sesionDM);
	var tablaBody = $('#tabla-emitidos tbody');
	
	tablaBody.empty();
	disableInputs();

	$.post({
		url: "async.php",
		dataType: "json",
		data: formData,
		contentType: false,
		processData: false,
		success: function(response) {
			console.debug(response);

			if(response.success && response.data) {
				if(response.data.sesion) {
					window.sesionDM = response.data.sesion;
				}

				var items = response.data.items;
				var html = '';

				for(var i in items) {
					var item = items[i];
					html += '<tr>'
						+ '<td class="text-center">'+(item.urlDescargaXml ? '<input type="checkbox" checked="checked" name="xml['+item.folioFiscal+']" value="'+item.urlDescargaXml+'"/>' : '-')+'</td>'
						+ '<td class="text-center">'+(item.urlDescargaRI ? '<input type="checkbox" checked="checked" name="ri['+item.folioFiscal+']" value="'+item.urlDescargaRI+'"/>' : '-')+'</td>'
						+ '<td class="text-center">'+(item.urlDescargaAcuse ? '<input type="checkbox" checked="checked" name="acuse['+item.folioFiscal+']" value="'+item.urlDescargaAcuse+'"/>' : '-')+'</td>'
						+ '<td>'+item.efecto+'</td>'
						+ '<td class="blur">'+item.receptorNombre+'</td>'
						+ '<td class="blur">'+item.receptorRfc+'</td>'
						+ '<td>'+item.estado+'</td>'
						+ '<td class="blur">'+item.folioFiscal+'</td>'
						+ '<td>'+item.fechaEmision+'</td>'
						+ '<td>'+item.total+'</td>'
						+ '<td>'+item.fechaCertificacion+'</td>'
						+ '<td class="blur">'+item.pacCertifico+'</td>'
						+ '</tr>'
					;
				}

				tablaBody.html(html);
			}
			if(response.data && response.data.mensaje) {
				alert(response.data.mensaje);				
			}
        }
    }).always(function() {
		enableInputs();
		descargarzippdfreci.disabled = true;
		descargarzipxmlreci.disabled = true;
		descargarzippdfemi.disabled = true;
		descargarzipxmlemi.disabled = true;
	});

    return false;
});

$('.descarga-form').on('submit', function() {
	var form = $(this);
	var formData = new FormData(form.get(0));
	formData.append('sesion', window.sesionDM);

	disableInputs();

	$.post({
		url: "async.php",
		dataType: "json",
		data: formData,
		contentType: false,
		processData: false,
		success: function(response) {
			console.debug(response);

			if(response.success && response.data) {
				if(response.data.sesion) {
					window.sesionDM = response.data.sesion;
				}
			}
			if(response.data && response.data.mensaje) {
				alert(response.data.mensaje);				
			}
        }
    }).always(function() {
		enableInputs();
		descargarzippdfreci.enable = true;
		descargarzipxmlreci.enable = true;
		descargarzippdfemi.enable = true;
		descargarzipxmlemi.enable = true;
	});

    return false;
});



</script>

