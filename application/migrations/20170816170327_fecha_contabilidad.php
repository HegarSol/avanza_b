<?php
      class Migration_fecha_contabilidad extends CI_Migration{
        public function up()
        {
           $field = array(
              'fecha_contabilidad' => array(
                 'name' => 'fecha_contabilidad',
                 'type' => 'date',
                 'null' => TRUE,
                 'default' => NULL

              )
           );
           $this->dbforge->modify_column('comprobantes', $field);
        }

        public function down()
        {
           $field = array(
              'fecha_contabilidad' => array(
                 'name' => 'fecha_contabilidad',
                 'type' => 'datetime',
                 'null' => TRUE,
                 'default' => NULL
              )
           );
           $this->dbforge->modify_column('comprobantes', $field);
        }
      }
