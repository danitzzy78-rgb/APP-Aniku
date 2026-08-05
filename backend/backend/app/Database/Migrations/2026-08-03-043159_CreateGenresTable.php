<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGenresTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'unique'     => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('genres');
    }

    public function down()
    {
        $this->forge->dropTable('genres');
    }
}