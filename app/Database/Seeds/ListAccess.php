<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ListAccess extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `list_access` (`id`, `page`) VALUES
      (1,'administrator'),
      (2,'client')
      ");
    }
}
