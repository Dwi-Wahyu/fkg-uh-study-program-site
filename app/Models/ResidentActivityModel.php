<?php

namespace App\Models;

use CodeIgniter\Model;

class ResidentActivityModel extends Model
{
    protected $table            = 'resident_activity';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true; // Sesuaikan dengan migration Anda

    // Kolom yang diizinkan untuk diisi
    protected $allowedFields = ['judul', 'deskripsi', 'gambar', 'tanggal'];

    // Timestamps
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at'; // Hanya jika useSoftDeletes true

    // Validasi (Opsional, tapi disarankan)
    // protected $validationRules    = [];
    // protected $validationMessages = [];
    // protected $skipValidation     = false;
}
