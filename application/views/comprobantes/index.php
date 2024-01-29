<?php $this->load->view('templates/header');?>
<div class="">
   <div class="panel panel-default">
      <div class="panel-heading">
         <center><h3>Listado de Comprobantes Recibidos</h3></center>
      </div>
      <div class="panel-body">
         <table id="tabla_comprobantes" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
               <tr>
                  <th>Version</th>
                  <th>UUID</th>
                  <th>Tipo Comprobante</th>
                  <th>Fecha</th>
                  <th>Folio</th>
                  <th>Serie</th>
                  <th>RFC</th>
                  <th>Nombre</th>
                  <th>Total</th>
                  <th>Status</th>
                  <th>Fecha Validacion</th>
                  <th>Acciones</th>
               </tr>
            </thead>
            <tbody></tbody>
         </table>
      </div>
      <div class="panel-footer">
        <button type="button" data-toggle="modal" data-target="#descargararchivos" class="btn btn-success">Descarga Multiple Archivos</button>
      </div>
   </div>
</div>

<div class="modal fade" id="descargararchivos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-blue">
             
              <h4 class="modal-title" id="myModalLabel">Descargar Multiples Archivos</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                  <div class="row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-4">
                           <label for="">Fecha Inicial:</label>
                           <input type="date" class="form-control" id="fechaini" name="fechaini">
                        </div>
                        <div class="col-md-4">
                           <label for="">Fecha Final</label>
                           <input type="date" class="form-control" id="fechafin" name="fechafin">
                        </div>
                  </div>
                  <br>
                  <br>
                  <div class="row">
                      <div class="col-md-3">
                      </div>
                      <div class="col-md-3">
                          <button type="button" onclick="descargarpdf()" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Descargar PDF</button>
                      </div>
                      <div class="col-md-3">
                          <button type="button" onclick="descargarxml()" class="btn btn-primary"><i class="fa fa-file-code-o"></i> Descargar XML</button>
                      </div>
                  </div>
                  <br>
                  <!-- <div class="row">
                     <div class="col-md-4">
                     </div>
                     <div class="col-md-3">
                         <button type="button" class="btn btn-warning">Descargar <i class="fa fa-file-pdf-o"></i> PDF y <i class="fa fa-file-code-o"></i> XML </button>
                     </div>
                  </div> -->
                </div>

            </div>
            <div class="modal-footer">
            </div>
          </div>
        </div>
      </div>


<script>
function descargarpdf()
{
   var ini = document.getElementById('fechaini').value;
   var fin = document.getElementById('fechafin').value;

  if(ini == '' || fin == '')
  {
      var n = new Noty({
      text: 'Favor de elegir las fechas',
      type: 'warning',
      theme: 'mint'
   });
   n.show();
  }
  else
  {
      jQuery.ajax({
         type:"POST",
         dataType: "html",
         success:function()
         {
            window.open("<?php echo base_url();?>comprobantes/descargarmultiplepdf/" + ini + '/' + fin)
         }
      });
  }
   
}
function descargarxml()
{
   var ini = document.getElementById('fechaini').value;
   var fin = document.getElementById('fechafin').value;

   if(ini == '' || fin == '')
  {
      var n = new Noty({
         text: 'Favor de elegir las fechas',
         type: 'warning',
         theme: 'mint'
      });
      n.show();
  }
  else
  {

      jQuery.ajax({
         type:"POST",
         dataType:"html",
         success:function()
         {
            window.open("<?php echo base_url();?>comprobantes/descargarmultiplexml/" + ini + '/' + fin)
         }
      });
  }
}
</script>





<script>

   $(document).ready(function(){
      var table = $('#tabla_comprobantes').DataTable({
         processing: true,
         serverSide: true,
         ajax: {
            "url" : "<?php echo base_url('comprobantes/ajax_table'); ?>",
            "type" : "POST"
         },
         columns : [
            {data: "c.version"},
            {data: "c.uuid"},
            {data: "c.tipo_comprobante"},
            {data: "c.fecha"},
            {data: "c.folio"},
            {data: "c.serie"},
            {data: "c.rfc_emisor"},
            {data: "c.nombre_emisor"},
            {data: "c.total"},
            {data: "c.estado_sat"},
            {data: "c.fecha_validacion"},
            {
               targets : -1,
               data: null,
               defaultContent : "<button class='btn btn-default' title='Ver'><i class='fa fa-eye'></i></button><button class='btn btn-primary' title='Descargar XML'><i class='fa fa-file-code-o'></i></button><button class='btn btn-danger' title='Descargar PDF'><i class='fa fa-file-pdf-o'></i></button>",
               searchable: false,
               orderable: false
            }
         ],
         language : {"url" : "<?php echo base_url('public/json/spanish.json'); ?>" }
      });

      $('#tabla_comprobantes tbody').on('click' , '.btn-default', function(e){
         var data = table.row($(this).parents('tr')).data();
         window.location.href = "<?php echo base_url('comprobantes/ver/');?>" + data.c.uuid;
      });

      $('#tabla_comprobantes tbody').on('click' , '.btn-primary', function(e){
         var data = table.row($(this).parents('tr')).data();
         window.open("<?php echo base_url('comprobantes/descargarXML/'); ?>" + data.c.uuid)
      });

      $('#tabla_comprobantes tbody').on('click' , '.btn-danger', function(e){
         var data = table.row($(this).parents('tr')).data();
         window.open("<?php echo base_url('comprobantes/descargarPDF/'); ?>" + data.c.uuid)
      });
   });
</script>
<?php $this->load->view('templates/footer');?>
