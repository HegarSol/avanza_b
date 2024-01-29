<?php
      class Migration_Cambia_columna_valida_sat extends CI_Migration{
        public function up()
        {
           $field = array(
              'registrada' => array(
                 'name' => 'estado_sat',
                 'type' => 'varchar',
                 'constraint' => 15,
                 'null' => TRUE,
                 'default' => NULL
              )
           );
           $this->dbforge->modify_column('comprobantes', $field);
        }

        public function down()
        {
           $field = array(
              'estado_sat' => array(
                 'name' => 'registrada',
                 'type' => 'tinyint',
                 'constraint' => 1,
                 'default' => '0'
                 )
              );
              $this->dbforge->modify_column('comprobantes', $field);
        }
      }
