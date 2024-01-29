<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Agregar_campo_activo extends CI_Migration {

	public function __construct()
	{
		$this->load->dbforge();
		$this->load->database();
	}

	public function up() {
		$field = array(
			'activaMasiva' => array(
				'type' => 'int',
				'constraint' => '10',
				'null' => true
			)
        );
        $field2 = array(
            'fechaMasiva' => array(
                'type' => 'date'
            )
        );

        $this->dbforge->add_column('empresas', $field);
        $this->dbforge->add_column('empresas', $field2);
	}

	public function down() {

	}

}

/* End of file Migration_Agrega_campo_descuento.php */