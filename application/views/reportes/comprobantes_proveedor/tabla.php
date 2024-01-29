<table class="table table-striped table-bordered" id="tabla_comprobantes">
  <thead>
    <tr>
      <th>UUID</th>
      <th>Fecha</th>
      <th>Version</th>
      <th>Folio</th>
      <th>Serie</th>
      <th>Total</th>
      <th>Estado</th>
      <th>Estado SAT</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($comprobantes as $comprobante): ?>
      <tr>
        <td><?php echo $comprobante->uuid; ?></td>
        <td><?php echo $comprobante->fecha; ?></td>
        <td><?php echo $comprobante->version; ?></td>
        <td><?php echo $comprobante->folio; ?></td>
        <td><?php echo $comprobante->serie; ?></td>
        <td><?php echo $comprobante->total; ?></td>
          <?php switch($comprobante->status):
          case 'R': ?>
          <td>Rechazado</td>
          <?php break; ?>
          <?php case 'A': ?>
          <td>Aprobado</td>
          <?php break; ?>
          <?php case 'P': ?>
          <td>Pendiente</td>
          <?php break; ?>
          <?php endswitch ?>
        <td><?php echo $comprobante->estado_sat; ?></td>
        <td>
          <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
              <li>
                <a target="_blank" href="<?php echo base_url('comprobantes/ver/') . $comprobante->uuid;?>">
                  <i class="fa fa-eye"></i> Ver
                </a>
              </li>
              <li>
                <a target="_blank" href="<?php echo base_url('comprobantes/pdf/') . $comprobante->uuid;?>">
                  <i class="fa fa-file-pdf-o"></i> PDF
                </a>
              </li>
              <li>
                <a target="_blank" href="<?php echo base_url('comprobantes/xml/') . $comprobante->uuid;?>">
                  <i class="fa fa-code"></i> XML
                </a>
              </li>
            </ul>
          </div>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
