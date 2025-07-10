<?php

namespace App\Controllers;

use App\Models\KetuaProgramStudiModel;
use App\Models\VisiMisiTujuanModel;
use App\Models\SejarahModel;
use App\Models\BeritaModel;
use App\Models\ProfilLulusanModel;
use App\Models\SaranaPrasaranaModel;
use App\Models\KurikulumModel;
use App\Models\SurveiModel;

class Home extends BaseController
{
    protected $ketuaProdiModel;
    protected $visiMisiTujuanModel;
    protected $sejarahModel;
    protected $beritaModel;
    protected $profilLulusanModel;
    protected $saranaPrasaranaModel;
    protected $kurikulumModel;
    protected $surveiModel;

    public function __construct()
    {
        $this->ketuaProdiModel = new KetuaProgramStudiModel();
        $this->visiMisiTujuanModel = new VisiMisiTujuanModel();
        $this->sejarahModel = new SejarahModel();
        $this->beritaModel = new BeritaModel();
        $this->profilLulusanModel = new ProfilLulusanModel();
        $this->saranaPrasaranaModel = new SaranaPrasaranaModel();
        $this->kurikulumModel = new KurikulumModel();
        $this->surveiModel = new SurveiModel();

        helper('text');
    }

    private function getLocalizedField(array $data, string $fieldBaseName, string $locale): string
    {
        $fieldName = ($locale === 'en') ? $fieldBaseName . '_en' : $fieldBaseName;
        return $data[$fieldName] ?? $data[$fieldBaseName] ?? ''; // Fallback ke field dasar jika _en tidak ada atau kosong
    }


    public function index(): string
    {
        $locale = $this->request->getLocale();

        $ketuaProdiData = $this->ketuaProdiModel->first();
        $visiMisiTujuanData = $this->visiMisiTujuanModel->first();
        $sejarahData = $this->sejarahModel->first();
        $beritaTerbaru = $this->beritaModel->orderBy('created_at', 'DESC')->findAll(4);

        $data = [
            'ketuaProdi' => [
                'nama'     => $this->getLocalizedField($ketuaProdiData, 'nama', $locale),
                'sambutan' => $this->getLocalizedField($ketuaProdiData, 'sambutan', $locale),
                'gambar'   => $ketuaProdiData['gambar'] ?? '',
            ],
            'visiMisiTujuan' => [
                'visi'    => $this->getLocalizedField($visiMisiTujuanData, 'visi_id', $locale),
                'misi'    => $this->getLocalizedField($visiMisiTujuanData, 'misi_id', $locale),
                'tujuan'  => $this->getLocalizedField($visiMisiTujuanData, 'tujuan_id', $locale),
            ],
            'sejarah' => $this->getLocalizedField($sejarahData, 'content', $locale),
            'beritaTerbaru'  => $beritaTerbaru,
            'currentLocale'  => $locale,
            'title'          => ($locale === 'en') ? 'Homepage' : 'Beranda',
        ];

        return view('landing-page', $data);
    }

    public function sejarah()
    {
        $locale = $this->request->getLocale();
        $sejarahData = $this->sejarahModel->first();

        $data = [
            'sejarah_content' => $this->getLocalizedField($sejarahData, 'content', $locale),
            'title'           => ($locale === 'en') ? 'History' : 'Sejarah',
            'currentLocale'   => $locale,
        ];

        return view('sejarah', $data);
    }

    public function profil_lulusan()
    {
        $locale = $this->request->getLocale();
        $profilLulusan = $this->profilLulusanModel->findAll();

        $formattedProfilLulusan = [];
        foreach ($profilLulusan as $profil) {
            $formattedProfilLulusan[] = [
                'id'        => $profil['id'],
                'gambar'    => $profil['gambar'],
                'judul'     => $this->getLocalizedField($profil, 'judul', $locale),
                'deskripsi' => $this->getLocalizedField($profil, 'deskripsi', $locale),
            ];
        }

        $data = [
            'profilLulusan' => $formattedProfilLulusan,
            'title'         => ($locale === 'en') ? 'Graduate Profile' : 'Profil Lulusan',
            'currentLocale' => $locale,
        ];

        return view('profil-lulusan', $data);
    }

