<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Agrega_campo_descuento extends CI_Migration {

	public function __construct()
	{
		$this->load->dbforge();
		$this->load->database();
	}

	public function up() {
		$field = array(
			'descuento' => array(
				'type' => 'decimal',
				'constraint' => '13,6',
				'default' => 0.00,
				'null' => FALSE
			)
		);

		$this->dbforge->add_column('comprobantes', $field);
	}

	public function down() {
		$this->dbforge->drop_column('comprobantes', 'descuento');
	}

}

/* End of file Migration_Agrega_campo_descuento.php */
