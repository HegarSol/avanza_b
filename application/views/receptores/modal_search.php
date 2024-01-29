<div class="modal fade" id="modal_receptores_search" tabindex="-1" role="dialog" aria-labelledby="modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class='close' data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title">Busqueda de Receptor</h3>
      </div>
      <div class="modal-body">
        <input type="hidden" id="selected_rfc" value="">
        <input type="hidden" id="selected_nombre" value="">
        <table class="table table-striped" id="tabla_receptores">
          <thead>
            <tr>
              <th>RFC</th>
              <th>Nombre</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($receptores as $receptor): ?>
              <tr>
                <td><?php echo $receptor->rfc_receptor; ?></td>
                <td><?php echo $receptor->nombre_receptor; ?></td>
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
    var tabla_receptores = $('#tabla_receptores').DataTable({
      select: {style: 'single'},
      language: {'url' : "<?php echo base_url('public/json/spanish.json');?>"}
    });

    tabla_receptores
    .on('select', function (e, dt, type, indexes){
      var rowData = tabla_receptores.rows(indexes).data().toArray();
      $('#selected_rfc').val(rowData[0][0]);
      $('#selected_nombre').val(rowData[0][1]);
    })
    .on('deselect', function (){
      $('#selected_rfc').val('');
      $('#selected_nombre').val('');
    })
  });

  function set_values(){
    $('#receptor_rfc').val($('#selected_rfc').val());
    $('#modal_receptores_search').modal('hide');
  }
</script>
