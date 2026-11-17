<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratModel extends Model
{
    protected $table            = 'pengajuan_surat';
    protected $primaryKey       = 'id_pengajuan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nik',
        'jenis_surat',
        'no_surat',
        'id_jenis_surat',
        'nik_pemohon',
        'keperluan',
        'tanggal_pengajuan',
        'status',
        'qr_code',
        'tgl_disetujui',
        'catatan_revisi',
        'disetujui_oleh',
        'tanggal_persetujuan',
        'file_surat_pdf',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get applications with all related details
     */
    public function getAllWithDetails(?string $status = null, ?string $search = null, ?string $nik_pemohon = null)
    {
        $builder = $this->select('pengajuan_surat.*, 
                                  penduduk.nama_lengkap as nama_pemohon, 
                                  penduduk.no_kk, 
                                  penduduk.alamat, 
                                  penduduk.rt, 
                                  penduduk.rw, 
                                  penduduk.tempat_lahir,
                                  penduduk.tanggal_lahir,
                                  penduduk.jenis_kelamin,
                                  penduduk.pekerjaan,
                                  penduduk.agama,
                                  penduduk.status_perkawinan,
                                  jenis_surat.kode_surat, 
                                  jenis_surat.nama_surat,
                                  kades.nama_lengkap as nama_kades')
                        ->join('penduduk', 'penduduk.nik = pengajuan_surat.nik_pemohon', 'left')
                        ->join('jenis_surat', 'jenis_surat.id_jenis_surat = pengajuan_surat.id_jenis_surat', 'left')
                        ->join('users as kades', 'kades.id_user = pengajuan_surat.disetujui_oleh', 'left');

        if ($status && $status !== 'Semua') {
            $builder->where('pengajuan_surat.status', $status);
        }

        if ($nik_pemohon) {
            $builder->where('pengajuan_surat.nik_pemohon', $nik_pemohon);
        }

        if ($search) {
            $builder->groupStart()
                    ->like('pengajuan_surat.no_surat', $search)
                    ->orLike('penduduk.nama_lengkap', $search)
                    ->orLike('pengajuan_surat.nik_pemohon', $search)
                    ->orLike('jenis_surat.nama_surat', $search)
                    ->groupEnd();
        }

        return $builder->orderBy('pengajuan_surat.tanggal_pengajuan', 'DESC')->get()->getResultArray();
    }

    /**
     * Get single application by ID with full details
     */
    public function getWithDetails(int $id_pengajuan)
    {
        return $this->select('pengajuan_surat.*, 
                              penduduk.nama_lengkap as nama_pemohon, 
                              penduduk.no_kk, 
                              penduduk.alamat, 
                              penduduk.rt, 
                              penduduk.rw, 
                              penduduk.desa_kelurahan,
                              penduduk.kecamatan,
                              penduduk.tempat_lahir,
                              penduduk.tanggal_lahir,
                              penduduk.jenis_kelamin,
                              penduduk.agama,
                              penduduk.pekerjaan,
                              penduduk.status_perkawinan,
                              penduduk.kewarganegaraan,
                              jenis_surat.kode_surat, 
                              jenis_surat.nama_surat,
                              jenis_surat.format_nomor,
                              kades.nama_lengkap as nama_kades')
                    ->join('penduduk', 'penduduk.nik = pengajuan_surat.nik_pemohon', 'left')
                    ->join('jenis_surat', 'jenis_surat.id_jenis_surat = pengajuan_surat.id_jenis_surat', 'left')
                    ->join('users as kades', 'kades.id_user = pengajuan_surat.disetujui_oleh', 'left')
                    ->where('pengajuan_surat.id_pengajuan', $id_pengajuan)
                    ->first();
    }

    /**
     * Find by QR code token for public verification
     */
    public function getByQrCode(string $qr_code)
    {
        return $this->select('pengajuan_surat.*, 
                              penduduk.nama_lengkap as nama_pemohon, 
                              penduduk.nik as nik_pemohon,
                              penduduk.alamat, 
                              penduduk.rt, 
                              penduduk.rw, 
                              penduduk.desa_kelurahan,
                              penduduk.kecamatan,
                              penduduk.tempat_lahir,
                              penduduk.tanggal_lahir,
                              penduduk.pekerjaan,
                              jenis_surat.kode_surat, 
                              jenis_surat.nama_surat,
                              kades.nama_lengkap as nama_kades')
                    ->join('penduduk', 'penduduk.nik = pengajuan_surat.nik_pemohon', 'left')
                    ->join('jenis_surat', 'jenis_surat.id_jenis_surat = pengajuan_surat.id_jenis_surat', 'left')
                    ->join('users as kades', 'kades.id_user = pengajuan_surat.disetujui_oleh', 'left')
                    ->where('pengajuan_surat.qr_code', $qr_code)
                    ->first();
    }

    /**
     * Statistics of letter applications
     */
    public function getStatistikSurat()
    {
        $db = \Config\Database::connect();
        $res = $db->query("
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'Proses' THEN 1 ELSE 0 END) as proses,
                SUM(CASE WHEN status = 'Disetujui' THEN 1 ELSE 0 END) as disetujui,
                SUM(CASE WHEN status = 'Ditolak' THEN 1 ELSE 0 END) as ditolak
            FROM pengajuan_surat
        ")->getRowArray();

        return [
            'total'     => (int) ($res['total'] ?? 0),
            'pending'   => (int) ($res['pending'] ?? 0),
            'proses'    => (int) ($res['proses'] ?? 0),
            'disetujui' => (int) ($res['disetujui'] ?? 0),
            'ditolak'   => (int) ($res['ditolak'] ?? 0),
        ];
    }

    /**
     * Generate official letter number
     */
    public function generateNoSurat(int $id_jenis_surat): string
    {
        $db = \Config\Database::connect();
        $jenis = $db->table('jenis_surat')->where('id_jenis_surat', $id_jenis_surat)->get()->getRowArray();
        if (!$jenis) {
            return '470/' . str_pad((string) rand(1, 9999), 4, '0', STR_PAD_LEFT) . '/DS-JMP/' . date('Y');
        }

        $count = $this->where('id_jenis_surat', $id_jenis_surat)
                      ->where('YEAR(tanggal_pengajuan)', date('Y'))
                      ->where('status', 'Disetujui')
                      ->countAllResults() + 1;

        $noStr = str_pad((string) $count, 3, '0', STR_PAD_LEFT);
        $romawiBulan = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'];
        $bulanRomawi = $romawiBulan[(int) date('n')] ?? date('m');
        $tahun = date('Y');

        $format = $jenis['format_nomor'];
        $formatted = str_replace(
            ['{no}', '{bulan}', '{tahun}'],
            [$noStr, $bulanRomawi, $tahun],
            $format
        );

        return $formatted;
    }
}