    public function kurikulum()
    {
        $locale = $this->request->getLocale();
        $kurikulumData = $this->kurikulumModel->findAll(); // Mengambil semua data kurikulum

        $formattedKurikulum = [];
        foreach ($kurikulumData as $item) {
            $formattedKurikulum[] = [
                'id'          => $item['id'],
                'gambar'      => $item['gambar'],
                'keterangan'  => $this->getLocalizedField($item, 'keterangan', $locale), // Menggunakan helper untuk lokalisasi
            ];
        }

        $data = [
            'kurikulum'       => $this->kurikulumModel->findAll(),
            'title'           => ($locale === 'en') ? 'Curriculum' : 'Kurikulum',
            'currentLocale'   => $locale,
        ];
        return view('kurikulum', $data);
    }

    public function student_guide()
    {
        $locale = $this->request->getLocale();
        $data['title'] = ($locale === 'en') ? 'Student Guide' : 'Panduan Mahasiswa';
        $data['currentLocale'] = $locale;
        return view('student-guide', $data);
    }

    public function sarana_dan_prasarana()
    {
        $locale = $this->request->getLocale();
        $saranaPrasarana = $this->saranaPrasaranaModel->findAll();

        $formattedSaranaPrasarana = [];
        foreach ($saranaPrasarana as $item) {
            $formattedSaranaPrasarana[] = [
                'id'               => $item['id'],
                'nama'             => $this->getLocalizedField($item, 'nama', $locale),
                'deskripsi'        => $this->getLocalizedField($item, 'deskripsi', $locale),
                'gambar_thumbnail' => $item['gambar_thumbnail'],
                'file_video'       => $item['file_video'],
            ];
        }

        $data = [
            'saranaPrasarana' => $formattedSaranaPrasarana,
            'title'           => ($locale === 'en') ? 'Facilities and Infrastructure' : 'Sarana dan Prasarana',
            'currentLocale'   => $locale,
        ];

        return view('sarana-dan-prasarana', $data);
    }

    public function sambutan_ketua_program_studi()
    {
        $locale = $this->request->getLocale();
        $ketuaProdiData = $this->ketuaProdiModel->first();

        $data = [
            'nama_ketua'       => $this->getLocalizedField($ketuaProdiData, 'nama', $locale),
            'sambutan_content' => $this->getLocalizedField($ketuaProdiData, 'sambutan', $locale),
            'gambar_ketua'     => $ketuaProdiData['gambar'] ?? 'default.jpg',
            'title'            => ($locale === 'en') ? 'Head of Study Program\'s Welcome Speech' : 'Sambutan Ketua Program Studi',
            'currentLocale'    => $locale,
        ];

        return view('sambutan-ketua-program-studi', $data);
    }

    public function visi_misi_tujuan()
    {
        $locale = $this->request->getLocale();
        $visiMisiTujuanData = $this->visiMisiTujuanModel->first();

        $data = [
            'visi_content'   => $this->getLocalizedField($visiMisiTujuanData, 'visi_id', $locale),
            'misi_content'   => $this->getLocalizedField($visiMisiTujuanData, 'misi_id', $locale),
            'tujuan_content' => $this->getLocalizedField($visiMisiTujuanData, 'tujuan_id', $locale),
            'title'          => ($locale === 'en') ? 'Vision, Mission, Goals' : 'Visi, Misi, Tujuan',
            'currentLocale'  => $locale,
        ];

        return view('visi-misi-tujuan', $data);
    }

    public function survei()
    {
        $locale = $this->request->getLocale();
        $surveis = $this->surveiModel->findAll();

        $data = [
            'title'         => ($locale === 'en') ? 'Surveys' : 'Survei',
            'surveis'       => $surveis,
            'currentLocale' => $locale,
        ];

        return view('survei', $data);
    }
}
