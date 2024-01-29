<?php $this->load->view('templates/header'); ?>
<div class="container">
   <div class="panel panel-default">
      <div class="panel-heading">
         <h3>Errores en Recepcion de Correos</h3>
      </div>
      <div class="panel-body">
         <table id="tabla_errores" class="table table-striped table-bordered" cellspacing="0">
            <thead>
               <tr>
                  <th>Fecha</th>
                  <th>De</th>
                  <th>Asunto</th>
                  <th>Error</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach($errores as $error): ?>
               <tr>
                  <td><?php echo $error->when;?></td>
                  <td><?php echo $error->from;?></td>
                  <td><?php echo $error->subject;?></td>
                  <td><?php echo $error->log;?></td>
               </tr>
               <?php endforeach; ?>
            </tbody>
         </table>
      </div>
      <div class="panel-footer"></div>
   </div>
</div>
<script>
   var table = $('#tabla_errores').DataTable({
      language : {url : "<?php echo base_url('public/json/spanish.json');?>"}
      });
</script>
<?php $this->load->view('templates/footer'); ?>
