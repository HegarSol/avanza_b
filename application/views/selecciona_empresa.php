<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="shortcut icon" href="<?php echo base_url('public/favicon.ico'); ?>"/>
   <title>Selecciona Empresa</title>

   <link rel="stylesheet" href="<?php echo base_url('public/css/bootstrap.min.css'); ?>">
   <style>
      body{
            background: url("<?php echo base_url('public/images/QR_codes.jpg'); ?>") no-repeat center center fixed;
            background-size: cover;
         }
   </style>
</head>
<body>
   <div class="container">
      <div class="row">
         <div class="col-md-5 col-md-offset-4">
            <div class="panel panel-info" style="margin-top:50px">
               <div class="panel-heading">
                  <h4 class="text-center">Selecciona Empresa</h4>
               </div>
               <div class="panel-body">
                  <?php echo form_open('login/set_empresa'); ?>
                  <div class="form-group">
                     <label for="empresa"><i class="fa fa-industry"></i> Empresa</label>
                     <select id="empresa" class="form-control" name="empresa">
                        <?php foreach($empresas as $row): ?>
                        <option value="<?php echo $row->rfc; ?>"><?php echo $row->nombre; ?></option>
                        <?php endforeach; ?>
                     </select>
                  </div>
                  <button type="submit" name="seleccionar" class="btn btn-primary">Seleccionar</button>
                  <?php echo form_close(); ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</body>
</html>
