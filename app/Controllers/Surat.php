<?php

namespace App\Controllers;

use App\Models\SuratModel;
use App\Models\JenisSuratModel;
use App\Models\PendudukModel;

class Surat extends BaseController
{
    protected $suratModel;
    protected $jenisSuratModel;
    protected $pendudukModel;

    public function __construct()
    {
        $this->suratModel = new SuratModel();
        $this->jenisSuratModel = new JenisSuratModel();
        $this->pendudukModel = new PendudukModel();
    }

    public function index()
    {
        $role = session()->get('role');
        $userNik = session()->get('nik');

        $status = $this->request->getGet('status') ?: 'Semua';
        $search = $this->request->getGet('search');

        // If citizen, only show their own letters
        $filterNik = ($role === 'warga') ? $userNik : null;

        $pengajuan = $this->suratModel->getAllWithDetails($status, $search, $filterNik);
        $statistik = $this->suratModel->getStatistikSurat();

        return view('surat/index', [
            'title'     => 'Layanan Permohonan Surat',
            'pengajuan' => $pengajuan,
            'statistik' => $statistik,
            'status'    => $status,
            'search'    => $search,
            'role'      => $role
        ]);
    }

    public function detail(int $id)
    {
        $surat = $this->suratModel->getWithDetails($id);
        if (!$surat) {
            return redirect()->to(base_url('surat'))->with('error', 'Data pengajuan surat tidak ditemukan.');
        }

        $role = session()->get('role');
        $userNik = session()->get('nik');

        // Security check for citizen: can only see their own letter
        if ($role === 'warga' && $surat['nik_pemohon'] !== $userNik) {
            return redirect()->to(base_url('surat'))->with('error', 'Anda tidak memiliki hak akses untuk surat ini.');
        }

        return view('surat/detail', [
            'title' => 'Detail Pengajuan Surat #' . $surat['id_pengajuan'],
            'surat' => $surat,
            'role'  => $role
        ]);
    }

    public function create()
    {
        $role = session()->get('role');
        $userNik = session()->get('nik');

        $jenisSurat = $this->jenisSuratModel->getActive();
        $pendudukList = [];

        if ($role !== 'warga') {
            $pendudukList = $this->pendudukModel->where('status_penduduk', 'Ada')
                                                ->orderBy('nama_lengkap', 'ASC')
                                                ->findAll();
        } else {
            $pendudukList = $this->pendudukModel->where('nik', $userNik)->findAll();
        }

        return view('surat/create', [
            'title'        => 'Buat Pengajuan Surat Baru',
            'jenisSurat'   => $jenisSurat,
            'pendudukList' => $pendudukList,
            'role'         => $role,
            'userNik'      => $userNik
        ]);
    }

    public function store()
    {
        $role = session()->get('role');
        $userNik = session()->get('nik');

        $idJenisSurat = (int) $this->request->getPost('id_jenis_surat');
        $nikPemohon   = ($role === 'warga') ? $userNik : trim($this->request->getPost('nik_pemohon'));
        $keperluan    = trim($this->request->getPost('keperluan'));

        if (empty($idJenisSurat) || empty($nikPemohon) || empty($keperluan)) {
            return redirect()->back()->withInput()->with('error', 'Semua kolom formulir wajib diisi.');
        }

        $warga = $this->pendudukModel->find($nikPemohon);
        if (!$warga) {
            return redirect()->back()->withInput()->with('error', 'Data pemohon (NIK ' . $nikPemohon . ') tidak ditemukan di basis data penduduk.');
        }

        $jenis = $this->jenisSuratModel->find($idJenisSurat);
        if (!$jenis) {
            return redirect()->back()->withInput()->with('error', 'Jenis surat tidak valid.');
        }

        $data = [
            'id_jenis_surat'    => $idJenisSurat,
            'nik_pemohon'       => $nikPemohon,
            'nik'               => $nikPemohon,
            'jenis_surat'       => $jenis['kode_surat'],
            'keperluan'         => $keperluan,
            'status'            => 'Pending',
            'tanggal_pengajuan' => date('Y-m-d H:i:s'),
        ];

        $this->suratModel->insert($data);

        return redirect()->to(base_url('surat'))->with('success', 'Permohonan ' . $jenis['nama_surat'] . ' berhasil diajukan dan sedang menunggu verifikasi.');
    }

