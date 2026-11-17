<?php

namespace App\Models;

use CodeIgniter\Model;

class KartuKeluargaModel extends Model
{
    protected $table            = 'kartu_keluarga';
    protected $primaryKey       = 'no_kk';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'no_kk',
        'nik_kepala_keluarga',
        'alamat',
        'rt',
        'rw',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get all KK with head of family name and members count
     */
    public function getAllWithDetails(?string $search = null, ?string $rt = null)
    {
        $builder = $this->select('kartu_keluarga.*, penduduk.nama_lengkap as nama_kepala_keluarga, (SELECT COUNT(*) FROM penduduk p WHERE p.no_kk = kartu_keluarga.no_kk AND p.status_penduduk = "Ada") as jumlah_anggota')
                        ->join('penduduk', 'penduduk.nik = kartu_keluarga.nik_kepala_keluarga', 'left');

        if ($search) {
            $builder->groupStart()
                    ->like('kartu_keluarga.no_kk', $search)
                    ->orLike('penduduk.nama_lengkap', $search)
                    ->orLike('kartu_keluarga.alamat', $search)
                    ->groupEnd();
        }

        if ($rt) {
            $builder->where('kartu_keluarga.rt', $rt);
        }

        return $builder->orderBy('kartu_keluarga.created_at', 'DESC')->get()->getResultArray();
    }

    /**
     * Get single KK with head of family details
     */
    public function getWithKepala(string $no_kk)
    {
        return $this->select('kartu_keluarga.*, penduduk.nama_lengkap as nama_kepala_keluarga')
                    ->join('penduduk', 'penduduk.nik = kartu_keluarga.nik_kepala_keluarga', 'left')
                    ->where('kartu_keluarga.no_kk', $no_kk)
                    ->first();
    }

    /**
     * Get all members of a family card
     */
    public function getAnggota(string $no_kk)
    {
        $db = \Config\Database::connect();
        return $db->table('penduduk')
                  ->where('no_kk', $no_kk)
                  ->orderBy("FIELD(shdk, 'Kepala Keluarga', 'Suami', 'Istri', 'Anak', 'Mantu', 'Cucu', 'Orang Tua', 'Mertua', 'Famili Lain', 'Lainnya')", '', false)
                  ->get()
                  ->getResultArray();
    }
}
