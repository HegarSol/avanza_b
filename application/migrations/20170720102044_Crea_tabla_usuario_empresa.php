<?php
      class Migration_Crea_tabla_usuario_empresa extends CI_Migration{
        public function up()
        {
          $this->dbforge->add_field(array(
             'id_usuario' => array(
                'type' => 'INT',
                 'constraint' => 11,
              ),
              'rfc_empresa' => array(
                 'type' => 'char',
                 'constraint' => 15
              )
          ));
          $this->dbforge->add_key(array('id_usuario', 'rfc_empresa'), TRUE);
          $this->dbforge->create_table('usuario_empresa', TRUE);
        }

        public function down()
        {
          $this->dbforge->drop_table('usuario_empresa', TRUE);
        }
      }
