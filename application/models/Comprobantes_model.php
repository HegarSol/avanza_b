<?php
   defined('BASEPATH') or exit('No direct script access allowed');

   class Comprobantes_model extends CI_Model
   {
		 /**
			* ADD COMPROBANTE
		  */
	  public function add_comprobante($data)
	  {
		 $this->db->trans_start();
		 $this->db->insert('comprobantes', $data);
		 $this->db->trans_complete();
		 return $this->db->trans_status(); 
	  }

	  public function crearuuid()
	  {
		$this->db->select('UUID() as uuid');
		   return $this->db->get()->result();
	  }
	  public function existecomprobante($foli,$seri,$emisor)
	  {
		$this->db->select('*');
		$this->db->from('comprobantes');
		$this->db->where('folio',$foli);
		$this->db->where('serie',$seri);
		$this->db->where('rfc_emisor',$emisor);
		return $this->db->get()->result();
	  }
	  public function obtenertable($usu,$pass,$rfc)
	  {
		   $this->db->select('uuid,fecha,folio,total');
		   $this->db->from('comprobantes');
		   $this->db->where('rfc_receptor',$rfc);
		   $this->db->where('rfc_emisor',$usu);
		   return $this->db->get()->result();
	  }
	  public function get_by_uuid($uuid)
	  {
		 return $this->db->where('uuid', $uuid)->from('comprobantes')->get()->row();
	  }
	  public function get_by_fecha($ini,$fin)
	  {
		 $this->db->select('*');
		 $this->db->from('comprobantes');
		 $this->db->where('fecha >=', $ini . ' 00:00:00');
		 $this->db->where('fecha <=', $fin . ' 23:59:59');
		 $this->db->where('empresa', $this->session->userdata('rfc_empresa'));
		 return $this->db->get()->result();
	  }

	  public function get_faltantes_by_empresa($empresa, $pendiente = 0)
	  {
		 if($pendiente == 0)
		 {
			$query = $this->db->where('empresa', $empresa)
			->where_in('status', array('P','C'))
			->from('comprobantes')
			->get();
		 }
		 else
		 {
			$query = $this->db->where('empresa', $empresa)
			->where('status', 'P')
			->from('comprobantes')
			->get();
		 }

		return $query->result();
	  }

	  public function get_facturas_by_referencia($empresa, $referencia)
	  {
		 $this->db->select('folio,serie,fecha,total,nombre_emisor,fecha_pago,poliza_pago');
		 $this->db->from('comprobantes');
		 $this->db->where('empresa', $empresa);
		 $this->db->where('referencia', $referencia);
		 return $this->db->get()->result();
	  }

	  public function getByPoliza($empresa, $poliza)
	  {
		 return $this->db->where('empresa', $empresa)
		 ->where('poliza_pago', $poliza)
		 ->from('comprobantes')
		 ->get()
		 ->result();
	  }

	  public function getxmlproveedor($rfcprove,$rfcempresa)
	  {
		return $this->db->where('empresa', $rfcempresa)
		->where('rfc_emisor', $rfcprove)
		->from('comprobantes')
		->get()
		->result();
	  }

	  public function updateAutorizar($empresa,$uuid,$id_usu)
	  {
		$data = array(
			'autorizacion' => 1,
			'id_usu_auto' => $id_usu
		);
			$this->db->where('empresa', $empresa)
			->where('uuid', $uuid)
			->update('comprobantes', $data);
			return $this->db->affected_rows();
	  }
	  public function reporteAutorizar($empresa,$autorizan)
	  {
		
			$this->db->select(array(
				'folio',
				'serie',
				'fecha',
				'descripcion',
				'total',
				'uuid',
				'fecha_pago',
				'metodo_pago',
				'poliza_pago',
				'rfc_emisor',
				'nombre_emisor',
				'path'
			));
	
		$this->db->from('comprobantes');
	    $this->db->where('empresa', $empresa);
		$this->db->where('autorizacion !=', $autorizan);
		$this->db->where('status','A');
		$this->db->group_start();
			$this->db->where('tipo_comprobante','I');
			$this->db->or_where('tipo_comprobante','E');
		$this->db->group_end();
		return $this->db->get()->result();
	  }
	  public function getPendientesByProveedor($empresa, $proveedor, $poliza = '', $formaDePago = NULL, $historico = FALSE, $autorizado = 0)
	  {
		 $this->db->select('*,comprobantes.uuid')
		 ->from('comprobantes')
		 ->group_start()
		 	->where('empresa', $empresa);
		 	if($historico){
				$this->db->where('poliza_pago IS NOT NULL', NULL, FALSE);
		 	} else {
				$this->db->where('poliza_pago', $poliza);
			}
		 $this->db->group_end();
		 
		 if(!$historico){
			$this->db->or_group_start()
			 	->where('empresa', $empresa)
				->where('poliza_pago IS NULL',NULL,FALSE)
			->group_end();
		 }
		 if($proveedor != 'TODOS'){
			$this->db->where('rfc_emisor', $proveedor);
		 }
		 if(!is_null($formaDePago)){
			$this->db->where("IF(version = '3.2',metodo_pago, forma_pago) LIKE '%$formaDePago%'",NULL,FALSE);
		 }

		 if($autorizado == 1)
		 {
			$this->db->where('autorizacion',$autorizado);
		 }
		
		 $this->db->where('status', 'A');
		 $this->db->where('tipo_comprobante != ', 'P');
		 $datos = $this->db->get()->result();
		 $pende = [];
		 foreach($datos as $dato)
		 {
  			$impues = $this->db->select('ToR,impuesto,tipofactor,tasaocuota,importe')
				->from('compro_impuestos')
				->where('uuid',$dato->uuid)
				->get()
				->result(); 
 
				$pende[] = [ 'uuid' => $dato->uuid ,
										 'version' => $dato->version, 
										 'tipo_comprobante' => $dato->tipo_comprobante,
										 'folio' => $dato->folio,
										 'serie' => $dato->serie,
										 'fecha' => $dato->fecha,
										 'no_certificado' => $dato->no_certificado,
										 'forma_pago' => $dato->forma_pago,
										 'metodo_pago' => $dato->metodo_pago,
										 'usoCfdi' => $dato->usoCfdi,
										 'tipo_cambio' => $dato->tipo_cambio,
										 'moneda' => $dato->moneda,
										 'subtotal' => $dato->subtotal,
										 'iva' => $dato->iva,
										 'tasa_iva' => $dato->tasa_iva,
										 'ret_iva' => $dato->ret_iva,
										 'ret_isr' => $dato->ret_isr,
										 'ieps' => $dato->ieps,
										 'tasa_ieps' => $dato->tasa_ieps,
										 'total' => $dato->total,
										 'rfc_emisor' => $dato->rfc_emisor,
										 'rfc_receptor' => $dato->rfc_receptor,
										 'fecha_timbrado' => $dato->fecha_timbrado,
										 'no_certificado_sat' => $dato->no_certificado_sat,
										 'fecha_ingreso' => $dato->fecha_ingreso,
										 'fecha_programada' => $dato->fecha_programada,
										 'poliza_contabilidad' => $dato->poliza_contabilidad,
										 'fecha_contabilidad' => $dato->fecha_contabilidad,
										 'poliza_pago' => $dato->poliza_pago,
										 'fecha_pago' => $dato->fecha_pago,
										 'descripcion' => $dato->descripcion,
										 'valida' => $dato->valida,
										 'estado_sat' => $dato->estado_sat,
										 'codigo_sat' => $dato->codigo_sat,
										 'tipo_factura' => $dato->tipo_factura,
										 'error' => $dato->error,
										 'status' => $dato->status,
										 'path' => $dato->path,
										 'nombre_emisor' => $dato->nombre_emisor,
										 'descuento' => $dato->descuento,
										 'reg_emisor' => $dato->reg_emisor,
										 'referencia' => $dato->referencia,
                     'fecha_validacion' => $dato->fecha_validacion,
										 'tasas' => $impues
										];
			
		 }

		return $pende;

	  }

	  public function getPendientesByProveedorPrueba($empresa, $proveedor, $poliza = '', $formaDePago = NULL, $historico = FALSE)
	  {
		$this->db->select('*,comprobantes.uuid')
		->from('comprobantes')
		->group_start()
			->where('empresa', $empresa);
			if($historico){
			   $this->db->where('poliza_pago IS NOT NULL', NULL, FALSE);
			} else {
			   $this->db->where('poliza_pago', $poliza);
		   }
		$this->db->group_end();
		
		if(!$historico){
		   $this->db->or_group_start()
				->where('empresa', $empresa)
			   ->where('poliza_pago IS NULL',NULL,FALSE)
		   ->group_end();
		}
		if($proveedor != 'TODOS'){
		   $this->db->where('rfc_emisor', $proveedor);
		}
		if(!is_null($formaDePago)){
		   $this->db->where("IF(version = '3.2',metodo_pago, forma_pago) LIKE '%$formaDePago%'",NULL,FALSE);
		}

		$this->db->where('status', 'A');
		$this->db->where('tipo_comprobante != ', 'P');
		$datos = $this->db->get()->result();
    $pende = [];
		 foreach($datos as $dato)
		 {
  			$impues = $this->db->select('ToR,impuesto,tipofactor,tasaocuota,importe')
				->from('compro_impuestos')
				->where('uuid',$dato->uuid)
				->get()
				->result(); 
 
				$pende[] = [ 'uuid' => $dato->uuid ,
										 'version' => $dato->version, 
										 'tipo_comprobante' => $dato->tipo_comprobante,
										 'folio' => $dato->folio,
										 'serie' => $dato->serie,
										 'fecha' => $dato->fecha,
										 'no_certificado' => $dato->no_certificado,
										 'forma_pago' => $dato->forma_pago,
										 'metodo_pago' => $dato->metodo_pago,
										 'usoCfdi' => $dato->usoCfdi,
										 'tipo_cambio' => $dato->tipo_cambio,
										 'moneda' => $dato->moneda,
										 'subtotal' => $dato->subtotal,
										 'iva' => $dato->iva,
										 'tasa_iva' => $dato->tasa_iva,
										 'ret_iva' => $dato->ret_iva,
										 'ret_isr' => $dato->ret_isr,
										 'ieps' => $dato->ieps,
										 'tasa_ieps' => $dato->tasa_ieps,
										 'total' => $dato->total,
										 'rfc_emisor' => $dato->rfc_emisor,
										 'rfc_receptor' => $dato->rfc_receptor,
										 'fecha_timbrado' => $dato->fecha_timbrado,
										 'no_certificado_sat' => $dato->no_certificado_sat,
										 'fecha_ingreso' => $dato->fecha_ingreso,
										 'fecha_programada' => $dato->fecha_programada,
										 'poliza_contabilidad' => $dato->poliza_contabilidad,
										 'fecha_contabilidad' => $dato->fecha_contabilidad,
										 'poliza_pago' => $dato->poliza_pago,
										 'fecha_pago' => $dato->fecha_pago,
										 'descripcion' => $dato->descripcion,
										 'valida' => $dato->valida,
										 'estado_sat' => $dato->estado_sat,
										 'codigo_sat' => $dato->codigo_sat,
										 'tipo_factura' => $dato->tipo_factura,
										 'error' => $dato->error,
										 'status' => $dato->status,
										 'path' => $dato->path,
										 'nombre_emisor' => $dato->nombre_emisor,
										 'descuento' => $dato->descuento,
										 'reg_emisor' => $dato->reg_emisor,
										 'referencia' => $dato->referencia,
                     'fecha_validacion' => $dato->fecha_validacion,
										 'tasas' => $impues
										];
			
		 }

		return $pende;

	  }

	  public function update_comprobante($uuid, $data){
		 $this->db->where('uuid', $uuid)
		 ->update('comprobantes', $data);
		 return $this->db->affected_rows();
	  }

	  public function get_total_comprobantes($empresa)
	  {
		 $query = $this->db->select(array('COUNT(uuid) as total'))
		 ->where('empresa', $empresa)
		 ->from('comprobantes')
		 ->get();
		 if($query->num_rows() > 0)
		 {
			return $query->row()->total;
		 }
		 return 0;
	  }

	  public function get_total_comprobantes_periodo($empresa, $month, $year){
		 $query = $this->db->select(array('COUNT(uuid) as total'))
		 ->where('empresa', $empresa)
		 ->where('MONTH(fecha_ingreso)', $month, FALSE)
		 ->where('YEAR(fecha_ingreso)', $year, FALSE)
		 ->from('comprobantes')
		 ->get();
		 if($query->num_rows() > 0){
			return $query->row()->total;
		 }
		 return 0;
	  }

	  public function get_total_pendientes_validar_sat($empresa)
	  {
		 $query = $this->db->select('COUNT(uuid) as total')
		 ->where('empresa', $empresa)
		 ->where('estado_sat', NULL)
		 ->from('comprobantes')
		 ->get();
		 if($query->num_rows() > 0)
		 {
			return $query->row()->total;
		 }
		 return 0;
	  }

	  public function get_pendientes_validar_sat($empresa)
	  {
		 return $this->db->where('empresa', $empresa)
		 ->where('estado_sat', NULL)
		 ->from('comprobantes')
		 ->get()
		 ->result();
	  }

	  public function get_count_by_status($empresa, $status)
	  {
		 $this->db->select('COUNT(uuid) as total')
		 ->where('empresa', $empresa)
		 ->where('status', $status);
		 if($status = 'R'){
			$this->db->group_start()
			->where('estado_sat !=', 'Cancelado')
			->or_where('estado_sat', NULL)
			->group_end();
		 }
		 $query = $this->db->from('comprobantes')
		 ->get();
		 if($query->num_rows() > 0)
		 {
			return $query->row()->total;
		 }
		 return 0;
	  }

	  public function getSumatoriaFactura($mes, $anio){
		 return $this->db->select('empresa, COUNT(uuid) as cantidad, empresas.nombre')
		 ->from('comprobantes')
		 ->join('empresas', 'empresas.rfc = comprobantes.empresa')
		 ->where('MONTH(fecha_ingreso)', $mes, FALSE)
		 ->where('YEAR(fecha_ingreso)', $anio, FALSE)
		 ->group_by('empresa')
		 ->get()->result();
	  }

	  public function getRechazadosSinCancelar($empresa){
		 return $this->db->select(array('version', 'uuid', 'fecha', 'folio', 'serie', 'rfc_emisor', 'nombre_emisor', 'estado_sat'))
		 ->from('comprobantes')
		 ->where('empresa', $empresa)
		 ->where('status', 'R')
		 ->group_start()
		 ->where('estado_sat !=', 'Cancelado')
		 ->or_where('estado_sat', NULL)
		 ->group_end()
		 ->get()
		 ->result_array();
		}
		
		public function delete($uuid){
			$this->db->where('uuid', $uuid)
			->delete('comprobantes');
			return $this->db->affected_rows();
		}

		/**
		 * ------------------------------------------------------------------------
		 * 	REPORTE
		 * ------------------------------------------------------------------------
		 * 
		 * Metodo para regresar los comprobantes que cumplan con los parametros
		 * enviados, para mostar un reporte.
		 * 
		 * @param string $empresa 	RFC empresa solicitante
		 * @param string $status 		PE - Pendiente de Pago, PA - Pagado
		 * @param string $proveedor	RFC emisor
		 * @param date $fecha_inicial Inicio del reporte
		 * @param date $fecha_final Final del reporte
		 * @param bool $acumulado  El reporte es acumulado ?
		 * 
		 * @return array Comprobantes aceptados que cumplan con los parametros
		 */
		public function reporte($empresa, $status,$proveedor, $fecha_inicial, $fecha_final, $acumulado)
		{
			if($acumulado){
				$this->db->select(array(
					'rfc_emisor',
					'SUM(IF(`fecha_pago` IS NULL, total, 0.00)) AS deuda',
					'SUM(IF(`fecha_pago` IS NOT NULL, total, 0.00)) AS pagado',
					'SUM(total) as total'
				))
				->group_by('rfc_emisor');
			} else {
				$this->db->select(array(
					'folio',
					'serie',
					'fecha',
					'descripcion',
					'total',
					'uuid',
					'fecha_pago',
					'metodo_pago',
					'poliza_pago',
					'rfc_emisor',
					'nombre_emisor'
				));
			}
			$this->db->from('comprobantes')
			->where('empresa', $empresa);
			switch($status){
				case 'PE':
					$this->db->where('poliza_pago IS NULL', NULL, FALSE);
					break;
				case 'PA':
					$this->db->where('poliza_pago IS NOT NULL', NULL, FALSE);
					break;
			}
			if($fecha_inicial && $fecha_final){
				$this->db->where('DATE(fecha) >=', $fecha_inicial);
				$this->db->where('DATE(fecha) <=', $fecha_final);
			}
			if($proveedor){
				$this->db->where('rfc_emisor', $proveedor);
			}
			$this->db->where('status','A');
			$this->db->group_start();
				$this->db->where('tipo_comprobante','I');
				$this->db->or_where('tipo_comprobante','E');
			$this->db->group_end();
			return $this->db->get()->result();
		}
		public function reportecomp($empresa,$proveedor,$fechaini,$fechafin)
		{
            $this->db->select(array(
				'comprobantes.folio',
				'comprobantes.serie',
				'fecha',
				'descripcion',
				'total',
				'uuid',
				'fecha_pago',
				'poliza_pago',
				'rfc_emisor',
				'IFNULL(SUM(pagos_dcto_relacionado.imp_pagado),0) as pagado',
				'cdr.uuid_comprobante',
				'IFNULL((SELECT total FROM comprobantes WHERE UUID = cdr.uuid_comprobante AND tipo_comprobante = "E"), 0) AS nc'
			));
			$this->db->from('comprobantes')
			->join('compro_docs_relacionados AS cdr', 'comprobantes.uuid = cdr.uuid_relacionado', 'left')
			->join('pagos_dcto_relacionado', 'comprobantes.uuid = pagos_dcto_relacionado.id_documento', 'left')
			->where('empresa',$empresa)
			->where('fecha_pago >=', $fechaini)
			->where('fecha_pago <=', $fechafin)
			->where('tipo_comprobante','I')
			->where('comprobantes.metodo_pago','PPD');
			if($proveedor) 
			{
				 $this->db->where('rfc_emisor',$proveedor);
			//	 $this->db->order_by('rfc_emisor','fecha');
			}
			$this->db->group_by('comprobantes.uuid');
			$this->db->having('total - nc - pagado > 1',null,FALSE);
			$this->db->order_by('rfc_emisor','fecha');
			return $this->db->get()->result();
		}
		/**
		 * LIBERA COMPROBANTE DE POLIZA
		 * 
		 * Establece la poliza de pago de un comprobante a NULL para que pueda ser
		 * incluida en otra poliza de pago
		 * 
		 * @param string $empresa		RFC de empresa a la que pertenece el comprobante
		 * @param string $poliza    Numero de poliza en la que se encuentra
		 * 
		 * @return int   Numero de registros que fueron actualizados
		 */
		public function libera_comprobante_de_poliza($empresa, $poliza)
		{
			$data = array(
				'poliza_pago' => NULL,
				'fecha_pago' => NULL
			);
			$this->db->where('empresa', $empresa)
			->where('poliza_pago', $poliza)
			->update('comprobantes', $data);
			return $this->db->affected_rows();
		}

		/**
		 * GET BY CONTABILIDAD
		 * 
		 * Regresa los comprobantes que se encuentran dentro de una poliza de 
		 * contabilidad especifica
		 * 
		 * @param string $empresa RFC de la empresa
		 * @param string $poliza Poliza a buscar
		 */
		public function get_by_contabilidad($empresa, $poliza)
		{
			return $this->db->from('comprobantes')
			->where('empresa', $empresa)
			->where('poliza_contabilidad', $poliza)
			->get()
			->result();
    }
    
    /**
     * GET UUID
     * 
     * Devuelve un UUID generado por MySQL para los comprobantes no fiscales
     * 
     * @return string UUID
     */
    public function get_uuid(){
      return $this->db->select(['UUID() as uuid'])
      ->get()
      ->row()
      ->uuid;
    }
    
    /**
     * VALIDA EXISTENCIA NO FISCAL
     * 
     * Verifica que un comprobante no fiscal no se encuentre registrado en la 
     * base de datos, esto solo por el rfc_emisor, serie y folio
     * 
     * @param string rfc_emisor RFC del emisor del comprobante
     * @param string serie    Serie del comprobante
     * @param string folio    Folio del comprobante
     */
    function valida_existencia_no_fiscal($empresa, $rfc_emisor, $serie, $folio) {
      $cant = $this->db->where('rfc_emisor', $rfc_emisor)
      ->where('serie', $serie)
      ->where('folio', $folio)
      ->where('empresa', $empresa)
      ->from('comprobantes')
      ->count_all_results();
      return $cant > 0 ? TRUE : FALSE;
    }


	// OBTENER LAS MIGRACIONES PARA PV MASTER

	function get_migraciones($id)
	{
		$DB2 = $this->load->database('pvmaster', TRUE);

		$DB2->select('*');
		$DB2->from('migracion');
		$DB2->where('id >', $id);
		$query = $DB2->get();
		return $query->result();
	}
   }
