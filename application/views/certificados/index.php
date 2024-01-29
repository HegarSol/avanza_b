<?php $this->load->view('templates/header')?>
<div class="container">
  <div class="panel panel-info">
    <div class="panel-heading">
      <center><h3>Listado de Certificados Almacenados</h3></center>
    </div>
    <div class="panel-body">
      <table class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th># Certificado</th>
            <th>Fecha Inicio</th>
            <th>Fecha Vencimiento</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($certificados as $certificado): ?>
          <tr>
            <td><?php echo $certificado->no_certificado?></td>
            <td><?php echo $certificado->fecha_inicio?></td>
            <td><?php echo $certificado->fecha_vence?></td>
            <td><button type="button" onclick="borrar('<?php echo $certificado->no_certificado; ?>')" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>
          </tr>
          <?php endforeach;?>
        </tbody>
      </table>
    </div>
    <div class="panel-footer">
      <button onclick="agregar()" type="button" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Agregar</button>
    </div>
  </div>
</div>
<?php $this->load->view('certificados/modal')?>
<script>
  var save_method;

  function agregar()
  {
    save_method = 'create';
    $('#form_certificado')[0].reset();
    $('#modal_certificados').modal('show');
  }

   function save()
   {
     var url = "<?php echo base_url('api/certificados')?>"
     var formElement = document.getElementById("form_certificado");
     var formData = new FormData(formElement);
     $.ajax({
       url: url,
       type: 'POST',
       data: formData,
       processData: false,
       contentType: false,
       success: (res) => {
          $('#modal_certificados').modal('hide');
          var n = new Noty({text: 'Certificado Almacenado Correctamente', theme: 'relax', type: 'success'}).show();
          location.reload();
       },
       error: (request, status, error) => {
         var n = new Noty({
           text: request.responseJSON.error,
           theme: 'relax',
           type: 'error'
         }).show();
       }

     });
   }

   function borrar(no_cer)
   {
     var n = new Noty({
       text: "Desea eliminar el certificado",
       type: 'warning',
       theme: 'relax',
       buttons:[
         Noty.button('Si', 'btn btn-danger', function(){
          $.ajax({
            url: "<?php echo base_url('api/certificados/')?>" + no_cer,
            type: 'DELETE',
            dataType: 'json',
            success: (res) => {
              location.reload();
            },
            error: (request, status, error) => {
              var no = new Noty({
                text: request.responseJSON.error,
                theme: 'relax',
                type: 'error' 
              }).show();
            }
          });
         }),
         Noty.button('No', 'btn btn-default', function(){
           n.close();
         })
       ]
     }).show();
   }

</script>
<?php $this->load->view('templates/footer')?>