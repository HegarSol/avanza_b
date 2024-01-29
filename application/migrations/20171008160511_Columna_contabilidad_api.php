<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Columna_contabilidad_api extends CI_Migration {

	public function __construct()
	{
		$this->load->dbforge();
		$this->load->database();
	}

	public function up() {
		$field = array(
			'contabilidad_api' => array(
				'type' => 'tinyint',
				'constraint' => 1,
				'default' => 1,
				'null' => FALSE
			)
		);		
		$this->dbforge->add_column('empresas', $field);
	}

	public function down() {
		$this->dbforge->drop_column('empresas', 'contabilidad_api');
	}

}

/* End of file Columna_contabilidad_api.php */
