<?php
        class Migration_Crear_tabla_comp_impuestos extends CI_Migration
        {
            public function up()
            {
                $fields = array(
                    'uuid' => array(
                        'type' => 'char',
                        'constraint' => 50,
                        'null' => TRUE
                    ),
                    'ToR' => array(
                        'type' => 'char',
                        'constraint' => 30,
                        'null' =>  TRUE
                    ),
                    'impuesto' => array(
                        'type' => 'char',
                        'constraint' => 10,
                        'null' => TRUE
                    ),
                    'tipofactor' => array(
                        'type' => 'char',
                        'constraint' => '10',
                        'null' => TRUE
                    ),
                    'tasaocuota' => array(
                        'type' => 'decimal',
                        'constraint' => '16,6',
                        'null' => TRUE
                    ),
                    'importe' => array(
                        'type' => 'decimal',
                        'constraint' => '12,2',
                        'null' => TRUE
                    )
                );

                $this->dbforge->add_field($fields);
                $this->dbforge->create_table('compro_impuestos', true);
            }

            public function down()
            {
                $this->dbforge->drop_table('compro_impuestos', true);
            }
        }