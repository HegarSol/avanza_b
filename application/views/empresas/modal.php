<!-- Bootstrap modal -->
<div class="modal fade" id="modal_empresas" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Agregar Empresa</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <div class="form-body">
            <div class="form-group">
               <label class="control-label col-md-3">R.F.C.</label>
              <div class="col-md-9">
                <input name="rfc" placeholder="R.F.C." class="form-control"
                type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Nombre</label>
              <div class="col-md-9">
                <input name="nombre" placeholder="Nombre de Empresa" class="form-control" type="text">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="api_cont" id="api_cont" value="1">
                  Usa API?
                </label>
                <p class="help-block">Si se activa, solo podra ingresar la informacion de contabilidad desde la API</p>
              </div>
            </div>
            <div class="col-sm-offset-3 col-sm-9">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="dmc" id="dmc" value="1">
                  Servicio DMC 
                </label>
              </div>
            </div>
            <div class="col-sm-offset-3 col-sm-5">
            <br>
            <label for="">Fecha Vencimiento</label>
                <input type="date" class="form-control" id="fechadmc" name="fechadmc">
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
