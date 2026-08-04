<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\FavoriteModel;
use CodeIgniter\API\ResponseTrait;

class FavoriteController extends BaseController
{
    use ResponseTrait;

    protected $favoriteModel;

    public function __construct()
    {
        $this->favoriteModel = new FavoriteModel();
    }

    // GET /api/favorites -> lihat daftar favorit user yang login
    public function index()
    {
        $userId = $this->request->user->id;

        $data = $this->favoriteModel->getFavoritesByUser($userId);

        return $this->respond([
            'message' => 'Berhasil mengambil daftar favorit',
            'data'    => $data,
        ]);
    }

    // POST /api/favorites -> tambah anime ke favorit
    public function create()
    {
        $userId  = $this->request->user->id;
        $animeId = $this->request->getVar('anime_id');

        if (empty($animeId)) {
            return $this->fail('anime_id wajib diisi');
        }

        $existing = $this->favoriteModel
            ->where('user_id', $userId)
            ->where('anime_id', $animeId)
            ->first();

        if ($existing) {
            return $this->fail('Anime sudah ada di favorit');
        }

        $this->favoriteModel->insert([
            'user_id'    => $userId,
            'anime_id'   => $animeId,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->respondCreated(['message' => 'Berhasil menambahkan ke favorit']);
    }

    // DELETE /api/favorites/{anime_id} -> hapus dari favorit
    public function delete($animeId = null)
    {
        $userId = $this->request->user->id;

        $existing = $this->favoriteModel
            ->where('user_id', $userId)
            ->where('anime_id', $animeId)
            ->first();

        if (! $existing) {
            return $this->failNotFound('Anime tidak ada di daftar favorit');
        }

        $this->favoriteModel->delete($existing['id']);

        return $this->respondDeleted(['message' => 'Berhasil menghapus dari favorit']);
    }
}
