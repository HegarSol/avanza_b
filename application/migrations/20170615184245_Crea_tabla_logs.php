<?php
      class Migration_Crea_tabla_logs extends CI_Migration{
        public function up()
        {
           $this->dbforge->add_field([
           'id' => ['type' => 'int', 'unsigned' => TRUE, 'auto_increment' => TRUE],
           'rfc' => ['type' => 'char', 'constraint' => 13],
           'from' => ['type' => 'varchar', 'constraint' => 100],
           'to' => ['type' => 'varchar', 'constraint' => 100],
           'when' => ['type' => 'datetime'],
           'subject' => ['type' => 'varchar', 'constraint' => 150],
           'log' => ['type' => 'text']
           ]);
          $this->dbforge->add_key('id', TRUE);
          $this->dbforge->create_table('error_log', TRUE);
        }

        public function down()
        {
           $this->dbforge->drop_table('error_log', TRUE);
        }
      }
