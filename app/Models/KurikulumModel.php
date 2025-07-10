<?php

namespace App\Models;

use CodeIgniter\Model;

class KurikulumModel extends Model
{
    protected $table            = 'kurikulum';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true; // Mengaktifkan soft delete

    // Kolom yang diizinkan untuk diisi
    protected $allowedFields = ['gambar', 'keterangan', 'keterangan_en'];

    // Timestamps
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at'; // Untuk soft delete

    // Aturan validasi (opsional, bisa juga di controller)
    protected $validationRules = [
        'gambar'    => 'required|max_length[255]',
        'keterangan'    => 'permit_empty',
        'keterangan_en' => 'permit_empty',
    ];

    protected $validationMessages = [
        'gambar' => [
            'max_size' => 'Ukuran gambar terlalu besar (maksimal 20MB).',
            'is_image' => 'File yang diunggah bukan gambar yang valid.',
            'mime_in'  => 'Tipe gambar tidak diizinkan. Hanya JPG, JPEG, PNG, GIF, WEBP yang diizinkan.'
        ],
    ];
}
