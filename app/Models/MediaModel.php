<?php

namespace App\Models;

use CodeIgniter\Model;

class MediaModel extends Model
{
    protected $table            = 'media'; // Pastikan nama tabel Anda di sini
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Kolom yang diizinkan untuk diisi melalui metode save(), insert(), atau update()
    protected $allowedFields = ['file_name', 'file_type', 'file_size', 'alt_text'];

    // Timestamps
    protected $useTimestamps = true; // Set ke true karena kita punya created_at dan updated_at
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at'; // Hanya jika useSoftDeletes true
}
