<?php
      class Migration_path_ftp extends CI_Migration{
        public function up()
        {
           $field = array(
              'path' => array(
                 'type' => 'TEXT'
              )
           );

           $this->dbforge->add_column('comprobantes', $field);
        }

        public function down()
        {
           $this->dbforge->drop_column('comprobantes', 'path');
        }
      }
