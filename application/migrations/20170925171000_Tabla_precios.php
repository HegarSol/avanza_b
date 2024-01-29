<?php
   class Migration_Tabla_precios extends CI_Migration{
	  public function up()
	  {
		 $fields = array(
			'id' => array(
			   'type' => 'int',
			   'unsigned' => TRUE,
			   'auto_increment' => TRUE
			),
			'inicial' => array(
			   'type' => 'int',
			   'unsigned' => TRUE
			),
			'final' => array(
			   'type' => 'int',
			   'unsigned' => TRUE
			),
			'precio' => array(
			   'type' => 'decimal',
			   'constraint' => '3,2',
			   'unsigned' => TRUE
			)
		 );

		 $this->dbforge->add_field($fields);
		 $this->dbforge->add_key('id', TRUE);
		 $this->dbforge->create_table('precios', TRUE);

		 $datos = array(
			array(
			   'inicial' => 1,
			   'final' => 100,
			   'precio' => 0.30
			),
			array(
			   'inicial' => 101,
			   'final' => 300,
			   'precio' => 0.25
			),
			array(
			   'inicial' => 301,
			   'final' => 500,
			   'precio' => 0.20
			),
			array(
			   'inicial' => 501,
			   'final' => 1000,
			   'precio' => 0.15
			),
			array(
			   'inicial' => 1001,
			   'final' => 999999999,
			   'precio' => 0.10
			)
		 );
		 $this->db->insert_batch('precios', $datos);
	  }

	  public function down()
	  {
		 $this->dbforge->drop_table('precios', TRUE);
	  }
   }
