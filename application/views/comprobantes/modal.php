<div class="modal fade" id="modalCargaComprobante" tabindex="-1" role="dialog" aria-labelledby="modalGrande">
   <div class="modal-dialog" role="document">
	  <div class="modal-content">
		 <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
			   <span aria-hidden="true">&times;</span>
			</button>
			<h3 class="modal-title">Almacena Comprobante</h3>
		 </div>
		 <div class="modal-body">
			<form enctype="multipart/form-data" action="#" id="formularioComprobante">
			   <div class="form-group">
				  <label for="xml">Archivo XML</label>
				  <input id="xml" class="form-control" type="file" name="xml">
				  <p class="help-block">Seleccione el archivo XML a almacenar</p>
			   </div>
			   <div class="form-group">
				  <label for="pdf">Archivo PDF</label>
				  <input id="pdf" class="form-control" type="file" name="pdf">
				  <p class="help-block">Seleccione el archivo PDF a almacenar</p>
			   </div>
			</form>
		 </div>
		 <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="button" class="btn btn-primary" onclick="almacenaComprobante()">Almacenar</button>
		 </div>
	  </div>
   </div>
</div>
<script>
   function almacenaComprobante(){
	  var formElement = document.getElementById("formularioComprobante");
	  var formData = new FormData(formElement);
	  formData.append('empresa',"<?php echo $this->session->userdata('rfc_empresa');?>");
	  $.ajax({
		 url : "<?php echo base_url('api/Comprobantes/upload');?>",
		 type : "POST",
		 data : formData,
		 processData : false,
		 contentType : false,
		 success : function (data){
			var n = new Noty({
			   text : "Comprobante Registrado Correctamente",
			   theme : "relax",
			   type : 'success'
			}).show();
			$('#modalCargaComprobante').modal('hide');
		 },
		 error : function(request, status, error){
			var n = new Noty({
			   text : request.responseJSON.error,
			   theme : 'relax',
			   type : 'error'
			}).show();
			$('#modalCargaComprobante').modal('hide');
		 }
	  })
   }
</script>
