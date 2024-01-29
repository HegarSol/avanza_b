<!DOCTYPE html>
<html lang="en">
   <head>
	  <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <meta name="description" content="Aplicacion para el almacenamiento y validacion de CFDis">
	  <meta name="author" content="HEGAR Soluciones en Sistemas S. de R.L.">

	  <link rel="shortcut icon" href="<?php echo base_url('public/favicon.ico');?>" />
	  <title>AvanzaB</title>

	  <link href="<?php echo base_url("public/css/bootstrap.min.css")?>" rel="stylesheet"/>
	  <link href="<?php echo base_url("public/css/font-awesome.min.css")?>" rel="stylesheet"/>
	  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.15/b-1.3.1/b-colvis-1.3.1/b-print-1.3.1/r-2.1.1/sc-1.4.2/se-1.2.2/datatables.min.css"/>
	  <link rel="stylesheet" href="<?php echo base_url('public/css/noty.css');?>">
		<link rel="stylesheet" href="<?php echo base_url('public/css/sweetalert2.min.css'); ?>">


	  <script src="<?php echo base_url('public/js/jquery.js')?>"></script>
	  <script src="<?php echo base_url('public/js/bootstrap.min.js')?>"></script>
	  <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.15/b-1.3.1/b-colvis-1.3.1/b-print-1.3.1/r-2.1.1/sc-1.4.2/se-1.2.2/datatables.min.js"></script>
	  <script src="<?php echo base_url('public/js/noty.min.js');?>"></script>
	  <script src="<?php echo base_url('public/js/toolbar.js'); ?>"></script>
		<script src="<?php echo base_url('public/js/sweetalert2.min.js');?>"></script>
   </head>
   <body>
	  <?php if($this->aauth->is_loggedin()):?>
	  <nav class="navbar navbar-default navbar-static-top">
	  <div class="container-fluid">
		 <div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			   <span class="sr-only">Toggle navigation</span>
			   <span class="icon-bar"></span>
			   <span class="icon-bar"></span>
			   <span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo base_url('welcome');?>">AvanzaB</a>
		 </div>
		 <div id="navbar" class="navbar-collapse collapse ">
			<ul class="nav navbar-nav">
			   <li><a href="<?php echo base_url('welcome');?>"><i class="fa fa-pie-chart"></i> Inicio</a></li>
			   <li class="dropdown">
			   <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
				  aria-expanded="false"><i class="fa fa-bar-chart-o"></i> Reportes <span class="caret"></span></a>
			   <ul class="dropdown-menu">
				  <li><a href="<?php echo base_url('errores'); ?>"><i class="fa fa-exclamation-circle"></i> Log de Errores</a></li>
          <li>
            <a href="<?php echo base_url('reportes/comprobantes_proveedor');?>">
              <i class="fa fa-list-alt"></i> Comprobantes por Proveedor
            </a>
          </li>
				  <?php if($this->aauth->is_admin()): ?>
				  <li><a href="<?php echo base_url('reportes_admin');?>"><i class="fa fa-bank"></i> Reporte Facturacion</a></li>
				  <?php endif; ?>
			   </ul>
			   </li>
         <li>
          <a href="<?php echo base_url('PendientesAceptarCancelar')?>"><i class="fa fa-ban"></i> Pendientes Aceptar Cancelar</a>
         </li>
			   <button class="btn btn-default navbar-btn" onclick="<?php echo "muestraModalCargaComprobantes('". base_url() . "')";?>"><i class="fa fa-plus-circle"></i></button>
			</ul>
			<ul class="nav navbar-nav navbar-right">
			   <li class="dropdown">
			   <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
				  aria-expanded="false"><span class="fa fa-cogs"></span> Configuraci&oacute;n <span
					 class="caret"></span></a>
			   <ul class="dropdown-menu">
				  <li><a href="<?php echo base_url('empresas/config'); ?>"><span class="fa fa-cog"></span> Configuraci&oacute;n de Empresa</a></li>
				  <li><a href="<?php echo base_url('correos'); ?>"><span class="fa fa-envelope"></span>
					 Direccionamiento de Correos</a></li>
           <li><a href="<?php echo base_url('certificados')?>"><span class="fa fa-expeditedssl"></span> Certificados</a></li>
				  <?php if($this->aauth->is_admin()):?>
				  <li><a href="<?php echo base_url('usuarios'); ?>"><span class="fa fa-users"></span> Registro de Usuarios</a></li>
				  <li><a href="<?php echo base_url('empresas'); ?>"><span class="fa fa-building"></span> Registro de Empresas</a></li>
				  <?php endif; ?>
			   </ul>
			   </li>
			   <li>
			   <a href="<?php echo base_url('login/logout_user');?>"><i class="fa fa-sign-out"></i> Salir</a>
			   </li>
			</ul>
		 </div><!--/.nav-collapse -->
	  </div>
	  </nav>
	  <?php endif; ?>
	  <div class="container-fluid">
		 <?php if($this->aauth->is_loggedin()): ?>
		 <p class="text-muted container">Trabajando en la Empresa:
		 <b><?php echo $this->session->userdata('rfc_empresa') . ' - ' . $this->session->userdata('nombre_empresa');?> </b>
		 <?php if(!$this->session->userdata('unica_empresa')): ?>
		 <a class="btn btn-warning" href="<?php echo base_url('login/cambia_empresa');?>"><i class="fa
			   fa-refresh"></i> Cambiar</a>
		 <?php endif; ?>
		 </p>
		 <?php endif; ?>
