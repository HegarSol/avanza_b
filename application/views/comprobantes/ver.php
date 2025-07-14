<?php $this->load->view('templates/header'); ?>
<style>
   .form-control[readonly]{
         background-color: blanchedalmond;
      }
</style>
<div class="container">
   <div class="panel panel-default">
      <div class="panel-heading">
         <center><h3>COMPROBANTE</h3></center>
      </div>
      <div class="panel-body">
         <div class="row">
            <div class="col-md-3">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_tipoComp" class="input-group-addon">Tipo Comprobante</span>
                     <input type="text" class="form-control" aria-describedby="addon_tipoComp" readonly value="<?php echo $comprobante->tipo_comprobante;?>">
                  </div>
               </div>
            </div>
            <div class="col-md-2">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_version" class="input-group-addon">Version</span>
                     <input type="text" class="form-control" aria-describedby="addon_version" readonly value="<?php echo $comprobante->version;?>">
                  </div>
               </div>
            </div>
            <div class="col-md-7">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_uuid" class="input-group-addon">UUID</span>
                     <input type="text" id="uuid" class="form-control" aria-describedby="addon_uuid" readonly id="uuid" value="<?php echo $comprobante->uuid;?>">
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-3">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_folio" class="input-group-addon">Folio</span>
                     <input type="text" class="form-control" aria-describedby="addon_folio" readonly value="<?php echo $comprobante->folio;?>">
                  </div>
               </div>
            </div>
            <div class="col-md-2">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_serie" class="input-group-addon">Serie</span>
                     <input type="text" class="form-control" aria-describedby="addon_serie" readonly value="<?php echo $comprobante->serie;?>">
                  </div>
               </div>
            </div>
            <div class="col-md-3">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_fecha" class="input-group-addon">Fecha</span>
                     <input type="text" class="form-control" aria-describedby="addon_fecha" readonly value="<?php echo $comprobante->fecha;?>">
                  </div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_fPago" class="input-group-addon">Forma Pago</span>
                     <input type="text" class="form-control" aria-describedby="addon_fPago" readonly value="<?php echo $comprobante->forma_pago;?>">
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-3">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_mPago" class="input-group-addon">Metodo Pago</span>
                     <input type="text" class="form-control" aria-describedby="addon_mPago" readonly value="<?php echo $comprobante->metodo_pago;?>">
                  </div>
               </div>
            </div>
            <div class="col-md-2">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_ctaB" class="input-group-addon">Uso CFDI.</span>
                     <input type="text" class="form-control" aria-describedby="addon_ctaB" readonly value="<?php echo $comprobante->usoCfdi;?>">
                  </div>
               </div>
            </div>
            <div class="col-md-3">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_estado_sat" class="input-group-addon">Estado</span>
                     <input class="form-control" id="EstadoSat" type="text" aria-describedby="addon_estado_sat" readonly value="<?php echo $comprobante->estado_sat;?>">
                     <span class="input-group-btn">
                        <button class="btn btn-default" type="button" onclick="valida_uuid()"><i class="fa fa-check-square"></i> Valida</button>
                     </span>
                  </div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_codigoSat" class="input-group-addon">Codigo SAT</span>
                     <input id="CodigoSat" type="text" class="form-control" aria-describedby="addon_codigoSat" readonly value="<?php echo $comprobante->codigo_sat;?>">
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-3">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_moneda" class="input-group-addon">Moneda</span>
                     <input type="text" class="form-control" aria-describedby="addon_moneda" readonly value="<?php echo $comprobante->moneda;?>">
                  </div>
               </div>
            </div>
            <div class="col-md-3">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_tipoCambio" class="input-group-addon">Tipo Cambio</span>
                     <input type="text" class="form-control text-right" aria-describedby="addon_tipoCambio" readonly value="<?php echo number_format($comprobante->tipo_cambio,4);?>">
                  </div>
               </div>
            </div>
         </div>
         <hr>
         <div class="row">
            <div class="col-md-3">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_rfcEmi" class="input-group-addon">RFC</span>
                     <input type="text" class="form-control" aria-describedby="addon_rfcEmi" readonly value="<?php echo $comprobante->rfc_emisor;?>">
                  </div>
               </div>
            </div>
            <div class="col-md-9">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_nombre" class="input-group-addon">Nombre</span>
                     <input type="text" class="form-control" aria-describedby="addon_nombre" readonly value="<?php echo $comprobante->nombre_emisor;?>">
                  </div>
               </div>
            </div>
         </div>
         <hr>
         <div class="row">
            <div class="col-md-3">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_rfcRe" class="input-group-addon">Receptor</span>
                     <input type="text" class="form-control" aria-describedby="addon_rfcRe" readonly value="<?php echo $comprobante->rfc_receptor;?>">
                  </div>
               </div>
            </div>
            <div class="col-md-3 pull-right">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_subtotal" class="input-group-addon">Subtotal</span>
                     <input type="text" class="form-control text-right" aria-describedby="addon_subtotal" readonly value="<?php  echo number_format($comprobante->subtotal,2);?>">
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-3 pull-right">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_iva" class="input-group-addon">I.V.A.</span>
                     <input type="text" class="form-control text-right" aria-describedby="addon_iva" readonly value="<?php  echo number_format($comprobante->iva,2);?>">
                  </div>
               </div>
            </div>
            <div class="col-md-2 pull-right">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_tasaiva" class="input-group-addon">Tasa</span>
                     <input type="text" class="form-control text-right" aria-describedby="addon_tasaiva" readonly value="<?php  echo number_format($comprobante->tasa_iva,2);?>">
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-3 pull-right">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_retiva" class="input-group-addon">Ret. IVA</span>
                     <input type="text" class="form-control text-right" aria-describedby="addon_retiva" readonly value="<?php  echo number_format($comprobante->ret_iva,2);?>">
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-3 pull-right">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_retisr" class="input-group-addon">Ret. ISR</span>
                     <input type="text" class="form-control text-right" aria-describedby="addon_retisr" readonly value="<?php  echo number_format($comprobante->ret_isr,2);?>">
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-3 pull-right">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_ieps" class="input-group-addon">IEPS</span>
                     <input type="text" class="form-control text-right" aria-describedby="addon_ieps" readonly value="<?php  echo number_format($comprobante->ieps,2);?>">
                  </div>
               </div>
            </div>
            <div class="col-md-2 pull-right">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_tasaieps" class="input-group-addon">Tasa</span>
                     <input type="text" class="form-control text-right" aria-describedby="addon_tasaieps" readonly value="<?php  echo number_format($comprobante->tasa_ieps,2);?>">
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-3 pull-right">
               <div class="form-group">
                  <div class="input-group">
                     <span id="addon_total" class="input-group-addon">Total</span>
                     <input type="text" class="form-control text-right" aria-describedby="addon_total" readonly value="<?php  echo number_format($comprobante->total,2);?>">
                  </div>
               </div>
            </div>
         </div>
         <hr>
         <div class="row">
         </div>
      </div>
      <div class="panel-footer">
         <a class="btn btn-default" href="<?php echo base_url('comprobantes/pdf/') . $comprobante->uuid;?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Ver PDF</a>
         <a class="btn btn-default" href="<?php echo base_url('comprobantes/xml/') . $comprobante->uuid;?>" target="_blank"><i class="fa fa-file-code-o"></i> Ver XML</a>
         <a href="#" class="btn btn-danger" onclick="cancelar()"><i class="fa fa-trash"></i> Eliminar</a>
         <a href="javascript:history.back()" class="btn btn-primary"><i class="fa fa-list"></i> Listado</a>
      </div>
   </div>
