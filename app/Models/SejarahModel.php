<?php

namespace App\Models;

use CodeIgniter\Model;

class SejarahModel extends Model
{
    protected $table            = 'sejarah';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false; // Biasanya tidak pakai soft delete untuk data singleton

    // Pastikan 'content' dan 'content_en' ada di sini
    protected $allowedFields = [
        'content',
        'content_en'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at'; // Jika useSoftDeletes false, ini tidak perlu
}
