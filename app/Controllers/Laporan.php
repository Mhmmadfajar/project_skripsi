<?php

namespace App\Controllers;

use App\Models\PendudukModel;
use App\Models\KartuKeluargaModel;
use App\Models\MutasiModel;
use App\Models\SuratModel;

class Laporan extends BaseController
{
    protected $pendudukModel;
    protected $kkModel;
    protected $mutasiModel;
    protected $suratModel;

    public function __construct()
    {
        $this->pendudukModel = new PendudukModel();
        $this->kkModel = new KartuKeluargaModel();
        $this->mutasiModel = new MutasiModel();
        $this->suratModel = new SuratModel();
    }

    public function index()
    {
        $statistik = $this->pendudukModel->getStatistik();
        $totalKk   = $this->kkModel->countAll();
        $statMutasi = $this->mutasiModel->getStatistikMutasi();
        $statSurat = $this->suratModel->getStatistikSurat();

        $db = \Config\Database::connect();
        $suratPerJenis = $db->query("
            SELECT js.nama_surat, js.kode_surat, COUNT(ps.id_pengajuan) as total,
                   SUM(CASE WHEN ps.status = 'Disetujui' THEN 1 ELSE 0 END) as disetujui
            FROM jenis_surat js
            LEFT JOIN pengajuan_surat ps ON ps.id_jenis_surat = js.id_jenis_surat
            GROUP BY js.id_jenis_surat
        ")->getResultArray();

        return view('laporan/index', [
            'title'         => 'Laporan & Rekapitulasi Kependudukan',
            'statistik'     => $statistik,
            'totalKk'       => $totalKk,
            'statMutasi'    => $statMutasi,
            'statSurat'     => $statSurat,
            'suratPerJenis' => $suratPerJenis
        ]);
    }

    public function cetak()
    {
        $statistik = $this->pendudukModel->getStatistik();
        $totalKk   = $this->kkModel->countAll();
        $statMutasi = $this->mutasiModel->getStatistikMutasi();

        $db = \Config\Database::connect();
        $suratPerJenis = $db->query("
            SELECT js.nama_surat, js.kode_surat, COUNT(ps.id_pengajuan) as total,
                   SUM(CASE WHEN ps.status = 'Disetujui' THEN 1 ELSE 0 END) as disetujui
            FROM jenis_surat js
            LEFT JOIN pengajuan_surat ps ON ps.id_jenis_surat = js.id_jenis_surat
            GROUP BY js.id_jenis_surat
        ")->getResultArray();

        $kades = $db->table('users')->where('role', 'kades')->get()->getRowArray();

        return view('laporan/cetak', [
            'title'         => 'Cetak Laporan Rekapitulasi Kependudukan',
            'statistik'     => $statistik,
            'totalKk'       => $totalKk,
            'statMutasi'    => $statMutasi,
            'suratPerJenis' => $suratPerJenis,
            'kades'         => $kades
        ]);
    }
}
