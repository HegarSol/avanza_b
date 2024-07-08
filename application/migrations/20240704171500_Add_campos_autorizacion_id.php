<?php

class Migration_Add_campos_autorizacion_id extends CI_Migration{
    public function up()
    {
        $field = array(
            'autorizacion' => array(
                'type' => 'char',
                'contrainst' => '2',
                'null' => true
            )
        );
        $field2 = array(
            'id_usu_auto' => array(
                'type' => 'char',
                'contrainst' => '5',
                'null' => true
            )
        );

        $this->dbforge->add_column('comprobantes',$field);
        $this->dbforge->add_column('comprobantes',$field2);
    }
    public function down()
    {

    }
}