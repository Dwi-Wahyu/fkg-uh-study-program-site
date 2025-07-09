<?php

namespace App\Controllers;

use App\Models\KetuaProgramStudiModel;
use App\Models\VisiMisiTujuanModel;
use App\Models\SejarahModel;
use App\Models\BeritaModel;

class Home extends BaseController
{
    protected $ketuaProdiModel;
    protected $visiMisiTujuanModel;
    protected $sejarahModel;
    protected $beritaModel;

    public function __construct()
    {
        $this->ketuaProdiModel = new KetuaProgramStudiModel();
        $this->visiMisiTujuanModel = new VisiMisiTujuanModel();
        $this->sejarahModel = new SejarahModel();
        $this->beritaModel = new BeritaModel();

        helper('text');
    }

    public function index(): string
    {
        $ketuaProdi = $this->ketuaProdiModel->first();
        $visiMisiTujuan = $this->visiMisiTujuanModel->first();
        $sejarah = $this->sejarahModel->first();

        $beritaTerbaru = $this->beritaModel->orderBy('created_at', 'DESC')->findAll(4);

        $data = [
            'ketuaProdi'     => $ketuaProdi,
            'visiMisiTujuan' => $visiMisiTujuan,
            'sejarah'        => $sejarah,
            'beritaTerbaru'  => $beritaTerbaru,
        ];

        return view('landing-page', $data);
    }

    public function sejarah()
    {
        $sejarah = $this->sejarahModel->first();

        $data = [
            'sejarah'        => $sejarah,
        ];

        return view('sejarah', $data);
    }
}
