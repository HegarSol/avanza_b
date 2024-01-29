<?php $this->load->view('templates/header'); ?>
<div class="container">
   <div class="panel panel-primary">
      <div class="panel-heading">
         <center>
            <h2>Asignacion de Empresas</h2>
         </center>
      </div>
      <div class="panel-body">
         <input type="hidden" id="id_usuario" value="<?php echo $id_usuario; ?>">
         <div class="well well-sm"><?php echo $nombre_usuario;?></div>
         <div class="row">
            <div class="col-md-5">Empresas Disponibles</div>
            <div class="col-md-1"></div>
            <div class="col-md-5">Empresas Asignadas al Usuario</div>
         </div>
         <div class="row">
            <div class="form-group">
               <div class="col-md-5 has-error">
                  <select id="disponibles" size="20" multiple class="form-control" name="disponibles">
                     <?php foreach($empresas as $empresa): ?>
                     <option value="<?php echo $empresa->rfc; ?>"><?php echo $empresa->nombre; ?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
               <div class="col-md-1">
                  <div class="btn-group-vertical" role="group" aria-label="...">
                     <button class="btn btn-success" onclick="agregar()"><span class="glyphicon glyphicon-chevron-right"></span></button>
                     <button class="btn btn-danger" onclick="borrar()"><span class="glyphicon glyphicon-chevron-left"></span></button>
                  </div>
               </div>
               <div class="col-md-5 has-success">
                  <select id="asignadas" size="20" multiple class="form-control" name="asignadas">
                     <?php foreach($asignadas as $asig): ?>
                     <option value="<?php echo $asig->rfc; ?>"><?php echo $asig->nombre; ?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
            </div>
         </div>
      </div>
      <div class="panel-footer">
         <a class="btn btn-primary" href="<?php echo base_url('usuarios');?>"><i class="fa fa-undo"></i> Regresar a Listado</a>
      </div>
   </div>
</div>
<script>
   function agregar(){
      var id = $('#disponibles').find(':selected').val();
      var nombre = $('#disponibles').find(':selected').text();
      if(typeof id === 'undefined')
      {
         alert('No se ha seleccionado una empresa para agregar');
         return;
      }
      if($('#asignadas option[value='+id+']').length > 0)
      {
         return;
      }
      $.post("<?php echo base_url('usuarios/asignacion_empresas_save'); ?>",
         {
            id_usuario : $('#id_usuario').val(),
            rfc_empresa : id,
            accion : 'agrega'
         },
         function (data, status){
            if(data)
            {
               $('#asignadas').append($('<option>',{value:id, text: nombre}));
               $('#disponibles option[value='+id+']').remove();
            }
         },
         'json');
   }

   function borrar()
   {
      var id = $('#asignadas').find(':selected').val();
      var nombre = $('#asignadas').find(':selected').text();
      if(typeof id === 'undefined')
      {
         alert('No se ha seleccionado una empresa para eliminar');
         return;
      }
      $.post("<?php echo base_url('usuarios/asignacion_empresas_save'); ?>",
      {
         id_usuario : $('#id_usuario').val(),
         rfc_empresa : id,
         accion : 'borra'
      },
      function (data, status)
      {
         if(data)
         {
            $('#disponibles').append($('<option>',{value : id, text: nombre}));
            $("#asignadas option[value="+id+"]").remove();
         }
      }
   )
   }
</script>
<?php $this->load->view('templates/footer'); ?>
