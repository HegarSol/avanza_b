<?php

class Migration_add_no_contra_fecha extends CI_Migration{
    public function up()
    {
        $field = array(
            'no_contrare' => array(
                'type' => 'int',
                'contrainst' => '20',
                'null' => true
            )
        );
        $field2 = array(
            'fecha_contra' => array(
                'type' => 'datetime',
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