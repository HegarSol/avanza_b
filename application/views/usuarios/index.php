<?php $this->load->view('templates/header'); ?>
<div class="container">
   <div class="panel panel-default">
      <div class="panel-heading">
         <h3>Listado de Usuarios</h3>
      </div>
      <div class="panel-body">
         <table class="table table-striped table-bordered" id="tabla_usuarios" cellspacing="0" width="100%">
            <thead>
               <tr>
                  <th>Id</th>
                  <th>E-Mail</th>
                  <th>Nombre</th>
                  <th>Ultimo Login</th>
                  <th>Ultima Actividad</th>
                  <th>IP</th>
                  <th style="width:125px">Acciones</th>
               </tr>
            </thead>
            <tbody>
               <?php $usuarios = $this->aauth->list_users(); ?>
               <?php foreach($usuarios as $usuario):?>
               <tr>
                  <td><?php echo $usuario->id; ?></td>
                  <td><?php echo $usuario->email; ?></td>
                  <td><?php echo $usuario->name; ?></td>
                  <td><?php echo $usuario->last_login; ?></td>
                  <td><?php echo $usuario->last_activity; ?></td>
                  <td><?php echo $usuario->ip_address; ?></td>
                  <td>
                     <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">Acciones <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                           <li>
                              <a href="<?php echo base_url('usuarios/asignacion_empresas/') . $usuario->id; ?>">Asignar Empresas</a>
                           </li>
                        </ul>
                     </div>
                  </td>
               </tr>
               <?php endforeach; ?>
            </tbody>
         </table>
      </div>
      <div class="panel-footer">
         <button type="button" class="btn btn-success" onclick="agregar_usuario()"><span class="fa fa-plus"></span> Agregar</button>
      </div>
   </div>
</div>
<script>
   $(document).ready( function (){
      $('#tabla_usuarios').DataTable();
   });

   var save_method;
   var table;

   function agregar_usuario()
   {
      save_method = 'add';
      $('#form')[0].reset();
      $('#mensaje_error').hide();
      $('#modal_usuarios').modal('show');
   }

   function save()
   {
      var url;
      if(save_method == 'add')
      {
         url = "<?php echo base_url('usuarios/add')?>"   
      }
      $.ajax({
         url : url,
         type: 'POST',
         dataType : 'json',
         data : $('#form').serialize(),
         success : function (data) {
            if(data.correcto){
               $('#modal_usuarios').modal('hide');
               location.reload();
            } else {
               $('#mensaje_error').html(data.mensaje);
               $('#mensaje_error').show();
            }
         
         },
         error : function (){
            alert('Error en la peticion de agregar el usuario');
         }
      });
   }
</script>
<?php $this->load->view('usuarios/modal');?>
<?php $this->load->view('templates/footer'); ?>
