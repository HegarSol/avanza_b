<?php
      class Migration_Crea_campo_status extends CI_Migration{
        public function up()
        {
           $field = array(
              'status' => array(
                 'type' => 'char',
                 'constraint' => 1,
                 'default' => 'P'
              )
           );
           $this->dbforge->add_column('comprobantes', $field);
           $this->db->query("CREATE INDEX `comprobantes_empresa_status` ON
           `comprobantes` (`empresa`, `status`)");
        }

        public function down()
        {
           $this->db->query("DROP INDEX `comprobantes_empresa_status` ON
           `comprobantes`");
           $this->dbforge->drop_column('comprobantes', 'status');
        }
      }
