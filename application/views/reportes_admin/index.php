<?php $this->load->view('templates/header'); ?>
<div class="container">
   <center>
	  <h1>Reportes Administrativos</h1>
   </center>
   <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">
	  <div class="panel panel-default"> <!-- Reporte de facturas -->
		 <div class="panel-heading" role="tab" id="heading-facturas">
			<h4 class="panel-title">
			   <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFacturas" aria-expanded="true" aria-controls="collapseFacturas">
				  Facturas Mensuales
			   </a>
			</h4>
		 </div>
		 <div id="collapseFacturas" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-facturas">
			<div class="panel-body">
			   Reporte de totales a facturar en el periodo seleccionado
			   <form class="form-inline" action="#" method="GET" id="facturas_mes">
				  <div class="form-group">
					 <label for="facturas_select_mes">Mes:</label>
					 <select id="facturas_select_mes" class="form-control" name="mes">
						<option value="1" <?php echo date('n') == 1 ? 'selected' : '';?>>Enero</option>
						<option value="2" <?php echo date('n') == 2 ? 'selected' : '';?>>Febrero</option>
						<option value="3" <?php echo date('n') == 3 ? 'selected' : '';?>>Marzo</option>
						<option value="4" <?php echo date('n') == 4 ? 'selected' : '';?>>Abril</option>
						<option value="5" <?php echo date('n') == 5 ? 'selected' : '';?>>Mayo</option>
						<option value="6" <?php echo date('n') == 6 ? 'selected' : '';?>>Junio</option>
						<option value="7" <?php echo date('n') == 7 ? 'selected' : '';?>>Julio</option>
						<option value="8" <?php echo date('n') == 8 ? 'selected' : '';?>>Agosto</option>
						<option value="9" <?php echo date('n') == 9 ? 'selected' : '';?>>Septiembre</option>
						<option value="10" <?php echo date('n') == 10 ? 'selected' : '';?>>Octubre</option>
						<option value="11" <?php echo date('n') == 11 ? 'selected' : '';?>>Noviembre</option>
						<option value="12" <?php echo date('n') == 12 ? 'selected' : '';?>>Diciembre</option>
					 </select>
				  </div>
				  <div class="form-group">
					 <label for="facturas_anio">A&ntilde;o</label>
					 <input class="form-control" type="number" id="facturas_anio" name="anio" value="<?php echo date('Y'); ?>">
				  </div>
				  <button type="button" class="btn btn-default" onclick="facturarPeriodo()"><i class="fa fa-search"></i> Consultar</button>
			   </form>
			</div>
		 </div>
	  </div> <!-- Reporte Facturas -->
	  <div class="panel panel-default"> <!-- Reporte de Pruebas -->
		 <div class="panel-heading" role="tab" id="heading-pruebas">
			<h4 class="panel-title">
			   <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsePruebas" aria-expanded="false" aria-controls="collapsePruebas">
				  Pruebas
			   </a>
			</h4>
		 </div>
		 <div id="collapsePruebas" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-pruebas">
			<div class="panel-body">
			   Ejemplo de como se deben de agregar los demas reportes
			</div>
		 </div>
	  </div> <!-- Reporte Pruebas -->
   </div>
</div>
<script>
   function facturarPeriodo(){
	  var mes = $('#facturas_select_mes').val();
	  var anio = $('#facturas_anio').val();
	  var win = window.open("<?php echo base_url('reportes_admin/facturarPeriodo/');?>" + mes + '/' + anio);
	  if(win)
	  {
		 win.focus();
	  } else {
		 alert('Favor de desactivar el bloqueo de ventanas');
	  }
   }
</script>
<?php $this->load->view('templates/footer'); ?>
