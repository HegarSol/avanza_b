<?php
class Migration_Crea_campo_departamento_en_comprobantes extends CI_Migration{
  public function up()
  {
    $field = array(
      'departamento' => array(
        'type' => 'CHAR',
        'constraint' => 3,
        'null' => FALSE,
        'default' => ''
      )
    );
    $this->dbforge->add_column('comprobantes', $field);
  }

  public function down()
  {
    $this->dbforge->drop_column('comprobantes', 'departamento');
  }
}