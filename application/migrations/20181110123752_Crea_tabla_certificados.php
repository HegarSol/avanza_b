<?php

class Migration_Crea_tabla_certificados extends CI_Migration{
  public function up()
  {
    $fields = [
      'empresa' => [
        'type' => 'CHAR',
        'constraint' => 13,
        'null' => FALSE
      ],
      'no_certificado' => [
        'type' => 'CHAR',
        'constraint' => 20,
        'null' => FALSE
      ],
      'fecha_inicio' => [
        'type' => 'DATETIME',
        'null' => FALSE
      ],
      'fecha_vence' => [
        'type' => 'DATETIME',
        'null' => FALSE
      ],
      'pfx' => [
        'type' => 'TEXT',
        'null' => FALSE
      ],
      'pass' => [
        'type' => 'TEXT',
        'null' => FALSE
      ]
    ];
    $this->dbforge->add_field($fields);
    $this->dbforge->add_key(['empresa', 'no_certificado'], TRUE);
    $this->dbforge->create_table('certificados', TRUE);
  }

  public function down()
  {
    $this->dbforge->drop_table('certificados', TRUE);
  }
}