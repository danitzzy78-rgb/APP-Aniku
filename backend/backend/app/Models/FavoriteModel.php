<?php

namespace App\Models;

use CodeIgniter\Model;

class FavoriteModel extends Model
{
    protected $table            = 'favorites';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;

    protected $allowedFields = [
        'user_id',
        'anime_id',
        'created_at',
    ];

    public function getFavoritesByUser($userId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('favorites');
        $builder->select('anime.*');
        $builder->join('anime', 'anime.id = favorites.anime_id');
        $builder->where('favorites.user_id', $userId);

        return $builder->get()->getResultArray();
    }
}
