<!-- Bootstrap modal -->
<div class="modal fade" id="modal_certificados" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Agregar Certificado</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form_certificado" enctype="multipart/form-data">
          <div class="form-group">
            <label for="certificado">Certificado</label>
            <input type="file" name="certificado" id="certificado">
          </div>
          <div class="form-group">
            <label for="llave_privada">Llave Privada</label>
            <input type="file" name="llave_privada" id="llave_privada">
          </div>
          <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password">
            <p class="help-block">Contraseña de la llave privada del CSD</p>
          </div>
          <div class="form-group">
            <label for="pass_pfx">Nueva Contraseña PFX</label>
            <input type="password" class="form-control" id="pass_pfx" name="pass_pfx">
            <p class="help-block">
            Contraseña que se usara para hacer las peticiones, para no almacenar la contraseña
            del CSD.
            </p>
          </div>
        </form>
          </div>
          <div class="modal-footer">
             <button type="button" id="btnSave" onclick="save()" class="btn btn-primary"><span class="fa
                   fa-floppy-o"></span> Guardar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-window-close"></span> Cancelar</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->