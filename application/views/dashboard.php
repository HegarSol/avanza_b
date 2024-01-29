<link href="<?php echo base_url('public/css/dashboard.css'); ?>" rel="stylesheet">
<div class="container">
   <div class="panel panel-primary">
      <div class="panel-heading">
         <center>
            <h1>AvanzaB</h1>
         </center>
      </div>
      <div class="panel-body">
            <div class="row">
               <div class="col-sm-3">
				  <div class="hero-widget alert alert-success">
                     <div class="icon"><i class="fa fa-hdd-o"></i></div>
                     <div class="text">
						<var><?php echo $total_comprobantes; ?></var>
						<label class="text-muted">Comprobantes del Periodo</label>
                     </div>
					 <div class="options">
						<a class="btn btn-default btn-lg" href="<?php echo base_url('comprobantes'); ?>"><i class="fa fa-eye"></i> Ver Todos</a>
					 </div>
                  </div>
               </div>
				<div class="col-sm-3">
				   <div class="hero-widget alert alert-warning">
					  <div class="icon"><i class="fa fa-qrcode"></i></div>
					  <div class="text">
						 <var><?php echo $sin_validar_sat; ?></var>
						 <label class="text-muted">Sin Validar ante el SAT</label>
					  </div>
					  <div class="options">
						 <a class="btn btn-default btn-lg" href="<?php echo base_url('validacionComprobantes');?>"><i class="fa fa-eye"></i> Ver</a>
					  </div>
				   </div>
				</div>
				<?php if(!$this->session->usa_api_contabilidad): ?>
				<div class="col-sm-3">
				   <div class="hero-widget alert alert-info">
					  <div class="icon"><i class="fa fa-exclamation"></i></div>
					  <div class="text">
						 <var><?php echo $sin_aprobar; ?></var>
						 <label class="text-muted">Pendientes por Aprobar</label>
					  </div>
					  <div class="options">
						<a class="btn btn-default btn-lg" href="<?php echo base_url('pendientes');?>"><i class="fa fa-eye"></i> Ver</a>
					  </div>
				   </div>
				</div>
				<?php endif; ?>
				<div class="col-sm-3">
				   <div class="hero-widget alert alert-danger">
					  <div class="icon"><i class="fa fa-ban"></i></div>
					  <div class="text">
						 <var><?php echo $rechazados; ?></var>
						 <label class="text-muted">Rechazados sin Cancelar</label>
					  </div>
					  <div class="options">
						 <a class="btn btn-default btn-lg" href="<?php echo base_url('rechazados');?>"><i class="fa fa-eye"></i> Ver</a>
					  </div>
				   </div>
				</div>
				<div class="col-sm-3">
				   <div class="hero-widget alert alert-info">
					  <div class="icon"><i class="fa fa-download"></i></div>
					  <div class="text">
					     <h1>Avanza-DMC</h1>
						 <label class="text-muted">Descarga Masiva de CFDI</label>
						 
					  </div>
					  <div class="options">
					  
						 <a class="btn btn-default btn-lg" onclick="verifica()" ><i class="fa fa-chevron-right"></i> Ir</a>			
					  </div>
				   </div>
				</div>
            </div>
      </div>
      <div class="panel-footer">
      </div>
   </div>
</div>



<script>
function verifica()
{

   var fechavenci = '<?php echo $dmcmasiva->fechaMasiva ?>';
   var fechaactual = '<?php echo date('Y-m-d') ?>';


   var activa = "<?php echo $dmcmasiva->activaMasiva ?>";
	if(activa == 1)
	{
		if(fechaactual <= fechavenci)
		{
			location.href = "<?php echo base_url('DMC');?>";
		}
		else
		{
			var noty = new Noty({text : 'A expirado su servicio. Favor de comunicarte a Hegar Soluciones en Sistemas, S. DE R. L. para renovar.', theme : 'relax', type : 'warning'}).show();
		}
		
	}
	else
	{
		var noty = new Noty({text : 'El servicio se encuentra desactivado para tu cuenta. Favor de comunicarte a Hegar Soluciones en Sistemas, S. DE R. L. para obtener información detallada.', theme : 'relax', type : 'warning'}).show();
	}
}
</script>