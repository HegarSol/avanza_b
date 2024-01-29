<?php $this->load->view('templates/header');?>
<div class="container">
   <div class="panel panel-danger">
	  <div class="panel-heading">
		 <center>
			<h2>Comprobantes Rechazados Sin Cancelar</h2>
		 </center>
	  </div>
	  <div class="panel-body">
		 <div class="table-responsive">
			<?php echo $this->table->generate($Comprobantes);?>
		 </div>
	  </div>
	  <div class="panel-footer">
		 <button class="btn btn-success" type="button" onclick="validar_todos()">
			<i class="fa fa-cloud-download"></i>
			Validar Todos
		 </button>
	  </div>
   </div>
</div>
<script>
   function validar_todos(){
	  $('#rechazados > tbody > tr').each(function () {
		 var statusCell = $(this).find('td')[7];
		 var uuid = $(this).find('td')[1].innerText;
		 valida_uuid(uuid, statusCell);
	  });
   }

   function valida_uuid(uuid, statusCell){
	  statusCell.innerText = 'Validando!!';
      $.ajax({
         url : "<?php echo base_url('ValidacionComprobantes/valida/');?>" + uuid,
         type : "GET",
         dataType : 'json',
         success : function (data){
            if(data.status){
			   statusCell.innerText = data.estatus;
            } else {
               statusCell.innerText = data.error;
            }
         },
         error : function () {
			statusCell.innerText = 'Error en la Validacion!!';
		 }
	  });
   }
</script>
<?php $this->load->view('templates/footer');?>