    public function proses(int $id)
    {
        $surat = $this->suratModel->find($id);
        if (!$surat) {
            return redirect()->to(base_url('surat'))->with('error', 'Data tidak ditemukan.');
        }

        $this->suratModel->update($id, [
            'status' => 'Proses'
        ]);

        return redirect()->to(base_url('surat/detail/' . $id))->with('success', 'Status surat telah diubah menjadi: Sedang Diproses.');
    }

    public function approve(int $id)
    {
        $surat = $this->suratModel->find($id);
        if (!$surat) {
            return redirect()->to(base_url('surat'))->with('error', 'Data tidak ditemukan.');
        }

        $noSurat = trim($this->request->getPost('no_surat'));
        if (empty($noSurat)) {
            $noSurat = $this->suratModel->generateNoSurat($surat['id_jenis_surat']);
        }

        // Generate unique QR code verification token
        $qrToken = 'VERIFIED-DESA-JAMPANG-' . $id . '-' . time() . '-' . strtoupper(bin2hex(random_bytes(3)));

        $this->suratModel->update($id, [
            'status'              => 'Disetujui',
            'no_surat'            => $noSurat,
            'qr_code'             => $qrToken,
            'disetujui_oleh'      => session()->get('id_user'),
            'tanggal_persetujuan' => date('Y-m-d H:i:s'),
            'tgl_disetujui'       => date('Y-m-d H:i:s'),
            'catatan_revisi'      => null
        ]);

        return redirect()->to(base_url('surat/detail/' . $id))->with('success', 'Surat berhasil disetujui oleh Kepala Desa dengan Nomor: ' . $noSurat . ' dan QR Code terbit!');
    }

    public function reject(int $id)
    {
        $surat = $this->suratModel->find($id);
        if (!$surat) {
            return redirect()->to(base_url('surat'))->with('error', 'Data tidak ditemukan.');
        }

        $catatan = trim($this->request->getPost('catatan_revisi'));
        if (empty($catatan)) {
            $catatan = 'Persyaratan berkas belum lengkap atau data belum valid.';
        }

        $this->suratModel->update($id, [
            'status'         => 'Ditolak',
            'catatan_revisi' => $catatan
        ]);

        return redirect()->to(base_url('surat/detail/' . $id))->with('info', 'Permohonan surat telah ditolak dengan catatan: ' . $catatan);
    }

    public function cetak(int $id)
    {
        $surat = $this->suratModel->getWithDetails($id);
        if (!$surat) {
            return redirect()->to(base_url('surat'))->with('error', 'Data surat tidak ditemukan.');
        }

        if ($surat['status'] !== 'Disetujui') {
            return redirect()->to(base_url('surat/detail/' . $id))->with('error', 'Surat belum dapat dicetak karena statusnya belum Disetujui.');
        }

        // If qr_code is empty (e.g. from existing test row), generate one
        if (empty($surat['qr_code'])) {
            $surat['qr_code'] = 'VERIFIED-DESA-JAMPANG-' . $id . '-' . time() . '-LEGACY';
            $this->suratModel->update($id, ['qr_code' => $surat['qr_code']]);
        }

        $verificationUrl = base_url('verifikasi/surat/' . $surat['qr_code']);

        return view('surat/cetak', [
            'title'           => 'Cetak Surat ' . $surat['nama_surat'] . ' - ' . $surat['nama_pemohon'],
            'surat'           => $surat,
            'verificationUrl' => $verificationUrl
        ]);
    }

    /**
     * Public letter tracking without login
     */
    public function lacak()
    {
        $keyword = trim($this->request->getVar('keyword') ?? '');
        $results = [];

        if (!empty($keyword)) {
            $builder = $this->suratModel->select('pengajuan_surat.*, penduduk.nama_lengkap as nama_pemohon, jenis_surat.nama_surat, jenis_surat.kode_surat')
                                        ->join('penduduk', 'penduduk.nik = pengajuan_surat.nik_pemohon', 'left')
                                        ->join('jenis_surat', 'jenis_surat.id_jenis_surat = pengajuan_surat.id_jenis_surat', 'left')
                                        ->groupStart()
                                        ->where('pengajuan_surat.nik_pemohon', $keyword)
                                        ->orLike('pengajuan_surat.no_surat', $keyword)
                                        ->orWhere('pengajuan_surat.id_pengajuan', $keyword)
                                        ->groupEnd();
            $results = $builder->orderBy('pengajuan_surat.tanggal_pengajuan', 'DESC')->get()->getResultArray();
        }

        return view('surat/lacak', [
            'title'   => 'Lacak Status Permohonan Surat Desa',
            'keyword' => $keyword,
            'results' => $results
        ]);
    }
}
