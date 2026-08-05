<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnimeGenresTable extends Migration
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
            'anime_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'genre_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('anime_id', 'anime', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('genre_id', 'genres', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('anime_genres');
    }

    public function down()
    {
        $this->forge->dropTable('anime_genres');
    }
}