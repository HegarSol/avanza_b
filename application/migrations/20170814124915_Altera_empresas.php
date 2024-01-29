<?php
      class Migration_Altera_empresas extends CI_Migration{
        public function up()
        {
           $fields = array(
              'ftp_host' => ['type' => 'TEXT', 'null' => TRUE, 'default' => NULL],
              'ftp_user' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => TRUE, 'default' => NULL],
              'ftp_pass' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => TRUE, 'default' => NULL],
              'ftp_port' => ['type' => 'INT', 'null' => FALSE, 'default' => 21],
              'ftp_path' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => TRUE, 'default' => NULL],
           );

           $this->dbforge->add_column('empresas', $fields);
        }

        public function down()
        {
           $this->dbforge->drop_column('empresas', 'ftp_host');
           $this->dbforge->drop_column('empresas', 'ftp_user');
           $this->dbforge->drop_column('empresas', 'ftp_pass');
           $this->dbforge->drop_column('empresas', 'ftp_port');
           $this->dbforge->drop_column('empresas', 'ftp_path');
        }
      }
