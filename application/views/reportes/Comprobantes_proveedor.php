<?php $this->load->view('templates/header');?>
<div class="container">
      <div class="panel panel-default">
         <div class="panel-heading">
           <center>
        	  <h1>Reportes de Comprobantes por Proveedor</h1>
           </center>
         </div>
           <div class="panel-body">
             <form class="form-horizontal" action="#" method="GET" id="parametros">
               <div class="form-group">
                 <label for="proveedor_rfc" class="col-sm-2 control-label">RFC:</label>
                 <div class="col-sm-3">
                   <div class="input-group">
                     <input type="text" name="rfc_proveedor" value="<?php echo $rfc;?>" id="proveedor_rfc" class="form-control">
                     <span class="input-group-btn">
                       <button class="btn btn-default" type="button" onclick="buscaProveedor()">
                         <i class="fa fa-search"></i>
                       </button>
                     </span>
                   </div>
                 </div>
                   <?php if(!$modo_estricto):?>
                   <label for="receptor_rfc" class="col-sm-2 control-label">RFC Receptor</label>
                   <div class="col-sm-3">
                       <div class="input-group">
                           <input type="text" name="rfc_receptor" value="" id="receptor_rfc" class="form-control">
                           <span class="input-group-btn">
                               <button class="btn btn-default" type="button" onclick="buscaReceptor()">
                                   <i class="fa fa-search"></i>
                               </button>
                           </span>
                       </div>
                   </div>
                   <?php endif;?>
               </div>
               <div class="form-group">
                 <label for="fecha1" class="col-sm-2 control-label">Fecha Inicial</label>
                 <div class="col-sm-2">
                   <input type="date" name="fechaInicial" class="form-control" id="fecha1">
                 </div>
                 <label for="fecha2" class="col-sm-2 control-label">Fecha Final</label>
                 <div class="col-sm-2">
                   <input type="date" name="fechaFinal" class="form-control" id="fecha2">
                 </div>
               </div>
               <div class="form-group">
                <label for="status-sat" class="col-sm-2 control-label">Estatus SAT</label>
                <div class="col-sm-2">
                  <select name="status_sat" id="status-sat" class="form-control">
                    <option value="">Todos</option>
                    <option value="Vigente">Vigentes</option>
                    <option value="Cancelado">Cancelados</option>
                  </select>
                </div>
                <label for="status" class="col-sm-2 control-label">Status</label>
                <div class="col-sm-2">
                  <select name="status" id="status" class="form-control">
                    <option value="">Todos</option>
                    <option value="A">Aceptados</option>
                    <option value="R">Rechazados</option>
                    <option value="P">Pendientes</option>
                  </select>
                </div>
               </div>
             </form>
           </div>
           <div class="panel-footer">
             <button id="btnPantalla" type="button" class="btn btn-primary"><i class="fa fa-desktop"></i> Ver en Pantalla</button>
             <!--<button id="btnPdf" type="button" class="btn btn-primary"><i class="fa fa-file-pdf-o"></i> PDF</button>-->
           </div>
      </div>
      <div id="espacioReporte"></div>
</div>
<script type="text/javascript">
$('#btnPantalla').click(function (){
  $.ajax({
    url: "<?php echo base_url('reportes/Comprobantes_proveedor/list');?>",
    type: 'POST',
    dataType: 'html',
    data: $('#parametros').serialize(),
    success: function (data){
      $('#espacioReporte').html(data);
      $('#tabla_comprobantes').DataTable({
        language: {"url": "<?php echo base_url('public/json/spanish.json');?>"},
        "columnDefs": [
          {
            "targets" : [-1],
            "orderable" : false
          }
        ]
      });
    },
    error : function (){
      var n = new Noty({text: 'Error al recuperar la informacion', type: 'error', theme: 'relax'}).show()
    }
  })
})

$('#btnPdf').click( function () {
  alert('Funcion no disponible')
})


function buscaProveedor(){
  $.ajax({
    url: "<?php echo base_url('proveedores/search');?>",
    type: 'GET',
    dataType: 'html',
    success: function ( data ){
      $('#espacioReservado').html(data);
      $('#modal_proveedores_search').modal('show');
    },
    error: function () {
      var n = new Noty({text: 'No se puede recuperar el listado de proveedores', type: 'error', theme: 'relax'}).show()
    }
  });
}

function buscaReceptor () {
    $.ajax( {
      url: "<?php echo base_url('receptores/search'); ?>",
      type: 'GET',
      dataType: 'html',
      success: function (data) {
        $('#espacioReservado').html(data);
        $('#modal_receptores_search').modal('show');
      },
      error: function () {
        var n = new Noty({text: 'No se puede recuperar el listado de Receptores', type: 'error', theme: 'relax'}).show();
      }

    })
  }
</script>
<?php $this->load->view('templates/footer');?>
