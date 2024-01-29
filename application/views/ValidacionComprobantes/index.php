<?php $this->load->view('templates/header');?>
<div class="container">
   <div class="panel panel-default">
      <div class="panel-heading">
         <center><h3>Listado de Comprobantes Sin Validar</h3></center>
      </div>
      <div class="panel-body">
         <table id="tabla_comprobantes" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
               <tr>
                  <th>UUID</th>
                  <th>Fecha</th>
                  <th>RFC</th>
                  <th>Nombre</th>
                  <th>Estado SAT</th>
                  <th>Acciones</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach($comprobantes as $comprobante):?>
               <tr>
                  <td class="info"><?php echo $comprobante->uuid;?></td>
                  <td><?php echo $comprobante->fecha;?></td>
                  <td><?php echo $comprobante->rfc_emisor;?></td>
                  <td><?php echo $comprobante->nombre_emisor;?></td>
                  <td id="<?php echo $comprobante->uuid;?>"><?php echo $comprobante->estado_sat;?></td>
                  <td>
                     <div class="btn-group">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">Acciones <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                           <li><a href="javascript:void(0)" onclick="valida_uuid('<?php echo $comprobante->uuid;?>')"><i class="fa fa-check-square-o"></i> Validar</a></li>
                           <li><a href="<?php echo base_url('comprobantes/ver/') . $comprobante->uuid;?>" ><i class="fa fa-eye"></i> Ver</a></li>
                        </ul>
                     </div>
                  </td>
               </tr>
               <?php endforeach;?>
            </tbody>
         </table>
      </div>
      <div class="panel-footer">
         <button type="button" class="btn btn-success" onclick="validaTodos()"><i class="fa fa-cloud-download"></i> Valida Todos</button>
      </div>
   </div>
</div>
<script>
   var table = $('#tabla_comprobantes').DataTable({
      language : {url : "<?php echo base_url('public/json/spanish.json');?>" }
   });

   function valida_uuid(uuid){
      $('#' + uuid).text('Validando!!!');
      $.ajax({
         url : "<?php echo base_url('ValidacionComprobantes/valida/');?>" + uuid,
         type : "GET",
         dataType : 'json',
         success : function (data){
            if(data.status){
               $('#' + uuid).text(data.estatus);
            } else {
               $('#' + uuid).text(data.error);
            }
         },
         error : function () {
            $('#' + uuid).text('Error en la Validacion!!');
            }
         });
   }

   function validaTodos(){
      $('td.info').each(function (index){
         valida_uuid(this.innerText);
      });
   }
</script>
<?php $this->load->view('templates/footer');?>
