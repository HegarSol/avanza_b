<?php
      class Migration_Correos_alternativos extends CI_Migration{
        public function up()
        {
           $fields = array(
              'id' => array(
                 'type' => 'int',
                 'unsigned' => TRUE,
                 'auto_increment' => TRUE
              ),
              'rfc_empresa' => array(
                 'type' => 'char',
                 'constraint' => 13,
                 'null' => FALSE,
                 'default' => ''
              ),
              'rfc_emisor' => array(
                 'type' => 'char',
                 'constraint' => 13,
                 'null' => FALSE,
                 'default' => ''
              ),
              'email' => array(
                 'type' => 'varchar',
                 'constraint' => 150,
                 'null' => FALSE,
                 'default' => ''
              )
           );

           $this->dbforge->add_field($fields);
           $this->dbforge->add_key('id', TRUE);
           $this->dbforge->add_key(array('rfc_empresa', 'rfc_emisor'));

           $this->dbforge->create_table('correos', TRUE);
        }

        public function down()
        {
           $this->dbforge->drop_table('correos', TRUE);
        }
      }
