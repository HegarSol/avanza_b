<?php
      class Migration_actualiza_empresas extends CI_Migration{
        public function up()
        {
           $fields = array(
               'port_pop' => ['type' => 'int', 'default' => 110],
               'ssl_pop' => ['type' => 'tinyint', 'constraint' => 1, 'default' => 0],
               'host_smtp' => ['type' => 'text', 'default' => ''],
               'user_smtp' => ['type' => 'varchar', 'constraint' => 100, 'default' => ''],
               'pass_smtp' => ['type' => 'varchar', 'constraint' => 100, 'default' => ''],
               'port_smtp' => ['type' => 'int', 'default' => 25],
               'ssl_smtp' => ['type' => 'tinyint', 'constraint' => 1, 'default' => 0]
            );
            $this->dbforge->add_column('empresas', $fields);
        }

        public function down() 
        {
           $this->dbforge->drop_column('empresas','port_pop');
           $this->dbforge->drop_column('empresas','ssl_pop');
           $this->dbforge->drop_column('empresas','host_smtp');
           $this->dbforge->drop_column('empresas','user_smtp');
           $this->dbforge->drop_column('empresas','pass_smtp');
           $this->dbforge->drop_column('empresas','port_smtp');
           $this->dbforge->drop_column('empresas','ssl_smtp');
        }
      }
