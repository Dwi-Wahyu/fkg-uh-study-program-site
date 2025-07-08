<?php

namespace App\Models;

use CodeIgniter\Model;

class KetuaProgramStudiModel extends Model
{
    protected $table            = 'ketua_program_studi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;

    protected $allowedFields = ['nama', 'sambutan', 'gambar', 'sambutan_en'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at'; // Hanya jika useSoftDeletes true
}
