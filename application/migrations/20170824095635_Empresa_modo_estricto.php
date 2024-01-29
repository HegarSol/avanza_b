<?php
      class Migration_Empresa_modo_estricto extends CI_Migration{
        public function up()
        {
           $field = array(
              'estricto' => array(
                 'type' => 'tinyint',
                 'constraint' => 1,
                 'default' => 1
              )
           );

           $this->dbforge->add_column('empresas', $field);
        }

        public function down()
        {
           $this->dbforge->drop_column('empresas', 'estricto');
        }
      }
