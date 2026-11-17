<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisSuratModel extends Model
{
    protected $table            = 'jenis_surat';
    protected $primaryKey       = 'id_jenis_surat';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kode_surat',
        'nama_surat',
        'format_nomor',
        'persyaratan',
        'is_active',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getActive()
    {
        return $this->where('is_active', 1)->orderBy('nama_surat', 'ASC')->findAll();
    }
}
