<!-- Bootstrap modal -->
<div class="modal fade" id="modal_mensaje" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title"></h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form_mensaje" class="form-horizontal">
          <input type="hidden" name="uuid" id="uuid" value="">
          <div class="form-body">
            <div class="form-group">
              <div class="col-md-12">
                <textarea name="mensaje" placeholder="Motivo" class="form-control"></textarea>
                <p id="helpAcepta" class="help-block sr-only">Indique la descripcion del comprobante para su facil deteccion en el futuro.</p>
                <p id="helpRechaza" class="help-block sr-only">Indique el motivo por el cual se esta rechazando el comprobante.</p>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="btnSave" onclick="save()" class="btn btn-success"><span class="fa
          fa-floppy-o"></span> Aceptar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-window-close"></span> Cancelar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->