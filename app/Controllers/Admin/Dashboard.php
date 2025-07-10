<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BeritaModel;
use App\Models\StudentActivityModel; // Tambahkan ini

class Dashboard extends BaseController
{
    protected $beritaModel;
    protected $studentActivityModel; // Tambahkan ini

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
        $this->studentActivityModel = new StudentActivityModel(); // Inisialisasi model

        helper('text'); // Pastikan text helper dimuat untuk character_limiter
    }

    public function index()
    {
        // Data hardcode untuk total pengunjung
        $totalVisitors = 1500; // Contoh: Angka pengunjung hardcode

        // Ambil jumlah total data dari model yang relevan
        $totalBerita = $this->beritaModel->countAllResults();
        $totalStudentActivity = $this->studentActivityModel->countAllResults();

        // Data untuk metrik baru (misalnya, 30 hari terakhir)
        $thirtyDaysAgo = date('Y-m-d H:i:s', strtotime('-30 days'));

        $newBerita = $this->beritaModel->where('created_at >=', $thirtyDaysAgo)->countAllResults();
        $newStudentActivity = $this->studentActivityModel->where('created_at >=', $thirtyDaysAgo)->countAllResults();

        // Data untuk aktivitas terbaru (misalnya, 5 item terbaru dari setiap kategori)
        $recentBerita = $this->beritaModel->orderBy('created_at', 'DESC')->findAll(5);
        $recentStudentActivity = $this->studentActivityModel->orderBy('created_at', 'DESC')->findAll(5);

        $data = [
            'title'                => 'Dashboard Admin',
            'totalVisitors'        => $totalVisitors, // Teruskan ke view
            'totalBerita'          => $totalBerita,
            'totalStudentActivity' => $totalStudentActivity, // Teruskan ke view

            'newBerita'            => $newBerita,
            'newStudentActivity'   => $newStudentActivity, // Teruskan ke view

            'recentBerita'         => $recentBerita,
            'recentStudentActivity' => $recentStudentActivity, // Teruskan ke view
        ];

        return view('admin/dashboard', $data);
    }
}
