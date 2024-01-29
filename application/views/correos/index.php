<?php $this->load->view('templates/header'); ?>
<div class="container">
   <div class="panel panel-default">
      <div class="panel-heading">
         <center>
            <h3>Direccionamiento de Correos Electr&oacute;nicos</h3>
         </center>
      </div>
      <div class="panel-body">
         <table id="tabla_correos" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
               <tr>
                  <th>R.F.C. Emisor</th>
                  <th>Correo Destino</th>
                  <th>Acciones</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach($correos as $correo): ?>
               <tr>
                  <td><?php echo $correo->rfc_emisor; ?></td>
                  <td><?php echo $correo->email; ?></td>
                  <td>
                     <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" 
                           aria-haspopup="true" aria-expanded="false">Acciones <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                           <li><a href="javascript:void(0)" onclick="borrar(<?php echo $correo->id;?>)">Eliminar</a></li>
                           <li><a href="javascript:void(0)" onclick="modificar(<?php echo $correo->id;?>)">Modificar</a></li>
                        </ul>
                     </div>
                  </td>
               </tr>
               <?php endforeach; ?>
            </tbody>
         </table>
      </div>
      <div class="panel-footer">
         <button onclick="agregar()" class="btn btn-success"><i class="fa fa-plus"></i> Agregar</button>
      </div>
   </div>
</div>
<script>
   $(document).ready(function (){
      var table = $('#tabla_correos').DataTable({
         language : {"url" : "<?php echo base_url('public/json/spanish.json'); ?>"}
      });
   });

   var save_method;
   function borrar(id){
      var n = new Noty({
         text : "Deseas eliminar el registro?",
         type: 'warning',
         theme : 'relax',
         buttons : [
            Noty.button('Si', 'btn btn-danger', function (){
               $.post("<?php echo base_url('correos/delete');?>",
               {
                  id : id
               },
               function (data, status) {
                  if(!data.success){
                     alert(data.message);
                  }
               },
               'json');
               n.close();
               location.reload();
            },{id : 'btnSi', 'data-status' : 'ok'}),

            Noty.button('No', 'btn btn-default', function (){
               n.close();
               })
         ]
         }).show();
   }

   function agregar()
   {
      save_method = 'add';
      $('#form')[0].reset();
      $('#modal_correos').modal('show');
      $('.modal-title').text('Agregar Correo');
   }

   function modificar(id)
   {
      save_method = 'edit';
      $('#form')[0].reset();
      $.ajax({
         url : "<?php echo base_url('correos/get/');?>"+id,
         type : 'GET',
         dataType : 'json',
         success : function (data){
            $('[name="rfc_emisor"]').val(data.rfc_emisor);
            $('[name="email"]').val(data.email);
            $('[name="id"]').val(data.id);
            $('#modal_correos').modal('show');
            $('.modal-title').text('Editar Correo');
            }
         })
   }

   function save()
   {
      var url = "<?php echo base_url('correos/');?>"+save_method;
      $.ajax({
         url : url,
         type : 'POST',
         data : $('#form').serialize(),
         dataType : 'json',
         success : function (data){
            if(data.success){
               $('#modal_correos').modal('hide');
               var n = new Noty({text: 'Correo almacenado correctamente', theme : 'relax'});
               location.reload();
            } else {
               var n = new Noty({text: data.errors, type: 'error', theme: 'relax'}).show();
            }
         }
      });
   }
</script>
<?php $this->load->view('correos/modal');?>
<?php $this->load->view('templates/footer'); ?>
