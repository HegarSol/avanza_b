<?php
      class Migration_empresas extends CI_Migration{
        public function up()
        {
          $this->dbforge->add_field(array(
            'rfc' => ['type' => 'char', 'constraint' => 15],
            'activo' => ['type' => 'tinyint', 'constraint' => 1, 'default' => 1],
            'nombre' => ['type' => 'text'],
            'host_pop' => ['type' => 'text'],
            'user_pop' => ['type' => 'varchar', 'constraint' => 100],
            'pass_pop' => ['type' => 'varchar', 'constraint' => 100]
          ));
          $this->dbforge->add_key('rfc', TRUE);
          $this->dbforge->create_table('empresas', TRUE);
        }

        public function down()
        {
          $this->dbforge->drop_table('empresas', TRUE);
        }
      }
