<?php
      class Migration_Crea_tabla_comprobantes extends CI_Migration{
        public function up()
        {
           $this->dbforge->add_field([
           'empresa' => ['type' => 'char', 'constraint' => 13],
           'uuid' => ['type' => 'char', 'constraint' => 36],
           'version' => ['type' => 'char', 'constraint' => 4],
           'tipo_comprobante' => ['type' => 'varchar', 'constraint' => 20],
           'folio' => ['type' => 'varchar', 'constraint' => 20],
           'serie' => ['type' => 'varchar', 'constraint' => 20],
           'fecha' => ['type' => 'datetime'],
           'no_certificado' => ['type' => 'varchar', 'constraint' => 20],
           'forma_pago' => ['type' => 'varchar', 'constraint' => 40],
           'metodo_pago' => ['type' => 'varchar', 'constraint' => 40],
           'usoCfdi' => ['type' => 'char', 'constraint' => 5],
           'tipo_cambio' => ['type' => 'decimal', 'constraint' => '13,6'],
           'moneda' => ['type' => 'varchar', 'constraint' => 10],
           'subtotal' => ['type' => 'decimal', 'constraint' => '13,6'],
           'iva' => ['type' => 'decimal', 'constraint' => '13,6'],
           'tasa_iva' => ['type' => 'decimal', 'constraint' => '13,6'],
           'ret_iva' => ['type' => 'decimal', 'constraint' => '13,6'],
           'ret_isr' => ['type' => 'decimal', 'constraint' => '13,6'],
           'ieps' => ['type' => 'decimal', 'constraint' => '13,6'],
           'tasa_ieps' => ['type' => 'decimal', 'constraint' => '13,6'],
           'total' => ['type' => 'decimal', 'constraint' => '13,6'],
           'rfc_emisor' => ['type' => 'char', 'constraint' => 13],
           'rfc_receptor' => ['type' => 'char', 'constraint' => 13],
           'fecha_timbrado' => ['type' => 'datetime'],
           'no_certificado_sat' => ['type' => 'varchar', 'constraint' => 20],
           'fecha_ingreso' => ['type' => 'timestamp'],
           'fecha_programada' => ['type' => 'date', 'null' => TRUE, 'default' => NULL],
           'poliza_contabilidad' => ['type' => 'varchar', 'constraint' => 40, 'null' => TRUE, 'default' => NULL],
           'fecha_contabilidad' => ['type' => 'datetime', 'null' => TRUE, 'default' => NULL],
           'poliza_pago' => ['type' => 'varchar', 'constraint' => 40, 'null' => TRUE, 'default' => NULL],
           'fecha_pago' => ['type' => 'datetime', 'null' => TRUE, 'default' => NULL],
           'descripcion' => ['type' => 'text', 'null' => TRUE, 'default' => NULL],
           'valida' => ['type' => 'tinyint', 'constraint' => 1, 'default' => 0],
           'registrada' => ['type' => 'tinyint', 'constraint' => 1, 'default' => 0],
           'tipo_factura' => ['type' => 'char', 'constraint' => 1, 'null' => TRUE, 'default' => NULL],
           'error' => ['type' => 'text', 'null' => TRUE, 'default' => NULL]
           ]);
          $this->dbforge->add_key('uuid', TRUE);
          $this->dbforge->add_key('empresa');
          $this->dbforge->add_key(array('empresa', 'poliza_contabilidad'));
          $this->dbforge->add_key(array('empresa', 'poliza_pago'));
          $this->dbforge->create_table('comprobantes', TRUE);
        }

        public function down()
        {
          $this->dbforge->drop_table('comprobantes', TRUE);
        }
      }
