<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BeritaModel;
use App\Models\ResidentActivityModel;
use App\Models\PengunjungModel; // Pastikan PengunjungModel sudah di-import

class Dashboard extends BaseController
{
    protected $beritaModel;
    protected $residentActivityModel;
    protected $pengunjungModel; // Properti untuk PengunjungModel

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
        $this->residentActivityModel = new ResidentActivityModel();
        $this->pengunjungModel = new PengunjungModel(); // Inisialisasi PengunjungModel

        helper('text');
    }

    public function index()
    {
        // Ambil data pengunjung hari ini
        $today = date('Y-m-d');
        $pengunjungHariIniData = $this->pengunjungModel->where('tanggal_kunjungan', $today)->first();
        $pengunjungHariIni = $pengunjungHariIniData['jumlah_pengunjung'] ?? 0;

        // Ambil data pengunjung bulan ini
        $pengunjungBulanIni = $this->pengunjungModel->getMonthlyVisitors(); // Menggunakan metode dari PengunjungModel

        // Ambil jumlah total data dari model yang relevan
        $totalBerita = $this->beritaModel->countAllResults();
        $totalStudentActivity = $this->residentActivityModel->countAllResults();

        // Data untuk metrik baru (misalnya, 30 hari terakhir)
        $thirtyDaysAgo = date('Y-m-d H:i:s', strtotime('-30 days'));

        $newBerita = $this->beritaModel->where('created_at >=', $thirtyDaysAgo)->countAllResults();
        $newStudentActivity = $this->residentActivityModel->where('created_at >=', $thirtyDaysAgo)->countAllResults();

        // Data untuk aktivitas terbaru (misalnya, 5 item terbaru dari setiap kategori)
        $recentBerita = $this->beritaModel->orderBy('created_at', 'DESC')->findAll(5);
        $recentStudentActivity = $this->residentActivityModel->orderBy('created_at', 'DESC')->findAll(5);

        $data = [
            'title'                => 'Dashboard Admin',
            'pengunjungHariIni'    => $pengunjungHariIni, // Data pengunjung hari ini
            'pengunjungBulanIni'   => $pengunjungBulanIni, // Data pengunjung bulan ini
            'totalBerita'          => $totalBerita,
            'totalStudentActivity' => $totalStudentActivity,

            'newBerita'            => $newBerita,
            'newStudentActivity'   => $newStudentActivity,

            'recentBerita'         => $recentBerita,
            'recentStudentActivity' => $recentStudentActivity,
        ];

        return view('admin/dashboard', $data);
    }
}
