<?php

namespace App\Models;

use CodeIgniter\Model;

class AnimeModel extends Model
{
    protected $table            = 'anime';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;

    protected $allowedFields = [
        'title',
        'synopsis',
        'poster',
        'status',
        'release_year',
        'rating',
    ];

    public function getGenres($animeId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('anime_genres');
        $builder->select('genres.id, genres.name');
        $builder->join('genres', 'genres.id = anime_genres.genre_id');
        $builder->where('anime_genres.anime_id', $animeId);

        return $builder->get()->getResultArray();
    }
}
