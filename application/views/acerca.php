<!DOCTYPE html>
<html lang="en">

   <head>

	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	  <meta name="description" content="">
	  <meta name="author" content="">

	  <link rel="shortcut icon" href="<?php echo base_url('public/favicon.ico');?>" />
	  <title>AvanzaB</title>

	  <!-- Bootstrap core CSS -->
	  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	  <!-- Custom fonts for this template -->
	  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
	  <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

	  <!-- Plugin CSS -->
	  <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

	  <!-- Custom styles for this template -->
	  <link href="public/css/creative.min.css" rel="stylesheet">
	  <link rel="stylesheet" href="public/css/dashboard.css">
   </head>

   <body id="page-top">

	  <!-- Navigation -->
	  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
	  <div class="container">
		 <a class="navbar-brand js-scroll-trigger" href="#page-top">AvanzaB</a>
		 <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		 </button>
		 <div class="collapse navbar-collapse" id="navbarResponsive">
			<ul class="navbar-nav ml-auto">
			   <li class="nav-item">
			   <a class="nav-link js-scroll-trigger" href="#about">Acerca</a>
			   </li>
			   <li class="nav-item">
			   <a class="nav-link js-scroll-trigger" href="#services">Ventajas</a>
			   </li>
			   <li class="nav-item">
			   <a class="nav-link js-scroll-trigger" href="#precios">Precios</a>
			   </li>
			   <li class="nav-item">
			   <a class="nav-link js-scroll-trigger" href="#contact">Contacto</a>
			   </li>
			   <li class="nav-item"><a class="nav-link" href="<?php echo base_url('login');?>">LogIn</a></li>
			</ul>
		 </div>
	  </div>
	  </nav>

	  <header class="masthead">
	  <div class="header-content">
		 <div class="header-content-inner">
		    <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-md-offset-2">
                    <!-- <center><label style= "font-family:Calibri,'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:100">AVANZA C</label></center><br><br> -->
                        <center><img src="<?php echo base_url('public/img');?>/AVANZAB.png" class="img-responsive" alt="Responsive image"></center><br><br>                        
                    </div>
                </div>
            </div>
			<h2 id="homeHeading">Todas las facturas de tus proveedores en un solo lugar</h2>
			<hr>
			<p>Si el almacenamiento de las facturas de proveedores es un caos, concentralas todas en una única dirección de correo electrónico y nosotros nos encargamos de organizarlas y validarlas..</p>
			<a class="btn btn-primary btn-xl js-scroll-trigger" href="#about">Descubre M&aacute;s</a>
		 </div>
	  </div>
	  </header>

	  <section class="bg-primary" id="about">
	  <div class="container">
		 <div class="row">
			<div class="col-lg-8 mx-auto text-center">
			   <h2 class="section-heading text-white">Tenemos lo que necesitas</h2>
			   <hr class="light">
			   <p class="text-faded">AvanzaB es una aplicación web que ofrece un medio de recepción de CFDi’s para almacenarlos y consultarlos de manera sencilla.</p>
			   <p class="text-faded">Una vez almacenados, podrás consultar la información contenida en los CFDi y validarlos ante el SAT.</p>
			   <a class="btn btn-default btn-xl js-scroll-trigger" href="#services">Empieza Ahora</a>
			</div>
		 </div>
	  </div>
	  </section>

	  <section id="services">
	  <div class="container">
		 <div class="row">
			<div class="col-lg-12 text-center">
			   <h2 class="section-heading">Ventajas</h2>
			   <hr class="primary">
			</div>
		 </div>
	  </div>
	  <div class="container">
		 <div class="row">
			<div class="col-lg-3 col-md-6 text-center">
			   <div class="service-box">
				  <i class="fa fa-4x fa-envelope-o text-primary sr-icons"></i>
				  <h3>Recepci&oacute;n mediante E-Mail</h3>
				  <p class="text-muted">Pide a tus proveedores que envien sus facturas a tu cuenta de correo y nosotros nos encargamos del resto.</p>
			   </div>
			</div>
			<div class="col-lg-3 col-md-6 text-center">
			   <div class="service-box">
				  <i class="fa fa-4x fa-check-square text-primary sr-icons"></i>
				  <h3>Validaci&oacute;n</h3>
				  <p class="text-muted">Al momento de recibir el comprobante se valida que no haya sido alterado.</p>
			   </div>
			</div>
			<div class="col-lg-3 col-md-6 text-center">
			   <div class="service-box">
				  <i class="fa fa-4x fa-qrcode text-primary sr-icons"></i>
				  <h3>Estatus con la Autoridad</h3>
				  <p class="text-muted">Podrás validar que el comprobante que recibiste se encuentre debidamente registrado ante la autoridad.</p>
			   </div>
			</div>
			<div class="col-lg-3 col-md-6 text-center">
			   <div class="service-box">
				  <i class="fa fa-4x fa-code text-primary sr-icons"></i>
				  <h3>Web API</h3>
				  <p class="text-muted">Si cuentas con tu sistema de contabilidad, podrás enlazarlo a AvanzaB mediante nuestra WebAPI para realizar todas las funciones necesarias para el control de tus facturas automáticamente.</p>
			   </div>
			</div>
		 </div>
		 <div class="row">
			<div class="col-lg-3 col-md-6 text-center">
			   <div class="service-box">
				  <i class="fa fa-4x fa-briefcase text-primary sr-icons"></i>
				  <h3>Multiempresa</h3>
				  <p class="text-muted">Tendr&aacute;s el control de todas tus empresas con un mismo usuario.</p>
			   </div>
			</div>
			<div class="col-lg-3 col-md-6 text-center">
			   <div class="service-box">
				  <i class="fa fa-4x fa-reply text-primary sr-icons"></i>
				  <h3>Redireccionamiento de Correo</h3>
				  <p class="text-muted">Configuración de las respuestas de la aplicación a otras cuentas de correo.</p>
			   </div>
			</div>
			<div class="col-lg-3 col-md-6 text-center">
			   <div class="service-box">
				  <i class="fa fa-4x fa-truck text-primary sr-icons"></i>
				  <h3>Gastos por cuenta del cliente</h3>
				  <p class="text-muted">Si eres Agencia Aduanal también podrás recibir las facturas de gastos por cuenta del cliente.</p>
			   </div>
			</div>
			<div class="col-lg-3 col-md-6 text-center">
			   <div class="service-box">
				  <i class="fa fa-4x fa-print text-primary sr-icons"></i>
				  <h3>Reportes</h3>
				  <p class="text-muted">Reportes y gráficas sobre la información almacenada en su buzón.</p>
			   </div>
			</div>
		 </div>
	  </div>
	  </section>

	  <section id="precios">
	  <div class="container">
		 <div class="row">
			<div class="col-lg-12 text-center">
			   <h2>Precios</h2>
			   <hr class="primary">
			   <p>Todos los paquetes tienen un costo fijo de <strong>$ 276.15</strong> pesos m&aacute;s el volumen seg&uacute;n el siguiente tabulador.</p>
			</div>
		 </div>
	  </div>
	  <div class="container">
		 <div class="table-responsive">
			<table class="table table-striped">
			   <thead>
				  <tr>
					 <th>Inicial</th>
					 <th>Final</th>
					 <th>Precio</th>
				  </tr>
				  <tbody>
					 <tr>
						<td>1</td>
						<td>100</td>
						<td>$ 0.36</td>
					 </tr>
					 <tr>
						<td>101</td>
						<td>300</td>
						<td>$ 0.30</td>
					 </tr>
					 <tr>
						<td>301</td>
						<td>500</td>
						<td>$ 0.24</td>
					 </tr>
					 <tr>
						<td>501</td>
						<td>1,000</td>
						<td>$ 0.19</td>
					 </tr>
					 <tr>
						<td>1,001</td>
						<td>+</td>
						<td>$ 0.13</td>
					 </tr>
				  </tbody>
			   </thead>
			</table>
			<div class="alert alert-info">
			   <ul>
				  <li>Los Precios NO incluyen IVA</li>
				  <li>Los Precios se calculan por los comprobantes recibidos en el mes a facturar</li>
				  <li>Se incluyen todas las actualizaciones disponibles</li>
				  <li>Almacenamiento garantizado por 5 a&ntilde;os</li>
			   </ul>
				  <strong>Ejemplos:</strong>
				  <br>
				  <p>
				  Si se reciben 350 facturas mensuales el c&aacute;lculo ser&iacute;a: <strong>276.15 + (350.00 * 0.24) = $ 360.15 MXN + IVA</strong>
				  <br>
				  Si se reciben 80 facturas mensuales el c&aacute;lculo ser&iacute;a: <strong>276.15 + (80.00 * 0.36) = $ 304.95 MXN + IVA</strong>
				  </p>
			</div>
		 </div>
	  </div>
	  </section>

	  <div class="call-to-action bg-dark">
		 <div class="container text-center">
			<h2>Si ya cuentas con tu usuario y contraseña</h2>
			<a class="btn btn-default btn-xl sr-button" href="<?php echo base_url('login');?>">Inicia Sesión</a>
		 </div>
	  </div>

	  <section id="contact">
	  <div class="container">
		 <div class="row">
			<div class="col-lg-8 mx-auto text-center">
			   <h2 class="section-heading">Cont&aacute;ctanos</h2>
			   <hr class="primary">
			   <p>¿Listo para comenzar a utilizar nuestro servicio? Ll&aacute;manos o envia un correo electr&oacute;nico y nos pondremos en contacto lo m&aacute;s pronto posible.</p>
			</div>
		 </div>
		 <div class="row">
			<div class="col-lg-4 ml-auto text-center">
			   <i class="fa fa-phone fa-3x sr-contact"></i>
			   <p>867-389-8112</p>
			</div>
			<div class="col-lg-4 mr-auto text-center">
			   <i class="fa fa-envelope-o fa-3x sr-contact"></i>
			   <p>
			   <a href="mailto:info@hegarss.com">info@hegarss.com</a>
			   </p>
			</div>
		 </div>
	  </div>
	  </section>
		<!-- Comentario para el taller -->
	  <!-- Bootstrap core JavaScript -->
	  <script src="vendor/jquery/jquery.min.js"></script>
	  <script src="vendor/popper/popper.min.js"></script>
	  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

	  <!-- Plugin JavaScript -->
	  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
	  <script src="vendor/scrollreveal/scrollreveal.min.js"></script>
	  <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

	  <!-- Custom scripts for this template -->
	  <script src="public/js/creative.min.js"></script>
    <!-- Comentarios -->
   </body>

</html>
