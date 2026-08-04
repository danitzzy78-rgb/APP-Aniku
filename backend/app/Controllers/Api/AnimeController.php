<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\AnimeModel;
use CodeIgniter\API\ResponseTrait;


class AnimeController extends BaseController
{
    use ResponseTrait;

    protected $animeModel;

    public function __construct()
    {
        $this->animeModel = new AnimeModel();
    }

    public function index()
    {
        $data = $this->animeModel->findAll();

        return $this->respond([
            'message' => 'Berhasil mengambil daftar anime',
            'data'    => $data,
        ]);
    }


    // publik show
    public function show($id = null)
    {
        $anime = $this->animeModel->find($id);

        if (! $anime) {
            return $this->failNotFound('Anime tidak ditemukan');
        }

        $anime['genres'] = $this->animeModel->getGenres($id);

        return $this->respond([
            'message' => 'Berhasil mengambil detail anime',
            'data'    => $anime,
        ]);
    }


    // Publik serch
    public function search()
    {
        $keyword = $this->request->getVar('q');

        if (empty($keyword)) {
            return $this->fail('Parameter pencarian (q) wajib diisi');
        }

        $data = $this->animeModel->like('title', $keyword)->findAll();

        return $this->respond([
            'message' => 'Hasil pencarian anime',
            'data'    => $data,
        ]);
    }
}