<?php
      class Migration_Quita_campo_from_error_log extends CI_Migration{
        public function up()
        {
           $this->dbforge->drop_column('error_log', 'to');
        }

        public function down()
        {
           $field = ['to' => ['type' => 'varchar', 'constraint' => 100]];
           $this->dbforge->add_column('error_log', $field);
        }
      }
