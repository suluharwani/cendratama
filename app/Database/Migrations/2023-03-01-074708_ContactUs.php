<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ContactUs extends Migration
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

      'nama_contact' => [
        'type' => 'VARCHAR',
        'constraint' => 200,
        'null' => true,
      ],
      'logo' => [
        'type' => 'VARCHAR',
        'constraint' => 250,
        'null' => true,
      ],
      'contact' => [
        'type' => 'VARCHAR',
        'constraint' => 200,
        'null' => true,
      ],
      'link' => [
        'type' => 'VARCHAR',
        'constraint' => 200,
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
    $this->forge->createTable('contact_us');
  }

  public function down()
  {
    $this->forge->dropTable('contact_us');
  }
}