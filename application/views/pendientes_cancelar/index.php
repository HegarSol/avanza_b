<?php $this->load->view('templates/header'); ?>
<div class="container">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <center>
        <h2>Solicitudes Pendientes por Aceptar o Rechazar</h2>
      </center>
    </div>
    <div class="panel-body">
      <div class="container">
        <span class="label label-danger"><i class="fa fa-ban"></i> Cancela el Comprobante</span>
        <span class="label label-success"><i class="fa fa-check"></i> Mantiene vigente el Comprobante</span>
      </div>
      <br>
      <div class="alert alert-danger" role="alert"><strong>Este proceso no se puede revertir</strong></div>
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>UUID</th>
            <th>Fecha</th>
            <th>RFC</th>
            <th>Nombre</th>
            <th>Total</th>
            <th>Acciones</th>
          </tr>
        </thead> 
        <tbody>
          <?php foreach($uuids as $uuid => $comprobante):?>
            <tr>
              <td><?php echo $uuid?></td>
              <?php if($comprobante): ?>
                <td><?php echo $comprobante->fecha?></td>
                <td><?php echo $comprobante->rfc_emisor?></td>
                <td><?php echo $comprobante->nombre_emisor?></td>
                <td><?php echo '$ ' . number_format($comprobante->total,2);?></td>
              <?php else: ?>
                <td colspan="4" class="warning">El comprobante no se encuentra almacenado en AvanzaB</td>
              <?php endif; ?>
              <td>
                <div class="btn-group btn-group-xs" role="group" aira-labeledby="...">
                  <button onclick="aceptar('<?php echo $uuid;?>')" type="button" class="btn btn-danger"><i class="fa fa-ban"></i></button>                
                  <button onclick="rechazar('<?php echo $uuid;?>')" type="button" class="btn btn-success"><i class="fa fa-check"></i></button>
                  <?php if($comprobante): ?>
                  <div class="btn-group btn-group-xs" role="group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false"><span class="caret"></span></button>
                    <ul class="dropdown-menu">
                      <li><a target="_blank" href="<?php echo base_url('comprobantes/ver/') . $uuid;?>"><i class="fa fa-eye"></i> Ver</a></li>
                      <li><a target="_blank" href="<?php echo base_url('comprobantes/xml/') . $uuid;?>"><i class="fa fa-file-code-o"></i> XML</a></li>
                      <li><a target="_blank" href="<?php echo base_url('comprobantes/pdf/') . $uuid;?>"><i class="fa fa-file-pdf-o"></i> PDF</a></li>
                    </ul>
                  </div>
                  <?php endif; ?>
                </div>
              </td>  
            </tr>
          <?php endforeach;?>
        </tbody>
      </table>
    </div>
    <div class="panel-footer">
      <p>
      Para aceptar o rechazar una petición de cancelación es necesario tener un CSD vigente
      <a href="<?php echo base_url('certificados')?>" class="btn btn-primary btn-sm"><span class="fa fa-expeditedssl"></span> Certificados</a>
      </p>
    </div>
  </div>
</div>
<script>
function aceptar(uuid)
{
  var n = new Noty({
    text: 'El comprobante sera cancelado, continuar ?',
    type: 'error',
    theme: 'mint',
    buttons: [
      Noty.button('Si', 'btn btn-success', () => {
        procesar_peticion(uuid, 'A');
        n.close();
      }, {id: 'btn-si', 'data-status': 'ok'}),
      Noty.button('No', 'btn btn-danger', () => {
        n.close();
      })
    ]
  });
  n.show();
}

function rechazar(uuid)
{
  var n = new Noty({
    text: 'El comprobante continuara vigente, continuar ?',
    type: 'success',
    theme: 'mint',
    buttons: [
      Noty.button('Si', 'btn btn-success', () => {
        procesar_peticion(uuid, 'R');
        n.close();
      }, {id: 'btn-si', 'data-status': 'ok'}),
      Noty.button('No', 'btn btn-danger', () => {
        n.close();
      })
    ]
  });
  n.show();
}

function procesar_peticion(uuid, accion)
{
  $.ajax({
    url: "<?php echo base_url('api/PendientesProcesar/procesa_peticion')?>",
    type: 'POST',
    dataType: 'json',
    data: {uuid: uuid, accion: accion},
    success: (res) => {
      location.reload();
    },
    error: (res, status, error) => {
      var n = new Noty({
        text: res.responseJSON.error,
        type: 'error',
        theme: 'relax'
      }).show();
      
    }
  });
}

</script>
<?php $this->load->view('templates/footer'); ?>