<?php $this->load->view('templates/header'); ?>
<div class="container">
   <div class="panel panel-default">
      <div class="panel-heading">
         <h3>Configuraci&oacute;n de Empresa</h3>
      </div>
      <div class="panel-body form">
         <div id="message_error" class="alert alert-danger" alert="role"></div>
         <form id="form" class="form-horizontal" action="#">
            <input type="hidden" name="rfc_empresa" value="<?php echo $emp->rfc;?>">
            <ul id="config" class="nav nav-tabs" role="tablist">
               <li role="presentation" class="active">
                  <a href="#smtp" data-toggle="tab" role="tab" aria-controls="smtp">SMTP</a>
               </li>
               <li role="presentation">
                  <a href="#pop" data-toggle="tab" role="tab" aria-controls="pop">POP</a>
               </li>
               <li role="presentation">
                  <a href="#otros" data-toggle="tab" role="tab" aria-controls="otros">Otras Configuraciones</a>
               </li>
            </ul>
            <div id="config-content" class="tab-content">
               <!-- Contenido de la pestana de SMTP -->
               <div id="smtp" class="tab-pane fade in active" role="tabpanel">
                  <br>
                  <div class="form-group">
                     <label class="control-label col-md-2" for="smtp_host">Host:</label>
                     <div class="col-md-4">
                        <input id="smtp_host" class="form-control" type="text" name="smtp_host" 
                        placeholder="Servidor SMTP" value="<?php echo $emp->host_smtp; ?>">
                     </div>
                     <label class="control-label col-md-1" for="smtp_port">Puerto:</label>
                     <div class="col-md-2">
                        <input id="smtp_port" class="form-control" type="text" name="smtp_port" 
                        placeholder="Puerto SMTP" value="<?php echo $emp->port_smtp; ?>">
                     </div>
                     <div class="form-group">
                        <label class="control-label col-md-1">Seguridad</label>
                        <div class="col-sm-2">
                           <select name="smtp_ssl" id="smtp_ssl" class="form-control">
                           <option value="0" <?php echo $emp->ssl_smtp == 0 ? 'selected' : ''?>>Ninguna</option>
                           <option value="1" <?php echo $emp->ssl_smtp == 1 ? 'selected' : ''?>>SSL</option>
                           <option value="2" <?php echo $emp->ssl_smtp == 2 ? 'selected' : ''?>>STARTTLS</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="control-label col-md-2" for="smtp_user">Usuario:</label>
                     <div class="col-md-4">
                        <input id="smtp_user" class="form-control" type="text" name="smtp_user"
                        placeholder="Usuario SMTP" value="<?php echo $emp->user_smtp; ?>">
                     </div>
                     <label class="control-label col-md-1" for="smtp_pass">Contrase&ntilde;a:</label>
                     <div class="col-md-4">
                        <input id="smtp_pass" class="form-control" type="password" name="smtp_pass"
                        placeholder="Contrase&ntilde;a SMTP" aria-describedby="helpPassSmtp">
                        <span id="helpPassSmtp" class="help-block">Por
                           privacidad y motivos de seguridad, la
                           contrase&ntilde;a no puede ser recuperada, escriba
                           una nueva contrase&ntilde;a si desea modificarla.</span>
                     </div>
                  </div>
               </div>
               <!-- Contenido del tab POP -->
               <div id="pop" class="tab-pane fade" role="tabpanel">
                  <br>
                  <div class="form-group">
                     <label class="control-label col-md-2" for="pop_host">Host:</label>
                     <div class="col-md-4">
                        <input id="pop_host" class="form-control" type="text" name="pop_host" 
                        placeholder="Servidor POP" value="<?php echo $emp->host_pop; ?>">
                     </div>
                     <label class="control-label col-md-2" for="pop_port">Puerto:</label>
                     <div class="col-md-2">
                        <input id="pop_port" class="form-control" type="text" name="pop_port"
                        placeholder="Puerto POP" value="<?php echo $emp->port_pop; ?>">
                     </div>
                     <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-1">
                           <div class="checkbox">
                              <label>
                                 <input type="checkbox" name="pop_ssl" value="1"
                                 <?php echo $emp->ssl_pop == 1 ? 'checked' : ''; ?>> SSL
                              </label>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="control-label col-md-2" for="pop_user">Usuario:</label>
                     <div class="col-md-4">
                        <input id="pop_user" class="form-control" type="text" name="pop_user"
                        placeholder="Usuario POP" value="<?php echo $emp->user_pop; ?>">
                     </div>
                     <label class="control-label col-md-2" for="pop_pass">Contrase&ntilde;a:</label>
                     <div class="col-md-4">
                        <input id="pop_pass" class="form-control" type="password" name="pop_pass"
                        placeholder="Contrase&ntilde;a POP"
                        aria-describedby="helpPassPop">
                        <span id="helpPassPop" class="help-block">Por
                           privacidad y motivos de seguridad, la
                           contrase&ntilde;a no puede ser recuperada, escriba
                           una nueva contrase&ntilde;a si desea modificarla.</span>
                     </div>
                  </div>
               </div>
               <!-- Contenido de la pestana, Otras Configuraciones -->
               <div id="otros" class="tab-pane fade" role="tabpanel">
                  <br>
                  <div class="form-group">
                     <div class="col-sm-offset-1 col-sm-2">
                        <div class="checkbox">
                           <label>
                              <input type="checkbox" name="estricto" value="1"
                              aria-describedby="helpEstricto"
                              <?php echo $emp->estricto == 1 ? 'checked' :
                                 ''; ?>> Modo Estricto
                           </label>
                        </div>
                     </div>
                     <span id="helpEstricto" class="help-block">Si se activa
                        esta casilla solo se permitir&aacute; la
                        recepci&oacute;n de comprobantes que el RFC receptor
                        sea igual a: <?php echo $emp->rfc; ?></span>
                  </div>
               </div>
            </div>
         </form>
      </div>
      <div class="panel-footer">
         <button class="btn btn-primary" onclick="guardar()"><span class="fa fa-floppy-o"></span> Guardar</button>
      </div>
   </div>
</div>
<script>
   $(document).ready( function () {
      $('#message_error').hide();
      } )
   function guardar()
   {
      $('#message_error').hide();
      var url = "<?php echo base_url('empresas/save_config'); ?>";
      $.ajax({
         url : url,
         type: 'POST',
         data: $('#form').serialize(),
         dataType: 'json',
         success: function (data)
         {
            if(data.status){
               alert('Cambios Guardados Correctamente');
            } else {
               $('#message_error').html(data.errors);
               $('#message_error').show();
            }
         }
      });
   }
</script>
<?php $this->load->view('templates/footer'); ?>
