<?php
      class Migration_aauth extends CI_Migration{
        public function up()
        {
           $templine = '';
           $lines = file(APPPATH . 'migrations/Aauth_v2.sql');
           foreach($lines as $line)
           {
              if(substr($line, 0, 2) == '--' || $line == '')
              {
                 continue;
              }
              $templine .= $line;
              if(substr(trim($line), -1 , 1) == ';')
              {
                 $this->db->query($templine);
                 $templine = '';
              }
           }
        }

        public function down()
        {
          $this->dbforge->drop_table('aauth_groups', TRUE);
          $this->dbforge->drop_table('aauth_perms', TRUE);
          $this->dbforge->drop_table('aauth_perm_to_group', TRUE);
          $this->dbforge->drop_table('aauth_per_to_user', TRUE);
          $this->dbforge->drop_table('aauth_pms', TRUE);
          $this->dbforge->drop_table('aauth_system_variables', TRUE);
          $this->dbforge->drop_table('aauth_users', TRUE);
          $this->dbforge->drop_table('aauth_user_to_group', TRUE);
          $this->dbforge->drop_table('aauth_user_variables', TRUE);
        }
      }
