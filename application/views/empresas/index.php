<?php $this->load->view('templates/header'); ?>
<div class="container">
   <div class="panel panel-default">
      <div class="panel-heading">
         <h3>Registro de Empreas</h3>
      </div>
      <div class="panel-body">
         <table id="tabla_empresas" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
               <tr>
                  <th>R.F.C.</th>
                  <th>Nombre</th>
                  <th>Activo</th>
                  <th>Acciones</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach($empresas as $empresa): ?>
               <tr>
                  <td><?php echo $empresa->rfc; ?></td>
                  <td><?php echo $empresa->nombre; ?></td>
                  <td><?php echo $empresa->activo == 1 ? 'Si' : 'No'; ?></td>
                  <td>
                     <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">Acciones <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                           <li><a href="javascript:void(0)" onclick="borrar('<?php echo $empresa->rfc;?>')"><i class="fa fa-trash"></i> Eliminar</a></li>
                           <li><a href="javascript:void(0)" onclick="edit('<?php echo $empresa->rfc;?>')"><i class="fa fa-pencil"></i> Modificar</a></li>
                           <li><a href="<?php echo base_url('empresas/config/') . $empresa->rfc;?>"><i class="fa
                                 fa-cog"></i> Configuraci&oacute;n</a></li>
                           <?php if($empresa->activo == 1): ?>
                           <li><a href="javascript:void(0)" onclick="desactivar('<?php echo $empresa->rfc;?>')"><i class="fa fa-toggle-off"></i> Desactivar</a></li>
                           <?php else:?>
                           <li><a href="javascript:void(0)" onclick="activar('<?php echo $empresa->rfc;?>')"><i class="fa fa-toggle-on"></i> Activar</a></li>
                           <?php endif;?>
                        </ul>
                     </div>
                  </td>
               </tr>
               <?php endforeach;?>
            </tbody>
         </table>
      </div>
      <div class="panel-footer">
         <button type="button" class="btn btn-success" onclick="agregar_empresa()">
            <span class="fa fa-plus"></span> Agregar Empresa
         </button>
      </div>
   </div>
   <pre id="log-activacion" hidden>
      <b>Verificacion de configuraci&oacute;n de la cuenta</b>
      Validacion de SMTP: <var id="valid_smtp"></var>
      Validacion de POP: <var id="valid_pop"></var>
      Activar Empresa: <var id="valid_activar"></var>
      <div id="test"></div>
   </pre>
</div>
<script>
   $(document).ready( function () {
      $('#tabla_empresas').DataTable({
         language : {"url" : "<?php echo base_url('public/json/spanish.json') ?>"}
      });
   });

   var save_method;
   var table;

   function agregar_empresa(){
      save_method = 'add';
      $('#form')[0].reset();
      $('[name="rfc"]').prop('readonly', false);
      $('#modal_empresas').modal('show');
   }

   function edit(id){
      save_method = 'update';
      $('#form')[0].reset();
      $.ajax({
         url : "<?php echo base_url('empresas/get/');?>"+id,
         type : "GET",
         dataType : 'json',
         success : function (data){
            console.log(data);
            $('[name="rfc"]').val(id);
            $('[name="nombre"]').val(data.nombre);
            $('[name="rfc"]').prop('readonly', true);
            $('[name="api_cont"]').prop('checked', (data.api == 1) ? true : false);
            $('[name="dmc"]').prop('checked',(data.activaMasiva == 1) ? true : false);
            $('[name="fechadmc"]').val(data.fechaMasiva);
            $('#modal_empresas').modal('show');
         }
      })
   }

   function borrar(id){
      var n = new Noty({
         text : 'Deseas eliminar la empresa del sistema?',
         type : 'warning',
         theme : 'relax',
         closeWith : 'button',
         buttons : [
         Noty.button('Si', 'btn btn-danger', function (){
            $.post("<?php echo base_url('empresas/delete');?>",
            {
               rfc : id
            },
            function (data, status) {
               if(!data.success){
                  var err = new Noty({text : data.errors, type : 'error', theme : 'relax'}).show();
                  return;
               }
            },
            'json');
            n.close();
            location.reload();
         }),
         Noty.button('No', 'btn btn-default', function (){
            n.close();
         })
         ]
      }).show();
   }

   function desactivar(id)
   {
      $.post("<?php echo base_url('empresas/desactivar');?>",
      {
         rfc : id
      },
      function (data, status){
         if(!data.success){
            var n = new Noty({text : data.error, type : 'error', theme : 'relax'}).show();
            return;
         }
      },
      'json'
      );
      location.reload();
   }

   function activar(id)
   {
      var div = $('#log-activacion');
      $('#valid_smtp').text('');
      $('#valid_pop').text('');
      div.prop('hidden', false);
      $.ajax({
         url : "<?php echo base_url('api/empresas/smtp_check/');?>" + id,
         type : 'GET',
         dataType : 'json',
         timeout : 120000,
         success : function (data){
            if(!data.status)
            {
               $('#valid_smtp').text('ERROR  -  ' + data.error);
            } else {
               $('#valid_smtp').text('CORRECTO');
               $.ajax({
                  url : "<?php echo base_url('api/empresas/pop_check/');?>" + id,
                  type : 'GET',
                  dataType : 'json',
                  success : function (data){
                     if(!data.status){
                        $('#valid_pop').text('ERROR - ' + data.error);
                     } else {
                        $('#valid_pop').text('CORRECTO');
						$.ajax({
						   url : "<?php echo base_url('api/empresas/activar');?>",
						   type : 'POST',
						   data : {rfc : id},
						   dataType : 'json',
						   success : function (data){
							  if(!data.status)
							  {
								 $('#valid_activar').text('ERROR - ' + data.error);
							  } else {
								 $('#valid_activar').text('CORRECTO');
								 alert('Empresa Activada Correctamente');
								 location.reload();
							  }
						   }
						});
                     }
                  },
                  error : function (){
                     $('#valid_pop').text('ERROR EN LA COMUNICACION');
                  }
               });
            }
         },
         error : function(){
            $('#valid_smtp').text('ERROR DE CONEXION');
         }
      });
   }

   function save()
   {
      var url;
      url = "<?php echo base_url('empresas/')?>" + save_method;
      $.ajax({
         url : url,
         type : 'POST',
         data : $('#form').serialize(),
         dataType : 'json',
         success : function (data) {
            if(data.status){
               $('#modal_empresas').modal('hide');
               location.reload();
               var n = new Noty({text : "Empresa registrada correctamente", theme : 'relax', type : 'success'}).show();
            } else {
               var n = new Noty({ text : data.errors, theme : 'relax', type : 'error' }).show();
            }
         },
         error : function (){
            var noty = new Noty({text : 'Error al tratar de guardar la empresa', theme : 'relax', type : 'error'}).show();
         }
      });
   }
</script>
<?php $this->load->view('empresas/modal'); ?>
<?php $this->load->view('templates/footer'); ?>
