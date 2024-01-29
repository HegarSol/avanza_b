<?php
      class Migration_Fecha_poliza_pago extends CI_Migration{
        public function up()
        {
           $field = array(
              'fecha_pago' => array(
                 'name' => 'fecha_pago',
                 'type' => 'DATE',
                 'null' => TRUE,
                 'default' => NULL
              )
           );
           $this->dbforge->modify_column('comprobantes', $field);
        }

        public function down()
        {
           $field = array(
              'fecha_pago' => array(
                 'name' => 'fecha_pago',
                 'type' => 'DATETIME',
                 'null' => TRUE,
                 'default' => NULL
              )
           );
           $this->dbforge->modify_column('comprobantes', $field);
        }
      }
