<?php

namespace App\Models;

use CodeIgniter\Model;

class PendudukModel extends Model
{
    protected $table            = 'penduduk';
    protected $primaryKey       = 'nik';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nik',
        'no_kk',
        'nama_lengkap',
        'jenis_kelamin',
        'alamat',
        'rt',
        'rw',
        'desa_kelurahan',
        'kecamatan',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'status_perkawinan',
        'shdk',
        'pekerjaan',
        'pendidikan_terakhir',
        'golongan_darah',
        'kewarganegaraan',
        'status_penduduk',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get resident with family card info
     */
    public function getWithKK(string $nik)
    {
        return $this->select('penduduk.*, kartu_keluarga.alamat as alamat_kk, kartu_keluarga.rt as rt_kk, kartu_keluarga.rw as rw_kk, kartu_keluarga.kode_pos, kepala.nama_lengkap as nama_kepala_keluarga')
                    ->join('kartu_keluarga', 'kartu_keluarga.no_kk = penduduk.no_kk', 'left')
                    ->join('penduduk as kepala', 'kepala.nik = kartu_keluarga.nik_kepala_keluarga', 'left')
                    ->where('penduduk.nik', $nik)
                    ->first();
    }

    /**
     * Filter residents
     */
    public function filterPenduduk(?string $search = null, ?string $rt = null, ?string $rw = null, ?string $jk = null, ?string $status = null)
    {
        $builder = $this->builder();
        if ($search) {
            $builder->groupStart()
                    ->like('penduduk.nik', $search)
                    ->orLike('penduduk.nama_lengkap', $search)
                    ->orLike('penduduk.no_kk', $search)
                    ->groupEnd();
        }
        if ($rt) {
            $builder->where('penduduk.rt', $rt);
        }
        if ($rw) {
            $builder->where('penduduk.rw', $rw);
        }
        if ($jk) {
            $builder->where('penduduk.jenis_kelamin', $jk);
        }
        if ($status) {
            $builder->where('penduduk.status_penduduk', $status);
        } else {
            // Default to 'Ada' if not explicitly filtering all
        }

        return $builder->orderBy('penduduk.nama_lengkap', 'ASC')->get()->getResultArray();
    }

    /**
     * Demographics statistics
     */
    public function getStatistik()
    {
        $db = \Config\Database::connect();

        $total = $this->where('status_penduduk', 'Ada')->countAllResults();
        $laki = $this->where('status_penduduk', 'Ada')->where('jenis_kelamin', 'L')->countAllResults();
        $perempuan = $this->where('status_penduduk', 'Ada')->where('jenis_kelamin', 'P')->countAllResults();

        // Age categories: Balita (0-5), Anak (6-17), Produktif (18-59), Lansia (60+)
        $queryUsia = $db->query("
            SELECT
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 0 AND 5 THEN 1 ELSE 0 END) as balita,
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 6 AND 17 THEN 1 ELSE 0 END) as anak,
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 18 AND 59 THEN 1 ELSE 0 END) as produktif,
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 60 THEN 1 ELSE 0 END) as lansia
            FROM penduduk
            WHERE status_penduduk = 'Ada'
        ")->getRowArray();

        // Distribution by RT
        $distribusiRT = $db->query("
            SELECT CONCAT('RT ', LPAD(rt, 3, '0')) as nama_rt, COUNT(*) as jumlah
            FROM penduduk
            WHERE status_penduduk = 'Ada' AND rt IS NOT NULL AND rt != ''
            GROUP BY rt
            ORDER BY rt ASC
        ")->getResultArray();

        // Distribution by Religion
        $distribusiAgama = $db->query("
            SELECT agama, COUNT(*) as jumlah
            FROM penduduk
            WHERE status_penduduk = 'Ada'
            GROUP BY agama
        ")->getResultArray();

        // Distribution by Marital Status
        $distribusiPerkawinan = $db->query("
            SELECT status_perkawinan, COUNT(*) as jumlah
            FROM penduduk
            WHERE status_penduduk = 'Ada'
            GROUP BY status_perkawinan
        ")->getResultArray();

        return [
            'total'          => $total,
            'laki'           => $laki,
            'perempuan'      => $perempuan,
            'usia'           => $queryUsia ?? ['balita' => 0, 'anak' => 0, 'produktif' => 0, 'lansia' => 0],
            'distribusi_rt'   => $distribusiRT,
            'distribusi_agama' => $distribusiAgama,
            'distribusi_kawin' => $distribusiPerkawinan,
        ];
    }
}
