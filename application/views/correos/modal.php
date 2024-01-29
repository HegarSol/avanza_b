<!-- Bootstrap modal -->
<div class="modal fade" id="modal_correos" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Agregar Correo</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
           <input type="hidden" name="id" value="">
          <div class="form-body">
            <div class="form-group">
               <label class="control-label col-md-3">R.F.C. Emisor</label>
              <div class="col-md-9">
                <input name="rfc_emisor" placeholder="R.F.C." class="form-control"
                type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">E-Mail</label>
              <div class="col-md-9">
                 <input name="email" placeholder="Correo Electr&oacute;nico" class="form-control" type="email">
              </div>
            </div>
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
