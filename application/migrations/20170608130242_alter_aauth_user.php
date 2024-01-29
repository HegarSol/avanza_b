<?php
      class Migration_alter_aauth_user extends CI_Migration{
        public function up()
        {
           $field = ['pass' => ['name' => 'pass', 'type' => 'varchar', 'constraint' => 100]];
           $this->dbforge->modify_column('aauth_users',$field);
        }

        public function down()
        {
           $field = ['pass' => ['name' => 'pass', 'type' => 'varchar', 'constraint' => 50]];
        }
      }
