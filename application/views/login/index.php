<style>
   body{
         background: url("<?php echo base_url('public/images/QR_codes.jpg');?>") no-repeat center center fixed;
         background-size: cover;
      }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-info" style="margin-top:50px;">
                <div class="panel-heading">
                    <h4 class="text-center">Inicio de Sesi&oacute;n</h4>
                </div>
                <div class="panel-body">
                    <?php if(validation_errors()): ?>
                        <div class="alert alert-danger alert-dismissable" role="alert">
                            <button type="button" class="close" data-dismiss="alert"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <?php echo validation_errors();//$this->aauth->print_errors(); ?>
                        </div>
                    <?php endif; ?>
                    <?php echo form_open('login/login_user'); ?>
                        <div class="form-group">
                            <label for="user" class="sr-only">Usuario</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-user"></i></span>
                              <input type="email" class="form-control" name="user" id="user" placeholder="Ingrese Correo Electr&oacute;nico" value="<?php echo set_value('user'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pass" class="sr-only">Contrase&ntilde;a</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
                              <input type="password" class="form-control" name="pass" id="pass" placeholder="Ingrese Contrase&ntilde;a">
                            </div>
                        </div>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="remember"> Recordarme
                          </label>
                        </div>
                        <button type="submit" class="btn btn-success btn-block"><i class="fa fa-sign-in"></i> Ingresar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

