<?php

namespace App\Controllers;

use App\Models\PendudukModel;
use App\Models\KartuKeluargaModel;
use App\Models\SuratModel;
use App\Models\MutasiModel;

class Dashboard extends BaseController
{
    protected $pendudukModel;
    protected $kkModel;
    protected $suratModel;
    protected $mutasiModel;

    public function __construct()
    {
        $this->pendudukModel = new PendudukModel();
        $this->kkModel = new KartuKeluargaModel();
        $this->suratModel = new SuratModel();
        $this->mutasiModel = new MutasiModel();
    }

    public function index()
    {
        $role = session()->get('role');
        $nik = session()->get('nik');

        $data = [
            'title' => 'Dashboard - ' . ucfirst($role),
            'role'  => $role
        ];

        if ($role === 'warga') {
            // Warga Dashboard: Portal Informasi & Layanan Digital Desa
            $penduduk = $nik ? $this->pendudukModel->getWithKK($nik) : null;
            $data['penduduk'] = $penduduk;
            $data['anggota_keluarga'] = (!empty($penduduk['no_kk'])) ? $this->pendudukModel->where('no_kk', $penduduk['no_kk'])->findAll() : [];
            $data['surat_saya'] = $nik ? $this->suratModel->getAllWithDetails(null, null, $nik) : [];
            $data['total_surat'] = count($data['surat_saya']);
            $data['surat_pending'] = count(array_filter($data['surat_saya'], fn($s) => $s['status'] === 'Pending'));
            $data['surat_proses'] = count(array_filter($data['surat_saya'], fn($s) => $s['status'] === 'Proses'));
            $data['surat_disetujui'] = count(array_filter($data['surat_saya'], fn($s) => $s['status'] === 'Disetujui'));
            $data['surat_ditolak'] = count(array_filter($data['surat_saya'], fn($s) => $s['status'] === 'Ditolak'));

            // Data Statistik Desa untuk Transparansi Warga
            $data['total_warga_desa'] = $this->pendudukModel->where('status_penduduk', 'Ada')->countAllResults();
            $data['total_kk_desa'] = $this->kkModel->countAllResults();

            // Papan Pengumuman Resmi Pemerintah Desa
            $data['pengumuman'] = [
                [
                    'id' => 1,
                    'judul' => 'Penyaluran Bantuan Langsung Tunai (BLT-DD) Tahap IV Tahun 2026',
                    'kategori' => 'Bansos & Bantuan',
                    'badge' => 'danger',
                    'icon' => 'bi-cash-coin',
                    'tanggal' => '12 Oktober 2026',
                    'waktu' => '08:30 - 14:00 WIB',
                    'lokasi' => 'Aula Balai Desa Jampang',
                    'ringkasan' => 'Penyaluran dana BLT Dana Desa bagi Keluarga Penerima Manfaat (KPM) terdaftar. Wajib membawa dokumen fisik KTP & KK asli.',
                    'isi' => 'Diberitahukan kepada seluruh warga Desa Jampang yang terdaftar sebagai Keluarga Penerima Manfaat (KPM) BLT Dana Desa Tahap IV bahwa pencairan akan dilaksanakan pada hari Senin, 12 Oktober 2026. Mohon hadir tepat waktu dengan membawa KTP Elektronik Asli dan Kartu Keluarga asli. Pengambilan tidak dapat diwakilkan kecuali dengan surat kuasa resmi bertandatangan RT/RW.',
                    'penulis' => 'Pemerintah Desa Jampang'
                ],
                [
                    'id' => 2,
                    'judul' => 'Layanan Mobil Keliling Perekaman KTP-el Pemula & Pembuatan KIA',
                    'kategori' => 'Pelayanan Publik',
                    'badge' => 'primary',
                    'icon' => 'bi-person-badge',
                    'tanggal' => '15 Oktober 2026',
                    'waktu' => '09:00 - 15:00 WIB',
                    'lokasi' => 'Halaman Parkir Kantor Desa Jampang',
                    'ringkasan' => 'Disdukcapil membuka loket jemput bola khusus perekaman KTP pemula (usia 17 tahun) dan Kartu Identitas Anak (KIA) tanpa dipungut biaya (GRATIS).',
                    'isi' => 'Bagi warga masyarakat Desa Jampang yang memiliki putra-putri yang telah berusia 17 tahun atau belum memiliki KTP-el, serta anak usia 0-16 tahun yang belum memiliki KIA, disilakan hadir memanfaatkan loket pelayanan keliling Disdukcapil di Kantor Desa. Cukup membawa fotokopi Akta Kelahiran dan Kartu Keluarga.',
                    'penulis' => 'Seksi Pelayanan Umum'
                ],
                [
                    'id' => 3,
                    'judul' => 'Jadwal Pemeliharaan Jaringan Irigasi Tersier Wilayah Dusun II',
                    'kategori' => 'Infrastruktur Lingkungan',
                    'badge' => 'warning',
                    'icon' => 'bi-tools',
                    'tanggal' => '18 Oktober 2026',
                    'waktu' => '08:00 - Selesai',
                    'lokasi' => 'Saluran Irigasi Blok Barat Dusun II',
                    'ringkasan' => 'Kegiatan normalisasi dan pembersihan endapan lumpur aliran air pertanian oleh Dinas Pengairan dan Perkumpulan Petani Pemakai Air (P3A).',
                    'isi' => 'Dihimbau kepada seluruh warga dan para petani di sekitar aliran irigasi Dusun II untuk menjaga kebersihan saluran serta tidak membuang sampah ke aliran sungai/irigasi agar pasokan air persawahan tetap lancar.',
                    'penulis' => 'Kaur Pembangunan Desa'
                ]
            ];

            // Agenda & Kegiatan Desa Terkini
            $data['agenda'] = [
                [
                    'id' => 1,
                    'nama' => 'Kerja Bakti Bersih Lingkungan Menjelang Musim Hujan',
                    'tanggal' => 'Jumat, 16 Oktober 2026',
                    'waktu' => '07:00 - 10:00 WIB',
                    'lokasi' => 'Serentak di Seluruh Wilayah RW 01 s/d RW 06',
                    'penyelenggara' => 'Pengurus RT / RW & Karang Taruna',
                    'status' => 'Mendatang',
                    'badge' => 'success',
                    'icon' => 'bi-trash3-fill',
                    'deskripsi' => 'Gotong royong membersihkan selokan, drainase, dan pemangkasan dahan pohon rawan tumbang demi mencegah genangan air.'
                ],
                [
                    'id' => 2,
                    'nama' => 'Pemeriksaan Kesehatan Gratis & Posyandu Balita / Lansia',
                    'tanggal' => 'Senin, 19 Oktober 2026',
                    'waktu' => '08:30 - 12:00 WIB',
                    'lokasi' => 'Poskesdes Melati RW 03',
                    'penyelenggara' => 'Kader PKK & Bidan Desa Jampang',
                    'status' => 'Mendatang',
                    'badge' => 'info',
                    'icon' => 'bi-heart-pulse-fill',
                    'deskripsi' => 'Pemberian vitamin A, timbang balita, imunisasi dasar, serta cek tensi dan gula darah gratis bagi warga lansia.'
                ],
                [
                    'id' => 3,
                    'nama' => 'Musyawarah Perencanaan Pembangunan Desa (Musrenbangdes) 2027',
                    'tanggal' => 'Kamis, 22 Oktober 2026',
                    'waktu' => '13:00 - 17:00 WIB',
                    'lokasi' => 'Gedung Serbaguna Desa Jampang',
                    'penyelenggara' => 'BPD & Pemerintah Desa',
                    'status' => 'Penting',
                    'badge' => 'danger',
                    'icon' => 'bi-people-fill',
                    'deskripsi' => 'Penjaringan aspirasi pembangunan prioritas jalan, penerangan desa, dan pemberdayaan UMKM warga desa.'
                ],
                [
                    'id' => 4,
                    'nama' => 'Turnamen Bola Voli Antar-RW "Kades Cup 2026"',
                    'tanggal' => '24 - 27 Oktober 2026',
                    'waktu' => '15:30 WIB Tiap Sore',
                    'lokasi' => 'Lapangan Olahraga Gelora Jampang',
                    'penyelenggara' => 'Karang Taruna Tunas Harapan',
                    'status' => 'Terbuka',
                    'badge' => 'primary',
                    'icon' => 'bi-trophy-fill',
                    'deskripsi' => 'Ajang silaturahmi olahraga dan kebersamaan antar pemuda dan warga seluruh RW Desa Jampang.'
                ]
            ];

            // Direktori Kontak Darurat & Perangkat Desa
            $data['kontak_darurat'] = [
                [
                    'instansi' => 'Ambulans Siaga Desa (24 Jam)',
                    'nomor' => '0812-9876-5432',
                    'wa' => '6281298765432',
                    'petugas' => 'Pak Joko / Driver Ambulans Desa',
                    'icon' => 'bi-hospital-fill text-danger',
                    'badge' => 'Darurat Medis'
                ],
                [
                    'instansi' => 'Bhabinkamtibmas (Polsek)',
                    'nomor' => '0813-8877-6655',
                    'wa' => '6281388776655',
                    'petugas' => 'Aiptu Bambang Wijaya',
                    'icon' => 'bi-shield-fill-check text-primary',
                    'badge' => 'Kamtibmas'
                ],
                [
                    'instansi' => 'Babinsa (Koramil)',
                    'nomor' => '0811-2233-4455',
                    'wa' => '6281122334455',
                    'petugas' => 'Serka Hendra Setiawan',
                    'icon' => 'bi-shield-shaded text-success',
                    'badge' => 'TNI / Keamanan'
                ],
                [
                    'instansi' => 'Call Center Kantor Balai Desa',
                    'nomor' => '0251-8612345',
                    'wa' => '6282518612345',
                    'petugas' => 'Pelayanan Umum (08:00 - 15:30 WIB)',
                    'icon' => 'bi-building text-teal',
                    'badge' => 'Administrasi Desa'
                ]
            ];

            return view('dashboard/warga', $data);
        }

        // Common stats for Admin, Staf, and Kades
        $data['statistik'] = $this->pendudukModel->getStatistik();
        $data['total_kk'] = $this->kkModel->countAll();
        $data['stat_surat'] = $this->suratModel->getStatistikSurat();
        $data['stat_mutasi'] = $this->mutasiModel->getStatistikMutasi();

        if ($role === 'kades') {
            // Kades Dashboard: Focus on letter approval queue and executive demographics
            $data['antrean_approval'] = $this->suratModel->getAllWithDetails('Pending');
            $data['surat_proses'] = $this->suratModel->getAllWithDetails('Proses');
            $data['surat_terbaru'] = array_slice($this->suratModel->getAllWithDetails(), 0, 5);
            return view('dashboard/kades', $data);
        }

        // Admin & Staf Dashboard
        $data['pengajuan_terbaru'] = array_slice($this->suratModel->getAllWithDetails(), 0, 5);
        $data['mutasi_terbaru'] = array_slice($this->mutasiModel->getAllWithDetails(), 0, 5);
        $data['penduduk_terbaru'] = $this->pendudukModel->where('status_penduduk', 'Ada')
                                                         ->orderBy('created_at', 'DESC')
                                                         ->limit(5)
                                                         ->findAll();

        return view('dashboard/admin', $data);
    }
}
