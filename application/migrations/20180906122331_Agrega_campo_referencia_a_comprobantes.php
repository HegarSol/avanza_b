<?php
class Migration_Agrega_campo_referencia_a_comprobantes extends CI_Migration{
  public function up()
  {
    $field = array(
      'referencia' => array(
        'type' => 'VARCHAR',
        'constraint' => 20,
        'null' => true,
        'default' => null
      )
    );
    $this->dbforge->add_column('comprobantes', $field);
  }

  public function down()
  {
    $this->dbforge->drop_column('comprobantes', 'referencia');
  }
}