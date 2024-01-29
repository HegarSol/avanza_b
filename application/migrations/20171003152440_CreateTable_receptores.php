<?php
        class Migration_CreateTable_receptores extends CI_Migration
        {
            public function up()
            {
                $fields = array(
                    'rfc_empresa' => array(
                        'type' => 'char',
                        'constraint' => 13,
                        'null' => FALSE
                    ),
                    'rfc_receptor' => array(
                        'type' => 'char',
                        'constraint' => 13,
                        'null' => false
                    ),
                    'nombre_receptor' => array(
                        'type' => 'varchar',
                        'constraint' => 250,
                        'null' => true,
                        'default', ''
                    )
                );

                $this->dbforge->add_field($fields);
                $this->dbforge->add_key(array('rfc_empresa','rfc_receptor'), true);
                $this->dbforge->add_key(array('rfc_empresa','nombre_receptor'));
                $this->dbforge->create_table('receptores', true);
            }

            public function down()
            {
                $this->dbforge->drop_table('receptores', true);
            }
        }
