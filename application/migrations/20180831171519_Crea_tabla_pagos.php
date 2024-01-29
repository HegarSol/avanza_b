<?php
  class Migration_Crea_tabla_pagos extends CI_Migration{

    public function __construct()
    {
      $this->load->dbforge();
      $this->load->database();
    }
    public function up()
    {
      $fields = array(
        'pago_id' => array(
          'type' => 'INT',
          'unsigned' => true,
          'auto_increment' => true
        ),
        'uuid' => array(
          'type' => 'CHAR',
          'constraint' => '36',
          'unique' => true
        ),
        'fecha_pago' => array(
          'type' => 'DATETIME'
        ),
        'forma_pago' => array(
          'type' => 'CHAR',
          'constraint' => 3
        ),
        'moneda' => array(
          'type' => 'CHAR',
          'constraint' => 4,
          'default' => 'MXN'
        ),
        'tipo_cambio' =>array(
          'type' => 'DECIMAL',
          'contraint' => '13,6'
        ),
        'monto' => array(
          'type' => 'DECIMAL',
          'constraint' => '13,2'
        )
      );
      $this->dbforge->add_field($fields);
      $this->dbforge->add_key('pago_id', true);
      $this->dbforge->create_table('pagos', true);

    }

    public function down()
    {
      $this->dbforge->drop_table('pagos', true);
    }
  }