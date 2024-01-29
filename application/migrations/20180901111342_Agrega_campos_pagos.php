<?php
  class Migration_Agrega_campos_pagos extends CI_Migration{
    public function up()
    {
      $fields = array(
        'num_operacion' => array(
          'type' => 'VARCHAR',
          'constraint' => 100,
          'default' => ''
        ),
        'rfc_emisor_cta_ord' => array(
          'type' => 'CHAR',
          'constraint' => 13,
          'null' => true
        ),
        'nom_banco_ord' => array(
          'type' => 'VARCHAR',
          'constraint' => 200,
          'null' => true
        ),
        'cta_ordenante' => array(
          'type' => 'VARCHAR',
          'constraint' => 50,
          'null' => true
        ),
        'rfc_emisor_cta_ben' => array(
          'type' => 'CHAR',
          'constraint' => 13,
          'null' => true
        ),
        'cta_beneficiario' => array(
          'type' => 'VARCHAR',
          'constraint' => 50,
          'null' => true
        ),
        'tipo_cad_pago' => array(
          'type' => 'CHAR',
          'constraint' => 3,
          'null' => true
        ),
        'cert_pago' => array(
          'type' => 'TEXT',
          'null' => true
        ),
        'cad_pago' => array(
          'type' => 'TEXT',
          'null' => true
        ),
        'sello_pago' => array(
          'type' => 'TEXT',
          'null' => true
        )
      );
      $this->dbforge->add_column('pagos', $fields);
    }

    public function down()
    {
      $this->dbforge->drop_column('pagos', 'num_operacion');
      $this->dbforge->drop_column('pagos', 'rfc_emisor_cta_ord');
      $this->dbforge->drop_column('pagos', 'nom_banco_ord');
      $this->dbforge->drop_column('pagos', 'cta_ordenante');
      $this->dbforge->drop_column('pagos', 'rfc_emisor_cta_ben');
      $this->dbforge->drop_column('pagos', 'cta_beneficiario');
      $this->dbforge->drop_column('pagos', 'tipo_cad_pago');
      $this->dbforge->drop_column('pagos', 'cert_pago');
      $this->dbforge->drop_column('pagos', 'cad_pago');
      $this->dbforge->drop_column('pagos', 'sello_pago');
    }
  }