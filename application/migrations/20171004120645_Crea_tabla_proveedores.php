<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Crea_tabla_proveedores extends CI_Migration {

	public function __construct()
	{
		$this->load->dbforge();
		$this->load->database();
	}

	public function up() {
		$fields = array(
			'rfc_empresa' => array(
				'type' => 'char',
				'constraint' => 13,
				'null' => FALSE
			),
			'rfc_proveedor' => array(
				'type' => 'char',
				'constraint' => 13,
				'null' => FALSE
			),
			'nombre_proveedor' => array(
				'type' => 'varchar',
				'constraint' => 250,
				'null' => TRUE
			)
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key(array('rfc_empresa', 'rfc_proveedor'), TRUE);
		$this->dbforge->add_key('rfc_empresa');
		$this->dbforge->create_table('proveedores', TRUE);
	}

	public function down() {
		$this->dbforge->drop_table('proveedores', TRUE);
	}

}

/* End of file Crea_tabla_proveedores.php */