</div>
<script>
   function valida_uuid(){
      $.ajax({
         url : "<?php echo base_url('ValidacionComprobantes/valida/');?>" + $('#uuid').val(),
         type : "GET",
         dataType : 'json',
         success : function (data){
            if(data.status){
               $('#EstadoSat').val(data.estatus);
			   $('#CodigoSat').val(data.codigoEstatus);
               var n = new Noty({text: 'Estado Actualizado Correctamente', theme : 'relax', type : 'info'}).show();
            } else {
               var no = new Noty({text : data.error, theme : 'relax', type : 'error'}).show();
            }
         },
         error : function () {
            var n = new Noty({
               text : 'Error en la Validacion',
               theme : 'relax',
               type : 'error'
            }).show();
         }
      });
   }

  function cancelar(){
    swal({
      title: 'Eliminar?',
      text: 'No se podra revertir el proceso de eliminacion',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Eliminar',
      cancelButtonText: 'Cancelar'
    }).then(function (){
      var uuid = $('#uuid').val();
      $.ajax({
        url: "<?php echo base_url('comprobantes/delete')?>",
        type: 'POST',
        dataType: 'json',
        data: {'uuid': uuid},
        success : function (response) {
          if(response.success){
            window.history.back();
          } else {
            swal('Error al eliminar',
              response.error,
              'error'
            );
          }
        },
        error: function (){
          swal('Error de comunicacion',
                'No se puede establecer conexion para eliminar el comprobante',
                'error'
          );
        }
      });
    }
    );
   }
</script>
<?php $this->load->view('templates/footer'); ?>
