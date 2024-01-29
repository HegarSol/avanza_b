<?php
      class Migration_claves_correos extends CI_Migration{
        public function up()
        {
           $fields = array(
              'pass_pop' => array(
                 'name' => 'pass_pop',
                 'type' => 'text',
                 'null' => TRUE,
                 'default' => NULL
              ),
              'pass_smtp' => array(
                 'name' => 'pass_smtp',
                 'type' => 'text',
                 'null' => TRUE,
                 'default' => NULL
              ),
              'ftp_pass' => array(
                 'name' => 'ftp_pass',
                 'type' => 'text',
                 'null' => TRUE,
                 'default' => NULL
              )
           );
           $this->dbforge->modify_column('empresas', $fields);
        }

        public function down()
        {
           $fields = array(
              'pass_pop' => array(
                 'name' => 'pass_pop',
                 'type' => 'varchar',
                 'constraint' => 100,
                 'null' => TRUE,
                 'default' => NULL
              ),
              'pass_smtp' => array(
                 'name' => 'pass_smtp',
                 'type' => 'varchar',
                 'constraint' => 100,
                 'null' => TRUE,
                 'default' => NULL
              ),
              'ftp_pass' => array(
                 'name' => 'ftp_pass',
                 'type' => 'varchar',
                 'constraint' => 100,
                 'null' => TRUE,
                 'default' => NULL
              )
           );
           $this->dbforge->modify_column('empresas', $fields);
        }
      }
