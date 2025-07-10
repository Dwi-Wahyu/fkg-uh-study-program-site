<?php

namespace App\Models;

use CodeIgniter\Model;

class PengunjungModel extends Model
{
    protected $table            = 'pengunjung';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false; // Tidak menggunakan soft delete untuk statistik pengunjung

    // Kolom yang diizinkan untuk diisi
    protected $allowedFields = [
        'tanggal_kunjingan',
        'jumlah_pengunjung'
    ];

    // Timestamps
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = null; // Tidak menggunakan deleted_at

    // Aturan validasi (opsional, tapi direkomendasikan)
    protected $validationRules = [
        'tanggal_kunjungan' => 'required|valid_date|is_unique[pengunjung.tanggal_kunjungan,id,{id}]',
        'jumlah_pengunjung' => 'required|integer|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'tanggal_kunjungan' => [
            'required'   => 'Tanggal kunjungan harus diisi.',
            'valid_date' => 'Format tanggal kunjungan tidak valid.',
            'is_unique'  => 'Data pengunjung untuk tanggal ini sudah ada.',
        ],
        'jumlah_pengunjung' => [
            'required'             => 'Jumlah pengunjung harus diisi.',
            'integer'              => 'Jumlah pengunjung harus berupa angka bulat.',
            'greater_than_equal_to' => 'Jumlah pengunjung tidak boleh negatif.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Metode kustom untuk mencatat atau memperbarui jumlah pengunjung harian.
     * Akan mencari entri untuk tanggal hari ini. Jika ada, akan menambah jumlah pengunjung.
     * Jika tidak ada, akan membuat entri baru.
     */
    public function recordVisitor()
    {
        $today = date('Y-m-d'); // Format tanggal YYYY-MM-DD

        // Cari entri untuk tanggal hari ini
        $visitorRecord = $this->where('tanggal_kunjungan', $today)->first();

        if ($visitorRecord) {
            // Jika sudah ada, tambahkan jumlah pengunjung
            $this->update($visitorRecord['id'], ['jumlah_pengunjung' => $visitorRecord['jumlah_pengunjung'] + 1]);
        } else {
            // Jika belum ada, buat entri baru
            $this->insert([
                'tanggal_kunjungan' => $today,
                'jumlah_pengunjung' => 1,
            ]);
        }
    }

    /**
     * Menghitung total pengunjung untuk bulan tertentu.
     *
     * @param int|null $month Bulan (1-12). Jika null, akan menggunakan bulan saat ini.
     * @param int|null $year Tahun (YYYY). Jika null, akan menggunakan tahun saat ini.
     * @return int Total jumlah pengunjung untuk bulan tersebut.
     */
    public function getMonthlyVisitors(?int $month = null, ?int $year = null): int
    {
        // Jika bulan atau tahun tidak disediakan, gunakan bulan/tahun saat ini
        $month = $month ?? (int) date('m');
        $year = $year ?? (int) date('Y');

        // Bangun query untuk menjumlahkan pengunjung dalam rentang bulan
        $builder = $this->builder();
        $builder->selectSum('jumlah_pengunjung', 'total_visitors');
        $builder->where('YEAR(tanggal_kunjungan)', $year);
        $builder->where('MONTH(tanggal_kunjungan)', $month);

        $result = $builder->get()->getRow();

        return (int) ($result->total_visitors ?? 0);
    }

    /**
     * Menghitung total pengunjung untuk tahun tertentu.
     *
     * @param int|null $year Tahun (YYYY). Jika null, akan menggunakan tahun saat ini.
     * @return int Total jumlah pengunjung untuk tahun tersebut.
     */
    public function getYearlyVisitors(?int $year = null): int
    {
        $year = $year ?? (int) date('Y');

        $builder = $this->builder();
        $builder->selectSum('jumlah_pengunjung', 'total_visitors');
        $builder->where('YEAR(tanggal_kunjungan)', $year);

        $result = $builder->get()->getRow();

        return (int) ($result->total_visitors ?? 0);
    }

    /**
     * Menghitung total pengunjung keseluruhan.
     *
     * @return int Total jumlah pengunjung dari semua waktu.
     */
    public function getTotalVisitors(): int
    {
        $builder = $this->builder();
        $builder->selectSum('jumlah_pengunjung', 'total_visitors');

        $result = $builder->get()->getRow();

        return (int) ($result->total_visitors ?? 0);
    }
}
