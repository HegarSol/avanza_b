<?php $this->load->view('templates/header');?>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <center>
                <h2>Comprobantes pendientes de Procesar</h2>
            </center>
        </div>
        <div class="panel-body">
                <table class="table table-striped table-bordered" id="tabla_comprobantes">
                    <thead>
                        <tr>
                            <th>UUID</th>
                            <th>Folio</th>
                            <th>Serie</th>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th width="115px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($comprobantes as $comprobante): ?>
                        <tr>
                            <td><?php echo $comprobante->uuid;?></td>
                            <td><?php echo $comprobante->folio;?></td>
                            <td><?php echo $comprobante->serie;?></td>
                            <td><?php echo $comprobante->nombre_emisor;?></td>
                            <td><?php echo $comprobante->fecha;?></td>
                            <td><?php echo $comprobante->total;?></td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group" aira-labeledby="...">
                                    <button onclick="aceptar('<?php echo $comprobante->uuid;?>')" type="button" class="btn btn-success"><i class="fa fa-check"></i></button>
                                    <button onclick="rechazar('<?php echo $comprobante->uuid;?>')" type="button" class="btn btn-danger"><i class="fa fa-ban"></i></button>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false"><span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?php echo base_url('comprobantes/ver/') . $comprobante->uuid;?>"><i class="fa fa-eye"></i> Ver</a></li>
                                            <li><a href="<?php echo base_url('comprobantes/xml/') . $comprobante->uuid;?>"><i class="fa fa-file-code-o"></i> XML</a></li>
                                            <li><a href="<?php echo base_url('comprobantes/pdf/') . $comprobante->uuid;?>"><i class="fa fa-file-pdf-o"></i> PDF</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
        </div>
        <div class="panel-footer">
        <span class="label label-success"><i class="fa fa-check"></i> Acepta el Comprobante</span>
        <span class="label label-danger"><i class="fa fa-ban" ></i> Rechaza el Comprobante</span>
        </div>
    </div>
</div>
<?php $this->load->view('pendientes/mensaje');?>
<script>
var tabla = $('#tabla_comprobantes').DataTable({
    language : {'url' : "<?php echo base_url('public/json/spanish.json');?>"},
    columnDefs : [
        {
            targets : [-1],
            orderable : false,
            searchable : false
        }
    ]
});
var metodo = '';

function aceptar(uuid){
    metodo = 'acepta';
    $('#uuid').val(uuid);
    $('.help-block').addClass('sr-only');
    $('#helpAcepta').removeClass('sr-only');
    $('.form-group').removeClass('has-error');
    $('.modal-title').text('Descripcion del comprobante');
    $('#modal_mensaje').modal('show');
}

function rechazar(uuid){
    metodo = 'rechaza';
    $('#uuid').val(uuid);
    $('.help-block').addClass('sr-only');
    $('#helpRechaza').removeClass('sr-only');
    $('.form-group').addClass('has-error');
    $('.modal-title').text('Motivo de Rechazo');
    $('#modal_mensaje').modal('show');
}

function save(){
    var url = "<?php echo base_url('pendientes/');?>" + metodo;
    $.ajax({
        url: url,
        type: 'POST',
        data: $('#form_mensaje').serialize(),
        dataType: 'json',
        success: function (data) {
            if(data.success){
                $('#modal_mensaje').modal('hide');
                location.reload();
                var n = new Noty({text: "Cambios Guardados Correctamente", theme: 'relax', type: 'success'}).show();
            } else {
                var n = new Noty({text: data.errors, theme: 'relax', type: 'error'}).show();
            }
        },
        error: function () {
            var n = new Noty({text: 'Error al tratar de guardar los cambios', theme: 'relax'}).show();
        }
    })
}
</script>
<?php $this->load->view('templates/footer');?>