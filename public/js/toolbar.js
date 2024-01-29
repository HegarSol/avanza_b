function muestraModalCargaComprobantes(url){
   $.ajax({
	  url : url + "comprobantes/load_modal",
	  type : 'GET',
	  dataType : 'html',
	  success : function (data) {
		 $('#espacioReservado').html(data);
		 $('#modalCargaComprobante').modal('show');
	  }
   })
}
