<?php

namespace App\Models;

use CodeIgniter\Model;

class SaranaPrasaranaModel extends Model
{
    protected $table            = 'sarana_prasarana';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true; // Sesuaikan dengan migration Anda

    protected $allowedFields = ['nama', 'deskripsi', 'gambar_thumbnail', 'file_video'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
