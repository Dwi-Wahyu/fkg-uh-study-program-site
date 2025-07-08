<?php

namespace App\Models;

use CodeIgniter\Model;

class VisiMisiTujuanModel extends Model
{
    protected $table            = 'visi_misi_tujuan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false; // Biasanya tidak pakai soft delete untuk data singleton

    protected $allowedFields = [
        'visi_id',
        'visi_en',
        'misi_id',
        'misi_en',
        'tujuan_id',
        'tujuan_en'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at'; // Jika useSoftDeletes false, ini tidak perlu
}
