<div class="modal fade" id="modal_proveedores_search" tabindex="-1" role="dialog" aria-labelledby="modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class='close' data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title">Busqueda de Proveedor</h3>
      </div>
      <div class="modal-body">
        <input type="hidden" id="selected_rfc" value="">
        <input type="hidden" id="selected_nombre" value="">
        <table class="table table-striped" id="tabla_proveedores">
          <thead>
            <tr>
              <th>RFC</th>
              <th>Nombre</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($proveedores as $proveedor): ?>
              <tr>
                <td><?php echo $proveedor->rfc_proveedor; ?></td>
                <td><?php echo $proveedor->nombre_proveedor; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="set_values()"><i class="fa fa-check"></i> Seleccionar</button>
        <button type="button" class="btn btn-danger" data-dismiss='modal'><i class="fa fa-close"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready( function () {
    var tabla_proveedores = $('#tabla_proveedores').DataTable({
      select: {style: 'single'},
      language: {'url' : "<?php echo base_url('public/json/spanish.json');?>"}
    });

    tabla_proveedores
    .on('select', function (e, dt, type, indexes){
      var rowData = tabla_proveedores.rows(indexes).data().toArray();
      $('#selected_rfc').val(rowData[0][0]);
      $('#selected_nombre').val(rowData[0][1]);
    })
    .on('deselect', function (){
      $('#selected_rfc').val('');
      $('#selected_nombre').val('');
    })
  });

  function set_values(){
    $('#proveedor_rfc').val($('#selected_rfc').val());
    $('#modal_proveedores_search').modal('hide');
  }
</script>
