<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_campo_fecha_validacion extends CI_Migration {

	public function __construct()
	{
		$this->load->dbforge();
		$this->load->database();
	}

	public function up() {
		$field = array(
			'fecha_validacion' => array(
				'type' => 'DATETIME',
				'null' => true
			)
        );
        $this->dbforge->add_column('comprobantes', $field);
	}

	public function down() {

	}

}

/* End of file Migration_Agrega_campo_descuento.php */