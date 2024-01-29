<?php $this->load->view('templates/header'); ?>
<div class="container">
   <div class="panel panel-danger">
      <div class="panel-heading">
         <h3 class="panel-title">Acceso Denegado</h3>
      </div>
      <div class="panel-body">
         <p>No cuenta con los permisos necesarios para poder ingresar al modulo
         solicitado</p>
      </div>
      <div class="panel-footer">
         <a href="<?php echo base_url('welcome')?>" class="btn btn-primary"> Ir
            a Inicio</a>
      </div>
   </div>
</div>
<?php $this->load->view('templates/footer'); ?>
