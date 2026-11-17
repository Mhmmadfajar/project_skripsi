<?php

namespace App\Controllers;

use App\Models\KartuKeluargaModel;
use App\Models\PendudukModel;

class KartuKeluarga extends BaseController
{
    protected $kkModel;
    protected $pendudukModel;

    public function __construct()
    {
        $this->kkModel = new KartuKeluargaModel();
        $this->pendudukModel = new PendudukModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        $rt     = $this->request->getGet('rt');

        $dataKK = $this->kkModel->getAllWithDetails($search, $rt);

        // Get unique RT list for filter
        $db = \Config\Database::connect();
        $rtList = $db->table('kartu_keluarga')->select('rt')->distinct()->where('rt !=', '')->orderBy('rt', 'ASC')->get()->getResultArray();

        return view('kartu_keluarga/index', [
            'title'  => 'Data Kartu Keluarga (KK)',
            'dataKK' => $dataKK,
            'search' => $search,
            'rt'     => $rt,
            'rtList' => array_column($rtList, 'rt')
        ]);
    }

    public function detail(string $no_kk)
    {
        $kk = $this->kkModel->getWithKepala($no_kk);
        if (!$kk) {
            return redirect()->to(base_url('kartu-keluarga'))->with('error', 'Data Kartu Keluarga tidak ditemukan.');
        }

        $anggota = $this->kkModel->getAnggota($no_kk);

        return view('kartu_keluarga/detail', [
            'title'   => 'Detail KK No. ' . $kk['no_kk'],
            'kk'      => $kk,
            'anggota' => $anggota
        ]);
    }

    public function create()
    {
        return view('kartu_keluarga/create', [
            'title' => 'Tambah Kartu Keluarga Baru'
        ]);
    }

    public function store()
    {
        $noKk = trim($this->request->getPost('no_kk'));
        if (empty($noKk)) {
            return redirect()->back()->withInput()->with('error', 'Nomor KK wajib diisi.');
        }

        if (strlen($noKk) !== 16 || !is_numeric($noKk)) {
            return redirect()->back()->withInput()->with('error', 'Nomor KK harus 16 digit angka.');
        }

        if ($this->kkModel->find($noKk)) {
            return redirect()->back()->withInput()->with('error', 'Nomor KK ' . $noKk . ' sudah terdaftar.');
        }

        $data = [
            'no_kk'          => $noKk,
            'alamat'         => $this->request->getPost('alamat'),
            'rt'             => $this->request->getPost('rt'),
            'rw'             => $this->request->getPost('rw'),
            'desa_kelurahan' => $this->request->getPost('desa_kelurahan') ?: 'Jampang',
            'kecamatan'      => $this->request->getPost('kecamatan') ?: 'Gunung Sindur',
            'kabupaten'      => $this->request->getPost('kabupaten') ?: 'Bogor',
            'provinsi'       => $this->request->getPost('provinsi') ?: 'Jawa Barat',
            'kode_pos'       => $this->request->getPost('kode_pos') ?: '16340',
        ];

        $this->kkModel->insert($data);

        return redirect()->to(base_url('kartu-keluarga/detail/' . $noKk))->with('success', 'Kartu Keluarga baru berhasil dibuat. Anda dapat menambahkan anggota keluarga sekarang.');
    }

    public function edit(string $no_kk)
    {
        $kk = $this->kkModel->find($no_kk);
        if (!$kk) {
            return redirect()->to(base_url('kartu-keluarga'))->with('error', 'Data tidak ditemukan.');
        }

        $anggota = $this->kkModel->getAnggota($no_kk);

        return view('kartu_keluarga/edit', [
            'title'   => 'Edit Kartu Keluarga - ' . $no_kk,
            'kk'      => $kk,
            'anggota' => $anggota
        ]);
    }

    public function update(string $no_kk)
    {
        $kk = $this->kkModel->find($no_kk);
        if (!$kk) {
            return redirect()->to(base_url('kartu-keluarga'))->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'nik_kepala_keluarga' => $this->request->getPost('nik_kepala_keluarga') ?: null,
            'alamat'              => $this->request->getPost('alamat'),
            'rt'                  => $this->request->getPost('rt'),
            'rw'                  => $this->request->getPost('rw'),
            'desa_kelurahan'      => $this->request->getPost('desa_kelurahan'),
            'kecamatan'           => $this->request->getPost('kecamatan'),
            'kabupaten'           => $this->request->getPost('kabupaten'),
            'provinsi'            => $this->request->getPost('provinsi'),
            'kode_pos'            => $this->request->getPost('kode_pos'),
        ];

        $this->kkModel->update($no_kk, $data);

        return redirect()->to(base_url('kartu-keluarga/detail/' . $noKk))->with('success', 'Data Kartu Keluarga berhasil diperbarui.');
    }

    public function delete(string $no_kk)
    {
        $kk = $this->kkModel->find($no_kk);
        if (!$kk) {
            return redirect()->to(base_url('kartu-keluarga'))->with('error', 'Data tidak ditemukan.');
        }

        // Check if there are active residents in this KK
        $members = $this->pendudukModel->where('no_kk', $no_kk)->where('status_penduduk', 'Ada')->countAllResults();
        if ($members > 0) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus KK yang masih memiliki anggota keluarga aktif (' . $members . ' jiwa). Pindahkan anggota keluarga terlebih dahulu.');
        }

        $this->kkModel->delete($no_kk);
        return redirect()->to(base_url('kartu-keluarga'))->with('success', 'Data Kartu Keluarga berhasil dihapus.');
    }

    public function cetak(string $no_kk)
    {
        $kk = $this->kkModel->getWithKepala($no_kk);
        if (!$kk) {
            return redirect()->to(base_url('kartu-keluarga'))->with('error', 'Data Kartu Keluarga tidak ditemukan.');
        }

        $anggota = $this->kkModel->getAnggota($no_kk);
        $db = \Config\Database::connect();
        $kades = $db->table('users')->where('role', 'kades')->get()->getRowArray();

        return view('kartu_keluarga/cetak', [
            'title'   => 'Cetak Kartu Keluarga No. ' . $kk['no_kk'],
            'kk'      => $kk,
            'anggota' => $anggota,
            'kades'   => $kades
        ]);
    }
}
