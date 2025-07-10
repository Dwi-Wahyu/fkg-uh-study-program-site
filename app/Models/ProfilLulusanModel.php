<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfilLulusanModel extends Model
{
    protected $table            = 'profil_lulusan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array'; // Atau 'object' jika Anda lebih suka
    protected $useSoftDeletes   = true; // Mengaktifkan soft delete

    protected $allowedFields = [
        'gambar',
        'judul',
        'deskripsi'
    ];

    // Timestamps
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    protected $validationRules = [
        'gambar'    => 'required|max_length[255]',
        'judul'     => 'max_length[255]',
        'deskripsi' => 'permit_empty',
    ];

    protected $validationMessages = [
        'gambar' => [
            'max_size' => 'Model: Ukuran gambar terlalu besar (maksimal 20MB).',
            'is_image' => 'Model: File yang diunggah bukan gambar yang valid.',
            'mime_in'  => 'Model: Tipe gambar tidak diizinkan. Hanya JPG, JPEG, PNG, GIF, WEBP yang diizinkan.'
        ],
        'judul' => [
            'max_length' => 'Model: Judul terlalu panjang (maksimal 255 karakter).',
        ],
    ];
    protected $skipValidation       = false; // Pastikan ini false agar validasi model berjalan
    protected $cleanValidationRules = true;

    // Callbacks (opsional)
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
