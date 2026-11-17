<?php

namespace App\Controllers;

use App\Models\MutasiModel;
use App\Models\PendudukModel;
use App\Models\KartuKeluargaModel;

class Mutasi extends BaseController
{
    protected $mutasiModel;
    protected $pendudukModel;
    protected $kkModel;

    public function __construct()
    {
        $this->mutasiModel = new MutasiModel();
        $this->pendudukModel = new PendudukModel();
        $this->kkModel = new KartuKeluargaModel();
    }

    public function index()
    {
        $jenis = $this->request->getGet('jenis');
        $bulan = $this->request->getGet('bulan');
        $tahun = $this->request->getGet('tahun');

        $mutasiList = $this->mutasiModel->getAllWithDetails($jenis, $bulan, $tahun);
        $statistik = $this->mutasiModel->getStatistikMutasi();

        return view('mutasi/index', [
            'title'      => 'Pencatatan Mutasi Kependudukan',
            'mutasiList' => $mutasiList,
            'statistik'  => $statistik,
            'jenis'      => $jenis,
            'bulan'      => $bulan,
            'tahun'      => $tahun
        ]);
    }

    public function create()
    {
        $pendudukList = $this->pendudukModel->where('status_penduduk', 'Ada')->orderBy('nama_lengkap', 'ASC')->findAll();
        $kkList = $this->kkModel->orderBy('no_kk', 'ASC')->findAll();

        return view('mutasi/create', [
            'title'        => 'Catat Mutasi Penduduk Baru',
            'pendudukList' => $pendudukList,
            'kkList'       => $kkList
        ]);
    }

