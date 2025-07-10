<?php

namespace App\Models;

use CodeIgniter\Model;

class SurveiModel extends Model // Ubah nama kelas
{
    protected $table            = 'survei'; // Ubah nama tabel
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'judul',
        'deskripsi',
        'link'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'judul'     => 'required|max_length[255]',
        'deskripsi' => 'permit_empty',
        'link'      => 'required|max_length[255]|valid_url',
    ];

    protected $validationMessages = [
        'judul' => [
            'required'   => 'Judul survei harus diisi.', // Sesuaikan pesan
            'max_length' => 'Judul survei terlalu panjang (maksimal 255 karakter).', // Sesuaikan pesan
        ],
        'link' => [
            'required'   => 'Link survei harus diisi.', // Sesuaikan pesan
            'max_length' => 'Link survei terlalu panjang (maksimal 255 karakter).', // Sesuaikan pesan
            'valid_url'  => 'Format link survei tidak valid.', // Sesuaikan pesan
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

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
