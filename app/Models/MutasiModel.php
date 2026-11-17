<?php

namespace App\Models;

use CodeIgniter\Model;

class MutasiModel extends Model
{
    protected $table            = 'mutasi_penduduk';
    protected $primaryKey       = 'id_mutasi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nik',
        'jenis_mutasi',
        'tanggal_mutasi',
        'keterangan',
        'created_by',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get mutasi list with resident and user info
     */
    public function getAllWithDetails(?string $jenis = null, ?string $bulan = null, ?string $tahun = null)
    {
        $builder = $this->select('mutasi_penduduk.*, penduduk.nama_lengkap, penduduk.no_kk, penduduk.jenis_kelamin, users.nama_lengkap as nama_petugas')
                        ->join('penduduk', 'penduduk.nik = mutasi_penduduk.nik', 'left')
                        ->join('users', 'users.id_user = mutasi_penduduk.created_by', 'left');

        if ($jenis) {
            $builder->where('mutasi_penduduk.jenis_mutasi', $jenis);
        }

        if ($bulan) {
            $builder->where('MONTH(mutasi_penduduk.tanggal_mutasi)', $bulan);
        }

        if ($tahun) {
            $builder->where('YEAR(mutasi_penduduk.tanggal_mutasi)', $tahun);
        }

        return $builder->orderBy('mutasi_penduduk.tanggal_mutasi', 'DESC')->get()->getResultArray();
    }

    /**
     * Get monthly counts for reporting
     */
    public function getStatistikMutasi()
    {
        $db = \Config\Database::connect();
        return $db->query("
            SELECT 
                jenis_mutasi,
                COUNT(*) as total
            FROM mutasi_penduduk
            WHERE YEAR(tanggal_mutasi) = YEAR(CURDATE())
            GROUP BY jenis_mutasi
        ")->getResultArray();
    }
}
