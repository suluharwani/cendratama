<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Testimonial extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'id' => [
        'type' => 'INT',
        'constraint' => 10,
        'unsigned' => true,
        'auto_increment' => true,
      ],
      'content' => [
        'type' => 'VARCHAR',
        'constraint' => 50000,
        'null' => true,
      ],
      'company' => [
        'type' => 'VARCHAR',
        'constraint' => 200,
        'null' => true,
      ],
      'link' => [
        'type' => 'VARCHAR',
        'constraint' => 300,
        'null' => true,
      ],
      'id_client' => [
        'type' => 'INT',
        'constraint' => 20,
        'null' => true,
      ],
      'id_product' => [
        'type' => 'INT',
        'constraint' => 20,
        'null' => true,
      ],
      'star' => [
        'type' => 'INT',
        'constraint' => 4,
        'null' => true,
      ],
      'status' => [
        'type' => 'TINYINT',
        'constraint' => 1,
        'null' => true,
      ],
      'updated_at' => [
        'type' => 'datetime',
        'null' => true,
      ],
      'deleted_at' => [
        'type' => 'datetime',
        'null' => true,
      ],
      'created_at datetime default current_timestamp',

    ]);
    $this->forge->addPrimaryKey('id');
    $this->forge->createTable('testimonial');
  }

  public function down()
  {
    $this->forge->dropTable('testimonial');
  }
}
