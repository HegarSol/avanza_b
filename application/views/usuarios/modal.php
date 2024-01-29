<!-- Bootstrap modal -->
<div class="modal fade" id="modal_usuarios" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Agregar Usuario</h3>
      </div>
      <div class="modal-body form">
         <div id="mensaje_error" class="alert alert-danger" role="alert"></div>
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id_usuario"/>
          <div class="form-body">
            <div class="form-group">
               <label class="control-label col-md-3">E-Mail</label>
              <div class="col-md-9">
                <input name="email" placeholder="E-Mail" class="form-control"
                type="mail">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Nombre</label>
              <div class="col-md-9">
                <input name="nombre" placeholder="Nombre de Usuario" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Contrase&ntilde;a</label>
              <div class="col-md-9">
			   <input name="password" placeholder="Contrase&ntilde;a"
               class="form-control" type="password">
              </div>
            </div>
			<div class="form-group">
               <label class="control-label col-md-3">Confirmaci&oacute;n</label>
			   <div class="col-md-9">
				  <input name="confirmacion" placeholder="Confirmaci&oacute;n de Contrase&ntilde;a" class="form-control" type="password">
			   </div>
   			</div>
          </div>
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
