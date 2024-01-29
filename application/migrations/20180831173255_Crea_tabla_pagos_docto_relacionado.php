<?php
  class Migration_Crea_tabla_pagos_docto_relacionado extends CI_Migration{

    public function __construct()
    {
      $this->load->dbforge();
      $this->load->database();
    }
    public function up()
    {
      $fields = array(
        'id' => array(
          'type' => 'INT',
          'unsigned' => true,
          'auto_increment' => true
        ),
        'pago_id' => array(
          'type' => 'INT',
          'unsigned' => true
        ),
        'id_documento' => array(
          'type' => 'CHAR',
          'constraint' => 36
        ),
        'serie' => array(
          'type' => 'VARCHAR',
          'constraint' => 20
        ),
        'folio' => array(
          'type' => 'VARCHAR',
          'constraint' => 20
        ),
        'moneda' => array(
          'type' => 'CHAR',
          'constraint' => 4
        ),
        'tipo_cambio' => array(
          'type' => 'DECIMAL',
          'constraint' => '13,6'
        ),
        'metodo_pago' => array(
          'type' => 'CHAR',
          'constraint' => 4
        ),
        'num_parcialidad' => array(
          'type' => 'TINYINT'
        ),
        'imp_saldo_anterior' => array(
          'type' => 'DECIMAL',
          'constraint' => '13,2'
        ),
        'imp_pagado' => array(
          'type' => 'DECIMAL',
          'constraint' => '13,2'
        ),
        'imp_saldo_insoluto' => array(
          'type' => 'DECIMAL',
          'constraint' => '13,2'
        )
      );
      $this->dbforge->add_field($fields);
      $this->dbforge->add_key('id', true);
      $this->dbforge->create_table('pagos_dcto_relacionado', true);

    }

    public function down()
    {
      $this->dbforge->drop_table('pagos_dcto_relacionado', true);
    }
  }