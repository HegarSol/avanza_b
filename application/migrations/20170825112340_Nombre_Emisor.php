<?php
      class Migration_Nombre_Emisor extends CI_Migration{
        public function up()
        {
           $field = array(
              'nombre_emisor' => array(
                 'type' => 'varchar',
                 'constraint' => 250
              )
           );

           $this->dbforge->add_column('comprobantes', $field);
        }

        public function down()
        {
           $this->dbforge->drop_column('comprobantes', 'nombre_emisor');
        }
      }
