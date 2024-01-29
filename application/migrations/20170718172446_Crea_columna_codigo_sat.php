<?php
      class Migration_Crea_columna_codigo_sat extends CI_Migration{
        public function up()
        {
           $field = array(
              'codigo_sat' => array(
                 'type' => 'varchar',
                 'constraint' => 60,
                 'null' => TRUE,
                 'default' => NULL,
                 'after' => 'estado_sat'
              )
           );
           $this->dbforge->add_column('comprobantes', $field);
        }

        public function down()
        {
          $this->dbforge->drop_column('comprobantes', 'codigo_sat');
        }
      }
