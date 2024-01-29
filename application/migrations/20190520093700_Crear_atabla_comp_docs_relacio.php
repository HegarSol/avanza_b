<?php
        class Migration_Crear_atabla_comp_docs_relacio extends CI_Migration
        {
            public function up()
            {
                $fields = array(
                    'serie' => array(
                        'type' => 'char',
                        'constraint' => 5,
                        'null' => FALSE,
                        'default' => ''
                    ),
                    'no_mov' => array(
                        'type' => 'mediumint',
                        'constraint' => 8,
                        'null' => FALSE,
                        'default' => 0
                    ),
                    'uuid' => array(
                        'type' => 'char',
                        'constraint' => 36,
                        'null' => FALSE
                    ),
                    'tipoRelacion' => array(
                        'type' => 'char',
                        'constraint' => 2,
                        'null' =>  FALSE,
                        'default' => ''
                    ),
                    'total' => array(
                        'type' => 'decimal',
                        'constraint' => '12,2',
                        'null' => true
                    ),
                    'fecha' => array(
                        'type' => 'date',
                        'null' => true
                    ),
                    'serieDR' => array(
                        'type' => 'char',
                        'constraint' => 5,
                        'null' => true
                    ),
                    'folioDR' => array(
                        'type' => 'mediumint',
                        'constraint' => 8,
                        'default' => 0,
                        'null' => false
                    )
                );

                $this->dbforge->add_field($fields);
                $this->dbforge->create_table('compro_docs_relacionados', true);
            }

            public function down()
            {
                $this->dbforge->drop_table('compro_docs_relacionados', true);
            }
        }