    public function store()
    {
        $jenisMutasi   = $this->request->getPost('jenis_mutasi');
        $tanggalMutasi = $this->request->getPost('tanggal_mutasi');
        $keterangan    = $this->request->getPost('keterangan');
        $userId        = session()->get('id_user');

        if (empty($jenisMutasi) || empty($tanggalMutasi)) {
            return redirect()->back()->withInput()->with('error', 'Jenis mutasi dan tanggal mutasi wajib diisi.');
        }

        if ($jenisMutasi === 'Kelahiran') {
            // New born baby logic
            $nikBayi = trim($this->request->getPost('nik_bayi'));
            $namaBayi = trim($this->request->getPost('nama_bayi'));
            $noKk = trim($this->request->getPost('no_kk'));
            $jk = $this->request->getPost('jenis_kelamin');
            $tempatLahir = $this->request->getPost('tempat_lahir') ?: 'Bogor';

            if (empty($nikBayi) || empty($namaBayi) || empty($noKk)) {
                return redirect()->back()->withInput()->with('error', 'Untuk pencatatan kelahiran, NIK Bayi, Nama Bayi, dan Nomor KK orang tua wajib diisi.');
            }

            if ($this->pendudukModel->find($nikBayi)) {
                return redirect()->back()->withInput()->with('error', 'NIK Bayi ' . $nikBayi . ' sudah terdaftar.');
            }

            // Get KK address
            $kk = $this->kkModel->find($noKk);

            // Insert new resident
            $this->pendudukModel->insert([
                'nik'                 => $nikBayi,
                'no_kk'               => $noKk,
                'nama_lengkap'        => $namaBayi,
                'jenis_kelamin'       => $jk,
                'tempat_lahir'        => $tempatLahir,
                'tanggal_lahir'       => $tanggalMutasi,
                'agama'               => 'Islam',
                'status_perkawinan'   => 'Belum Menikah',
                'shdk'                => 'Anak',
                'pekerjaan'           => 'Belum/Tidak Bekerja',
                'pendidikan_terakhir' => 'TIDAK / BELUM SEKOLAH',
                'alamat'              => $kk['alamat'] ?? 'Desa Jampang',
                'rt'                  => $kk['rt'] ?? '001',
                'rw'                  => $kk['rw'] ?? '001',
                'desa_kelurahan'      => $kk['desa_kelurahan'] ?? 'Jampang',
                'kecamatan'           => $kk['kecamatan'] ?? 'Gunung Sindur',
                'status_penduduk'     => 'Ada',
            ]);

            // Insert mutation record
            $this->mutasiModel->insert([
                'nik'            => $nikBayi,
                'jenis_mutasi'   => 'Kelahiran',
                'tanggal_mutasi' => $tanggalMutasi,
                'keterangan'     => $keterangan ?: 'Kelahiran baru pada KK ' . $noKk,
                'created_by'     => $userId,
            ]);

            return redirect()->to(base_url('mutasi'))->with('success', 'Pencatatan kelahiran berhasil! Bayi (' . $namaBayi . ') telah ditambahkan ke data kependudukan.');

        } elseif ($jenisMutasi === 'Kematian') {
            $nik = $this->request->getPost('nik_terkait');
            if (empty($nik)) {
                return redirect()->back()->withInput()->with('error', 'Pilih warga yang bersangkutan.');
            }

            $warga = $this->pendudukModel->find($nik);
            if (!$warga) {
                return redirect()->back()->withInput()->with('error', 'Data warga tidak ditemukan.');
            }

            // Update status_penduduk to Meninggal
            $this->pendudukModel->update($nik, ['status_penduduk' => 'Meninggal']);

            // Insert mutation
            $this->mutasiModel->insert([
                'nik'            => $nik,
                'jenis_mutasi'   => 'Kematian',
                'tanggal_mutasi' => $tanggalMutasi,
                'keterangan'     => $keterangan ?: 'Meninggal dunia pada ' . $tanggalMutasi,
                'created_by'     => $userId,
            ]);

            return redirect()->to(base_url('mutasi'))->with('success', 'Pencatatan kematian warga (' . $warga['nama_lengkap'] . ') berhasil disimpan.');

        } elseif ($jenisMutasi === 'Pindah Keluar') {
            $nik = $this->request->getPost('nik_terkait');
            if (empty($nik)) {
                return redirect()->back()->withInput()->with('error', 'Pilih warga yang bersangkutan.');
            }

            $warga = $this->pendudukModel->find($nik);
            if (!$warga) {
                return redirect()->back()->withInput()->with('error', 'Data warga tidak ditemukan.');
            }

            // Update status_penduduk to Pindah
            $this->pendudukModel->update($nik, ['status_penduduk' => 'Pindah']);

            // Insert mutation
            $this->mutasiModel->insert([
                'nik'            => $nik,
                'jenis_mutasi'   => 'Pindah Keluar',
                'tanggal_mutasi' => $tanggalMutasi,
                'keterangan'     => $keterangan ?: 'Pindah keluar domisili',
                'created_by'     => $userId,
            ]);

            return redirect()->to(base_url('mutasi'))->with('success', 'Pencatatan pindah keluar warga (' . $warga['nama_lengkap'] . ') berhasil disimpan.');

        } elseif ($jenisMutasi === 'Pindah Masuk') {
            $nik = trim($this->request->getPost('nik_baru'));
            $nama = trim($this->request->getPost('nama_baru'));
            $noKk = trim($this->request->getPost('no_kk_tujuan'));

            if (empty($nik) || empty($nama) || empty($noKk)) {
                return redirect()->back()->withInput()->with('error', 'Untuk pindah masuk, NIK, Nama, dan KK Tujuan wajib diisi.');
            }

            $existing = $this->pendudukModel->find($nik);
            $kk = $this->kkModel->find($noKk);

            if ($existing) {
                // If previously moved out, update back to 'Ada'
                $this->pendudukModel->update($nik, [
                    'no_kk'           => $noKk,
                    'status_penduduk' => 'Ada',
                    'alamat'          => $kk['alamat'] ?? $existing['alamat'],
                    'rt'              => $kk['rt'] ?? $existing['rt'],
                    'rw'              => $kk['rw'] ?? $existing['rw'],
                ]);
            } else {
                // Insert as new resident
                $this->pendudukModel->insert([
                    'nik'                 => $nik,
                    'no_kk'               => $noKk,
                    'nama_lengkap'        => $nama,
                    'jenis_kelamin'       => $this->request->getPost('jenis_kelamin_baru') ?: 'L',
                    'tempat_lahir'        => $this->request->getPost('tempat_lahir_baru') ?: 'Luar Daerah',
                    'tanggal_lahir'       => $this->request->getPost('tanggal_lahir_baru') ?: '1995-01-01',
                    'agama'               => $this->request->getPost('agama_baru') ?: 'Islam',
                    'status_perkawinan'   => $this->request->getPost('status_perkawinan_baru') ?: 'Belum Menikah',
                    'shdk'                => $this->request->getPost('shdk_baru') ?: 'Famili Lain',
                    'pekerjaan'           => $this->request->getPost('pekerjaan_baru') ?: 'Karyawan Swasta',
                    'pendidikan_terakhir' => 'SLTA / SEDERAJAT',
                    'alamat'              => $kk['alamat'] ?? 'Desa Jampang',
                    'rt'                  => $kk['rt'] ?? '001',
                    'rw'                  => $kk['rw'] ?? '001',
                    'desa_kelurahan'      => $kk['desa_kelurahan'] ?? 'Jampang',
                    'kecamatan'           => $kk['kecamatan'] ?? 'Gunung Sindur',
                    'status_penduduk'     => 'Ada',
                ]);
            }

            // Insert mutation record
            $this->mutasiModel->insert([
                'nik'            => $nik,
                'jenis_mutasi'   => 'Pindah Masuk',
                'tanggal_mutasi' => $tanggalMutasi,
                'keterangan'     => $keterangan ?: 'Pindah masuk dari luar wilayah',
                'created_by'     => $userId,
            ]);

            return redirect()->to(base_url('mutasi'))->with('success', 'Pencatatan pindah masuk warga (' . $nama . ') berhasil disimpan.');
        }

        return redirect()->to(base_url('mutasi'));
    }

    public function delete(int $id)
    {
        $this->mutasiModel->delete($id);
        return redirect()->to(base_url('mutasi'))->with('success', 'Catatan mutasi berhasil dihapus.');
    }
}
