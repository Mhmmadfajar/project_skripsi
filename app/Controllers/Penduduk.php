<?php

namespace App\Controllers;

use App\Models\PendudukModel;
use App\Models\KartuKeluargaModel;
use App\Models\MutasiModel;
use App\Models\SuratModel;

class Penduduk extends BaseController
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
        $search = $this->request->getGet('search');
        $rt     = $this->request->getGet('rt');
        $rw     = $this->request->getGet('rw');
        $jk     = $this->request->getGet('jk');
        $status = $this->request->getGet('status');

        $penduduk = $this->pendudukModel->filterPenduduk($search, $rt, $rw, $jk, $status);

        // Get unique RT list for filter dropdown
        $db = \Config\Database::connect();
        $rtList = $db->table('penduduk')->select('rt')->distinct()->where('rt !=', '')->orderBy('rt', 'ASC')->get()->getResultArray();

        return view('penduduk/index', [
            'title'    => 'Data Kependudukan',
            'penduduk' => $penduduk,
            'search'   => $search,
            'rt'       => $rt,
            'rw'       => $rw,
            'jk'       => $jk,
            'status'   => $status,
            'rtList'   => array_column($rtList, 'rt')
        ]);
    }

    public function detail(string $nik)
    {
        $penduduk = $this->pendudukModel->getWithKK($nik);
        if (!$penduduk) {
            return redirect()->to(base_url('penduduk'))->with('error', 'Data penduduk tidak ditemukan.');
        }

        $mutasi = $this->mutasiModel->where('nik', $nik)->orderBy('tanggal_mutasi', 'DESC')->findAll();
        $surat  = $this->suratModel->getAllWithDetails(null, null, $nik);

        return view('penduduk/detail', [
            'title'    => 'Detail Penduduk - ' . $penduduk['nama_lengkap'],
            'penduduk' => $penduduk,
            'mutasi'   => $mutasi,
            'surat'    => $surat
        ]);
    }

    public function create()
    {
        $kkList = $this->kkModel->orderBy('no_kk', 'ASC')->findAll();

        return view('penduduk/create', [
            'title'  => 'Tambah Data Penduduk',
            'kkList' => $kkList
        ]);
    }

    public function store()
    {
        $nik = trim($this->request->getPost('nik'));
        $noKk = trim($this->request->getPost('no_kk'));
        $nama = trim($this->request->getPost('nama_lengkap'));

        if (empty($nik) || empty($noKk) || empty($nama)) {
            return redirect()->back()->withInput()->with('error', 'NIK, Nomor KK, dan Nama Lengkap wajib diisi.');
        }

        if (strlen($nik) !== 16 || !is_numeric($nik)) {
            return redirect()->back()->withInput()->with('error', 'NIK harus 16 digit angka.');
        }

        if ($this->pendudukModel->find($nik)) {
            return redirect()->back()->withInput()->with('error', 'NIK ' . $nik . ' sudah terdaftar dalam sistem.');
        }

        // Check if KK exists, if not create automatically
        if (!$this->kkModel->find($noKk)) {
            $this->kkModel->insert([
                'no_kk'          => $noKk,
                'alamat'         => $this->request->getPost('alamat') ?: 'Desa Jampang',
                'rt'             => $this->request->getPost('rt') ?: '001',
                'rw'             => $this->request->getPost('rw') ?: '001',
                'desa_kelurahan' => $this->request->getPost('desa_kelurahan') ?: 'Jampang',
                'kecamatan'      => $this->request->getPost('kecamatan') ?: 'Gunung Sindur',
                'kabupaten'      => 'Bogor',
                'provinsi'       => 'Jawa Barat',
            ]);
        }

        $data = [
            'nik'                 => $nik,
            'no_kk'               => $noKk,
            'nama_lengkap'        => $nama,
            'jenis_kelamin'       => $this->request->getPost('jenis_kelamin'),
            'alamat'              => $this->request->getPost('alamat'),
            'rt'                  => $this->request->getPost('rt'),
            'rw'                  => $this->request->getPost('rw'),
            'desa_kelurahan'      => $this->request->getPost('desa_kelurahan') ?: 'Jampang',
            'kecamatan'           => $this->request->getPost('kecamatan') ?: 'Gunung Sindur',
            'tempat_lahir'        => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir'       => $this->request->getPost('tanggal_lahir'),
            'agama'               => $this->request->getPost('agama'),
            'status_perkawinan'   => $this->request->getPost('status_perkawinan'),
            'shdk'                => $this->request->getPost('shdk'),
            'pekerjaan'           => $this->request->getPost('pekerjaan'),
            'pendidikan_terakhir' => $this->request->getPost('pendidikan_terakhir'),
            'golongan_darah'      => $this->request->getPost('golongan_darah') ?: '-',
            'kewarganegaraan'     => $this->request->getPost('kewarganegaraan') ?: 'WNI',
            'status_penduduk'     => $this->request->getPost('status_penduduk') ?: 'Ada',
        ];

        $this->pendudukModel->insert($data);

        // Update KK head if SHDK is Kepala Keluarga
        if ($data['shdk'] === 'Kepala Keluarga') {
            $this->kkModel->update($noKk, ['nik_kepala_keluarga' => $nik]);
        }

        return redirect()->to(base_url('penduduk'))->with('success', 'Data warga ' . $nama . ' berhasil ditambahkan.');
    }

    public function edit(string $nik)
    {
        $penduduk = $this->pendudukModel->find($nik);
        if (!$penduduk) {
            return redirect()->to(base_url('penduduk'))->with('error', 'Data penduduk tidak ditemukan.');
        }

        $kkList = $this->kkModel->orderBy('no_kk', 'ASC')->findAll();

        return view('penduduk/edit', [
            'title'    => 'Edit Data Penduduk - ' . $penduduk['nama_lengkap'],
            'penduduk' => $penduduk,
            'kkList'   => $kkList
        ]);
    }

    public function update(string $nik)
    {
        $penduduk = $this->pendudukModel->find($nik);
        if (!$penduduk) {
            return redirect()->to(base_url('penduduk'))->with('error', 'Data tidak ditemukan.');
        }

        $nama = trim($this->request->getPost('nama_lengkap'));
        $data = [
            'no_kk'               => trim($this->request->getPost('no_kk')),
            'nama_lengkap'        => $nama,
            'jenis_kelamin'       => $this->request->getPost('jenis_kelamin'),
            'alamat'              => $this->request->getPost('alamat'),
            'rt'                  => $this->request->getPost('rt'),
            'rw'                  => $this->request->getPost('rw'),
            'desa_kelurahan'      => $this->request->getPost('desa_kelurahan'),
            'kecamatan'           => $this->request->getPost('kecamatan'),
            'tempat_lahir'        => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir'       => $this->request->getPost('tanggal_lahir'),
            'agama'               => $this->request->getPost('agama'),
            'status_perkawinan'   => $this->request->getPost('status_perkawinan'),
            'shdk'                => $this->request->getPost('shdk'),
            'pekerjaan'           => $this->request->getPost('pekerjaan'),
            'pendidikan_terakhir' => $this->request->getPost('pendidikan_terakhir'),
            'golongan_darah'      => $this->request->getPost('golongan_darah') ?: '-',
            'kewarganegaraan'     => $this->request->getPost('kewarganegaraan') ?: 'WNI',
            'status_penduduk'     => $this->request->getPost('status_penduduk'),
        ];

        $this->pendudukModel->update($nik, $data);

        if ($data['shdk'] === 'Kepala Keluarga') {
            $this->kkModel->update($data['no_kk'], ['nik_kepala_keluarga' => $nik]);
        }

        return redirect()->to(base_url('penduduk/detail/' . $nik))->with('success', 'Data ' . $nama . ' berhasil diperbarui.');
    }

    public function delete(string $nik)
    {
        $penduduk = $this->pendudukModel->find($nik);
        if (!$penduduk) {
            return redirect()->to(base_url('penduduk'))->with('error', 'Data tidak ditemukan.');
        }

        $this->pendudukModel->delete($nik);
        return redirect()->to(base_url('penduduk'))->with('success', 'Data penduduk berhasil dihapus.');
    }

    public function export()
    {
        $data = $this->pendudukModel->orderBy('nama_lengkap', 'ASC')->findAll();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=rekap_penduduk_desa_' . date('Ymd_His') . '.csv');

        $output = fopen('php://output', 'w');
        // Add BOM for Excel UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        fputcsv($output, [
            'NIK', 'No KK', 'Nama Lengkap', 'Jenis Kelamin', 'Tempat Lahir', 
            'Tanggal Lahir', 'Agama', 'Status Perkawinan', 'SHDK', 'Pendidikan', 
            'Pekerjaan', 'Alamat', 'RT', 'RW', 'Status Penduduk'
        ]);

        foreach ($data as $row) {
            fputcsv($output, [
                "'" . $row['nik'],
                "'" . $row['no_kk'],
                $row['nama_lengkap'],
                $row['jenis_kelamin'] === 'L' ? 'Laki-Laki' : 'Perempuan',
                $row['tempat_lahir'],
                $row['tanggal_lahir'],
                $row['agama'],
                $row['status_perkawinan'],
                $row['shdk'],
                $row['pendidikan_terakhir'],
                $row['pekerjaan'],
                $row['alamat'],
                $row['rt'],
                $row['rw'],
                $row['status_penduduk']
            ]);
        }
        fclose($output);
        exit;
    }

    /**
     * Download format template Excel / CSV
     */
    public function downloadTemplate()
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=template_import_penduduk.csv');

        $output = fopen('php://output', 'w');
        // Add BOM for Microsoft Excel UTF-8 compatibility
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        // Header row
        fputcsv($output, [
            'NIK',
            'No_KK',
            'Nama_Lengkap',
            'Jenis_Kelamin',
            'Tempat_Lahir',
            'Tanggal_Lahir',
            'Agama',
            'Status_Perkawinan',
            'SHDK',
            'Pendidikan',
            'Pekerjaan',
            'Alamat',
            'RT',
            'RW'
        ]);

        // Sample data rows for guidance
        fputcsv($output, [
            '3201123456780020',
            '3201123456780020',
            'Rahmat Hidayat',
            'L',
            'Bogor',
            '1985-04-12',
            'Islam',
            'Menikah',
            'Kepala Keluarga',
            'SLTA / SEDERAJAT',
            'Wiraswasta',
            'Jl. Melati No. 45',
            '001',
            '002'
        ]);

        fputcsv($output, [
            '3201123456780021',
            '3201123456780020',
            'Nurul Aini',
            'P',
            'Bogor',
            '1988-09-23',
            'Islam',
            'Menikah',
            'Istri',
            'SLTA / SEDERAJAT',
            'Ibu Rumah Tangga',
            'Jl. Melati No. 45',
            '001',
            '002'
        ]);

        fclose($output);
        exit;
    }

    /**
     * Bulk import residents from Excel / CSV file
     */
    public function import()
    {
        $file = $this->request->getFile('file_excel');

        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Silakan pilih file CSV/Excel yang valid untuk diunggah.');
        }

        $extension = strtolower($file->getClientExtension());
        if (!in_array($extension, ['csv', 'txt'])) {
            return redirect()->back()->with('error', 'Format file tidak didukung. Mohon gunakan file template berformat .csv');
        }

        $filePath = $file->getTempName();
        $handle = fopen($filePath, 'r');
        if (!$handle) {
            return redirect()->back()->with('error', 'Gagal membuka file yang diunggah.');
        }

        // Read first line to detect delimiter (comma or semicolon)
        $firstLine = fgets($handle);
        rewind($handle);
        $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';

        $totalInserted = 0;
        $totalUpdated  = 0;
        $totalSkipped  = 0;
        $newKKCount    = 0;
        $rowNumber     = 0;

        while (($row = fgetcsv($handle, 2000, $delimiter)) !== false) {
            $rowNumber++;
            // Skip header row
            if ($rowNumber === 1) {
                continue;
            }

            // Sanitize values
            $cleanRow = array_map(function($val) {
                // Strip BOM, quotes, apostrophes
                $val = trim($val);
                $val = ltrim($val, "'`\xEF\xBB\xBF");
                return trim($val);
            }, $row);

            $nik         = $cleanRow[0] ?? '';
            $noKk        = $cleanRow[1] ?? '';
            $namaLengkap = $cleanRow[2] ?? '';
            $jk          = strtoupper($cleanRow[3] ?? 'L');
            $tempatLahir = $cleanRow[4] ?? 'Bogor';
            $tglLahir    = $cleanRow[5] ?? '1990-01-01';
            $agama       = $cleanRow[6] ?? 'Islam';
            $statusKawin = $cleanRow[7] ?? 'Belum Menikah';
            $shdk        = $cleanRow[8] ?? 'Anggota';
            $pendidikan  = $cleanRow[9] ?? 'SLTA / SEDERAJAT';
            $pekerjaan   = $cleanRow[10] ?? 'Wiraswasta';
            $alamat      = $cleanRow[11] ?? 'Desa Jampang';
            $rt          = $cleanRow[12] ?? '001';
            $rw          = $cleanRow[13] ?? '001';

            // Validate NIK
            if (empty($nik) || empty($namaLengkap)) {
                $totalSkipped++;
                continue;
            }

            // Ensure KK exists
            if (!empty($noKk) && !$this->kkModel->find($noKk)) {
                $this->kkModel->insert([
                    'no_kk'          => $noKk,
                    'alamat'         => $alamat,
                    'rt'             => $rt,
                    'rw'             => $rw,
                    'desa_kelurahan' => 'Jampang',
                    'kecamatan'      => 'Gunung Sindur',
                    'kabupaten'      => 'Bogor',
                    'provinsi'       => 'Jawa Barat',
                    'kode_pos'       => '16340',
                ]);
                $newKKCount++;
            }

            $residentData = [
                'nik'                 => $nik,
                'no_kk'               => $noKk ?: $nik,
                'nama_lengkap'        => $namaLengkap,
                'jenis_kelamin'       => ($jk === 'P') ? 'P' : 'L',
                'tempat_lahir'        => $tempatLahir,
                'tanggal_lahir'       => $tglLahir,
                'agama'               => $agama,
                'status_perkawinan'   => $statusKawin,
                'shdk'                => $shdk,
                'pekerjaan'           => $pekerjaan,
                'pendidikan_terakhir' => $pendidikan,
                'alamat'              => $alamat,
                'rt'                  => $rt,
                'rw'                  => $rw,
                'status_penduduk'     => 'Ada',
            ];

            if ($this->pendudukModel->find($nik)) {
                // Update existing resident
                $this->pendudukModel->update($nik, $residentData);
                $totalUpdated++;
            } else {
                // Insert new resident
                $this->pendudukModel->insert($residentData);
                $totalInserted++;
            }

            // If Kepala Keluarga, update KK head
            if ($shdk === 'Kepala Keluarga' && !empty($noKk)) {
                $this->kkModel->update($noKk, ['nik_kepala_keluarga' => $nik]);
            }
        }

        fclose($handle);

        $msg = "Proses impor selesai! Berhasil menambahkan $totalInserted warga baru, memperbarui $totalUpdated data, dan membuat $newKKCount Kartu Keluarga baru.";
        if ($totalSkipped > 0) {
            $msg .= " ($totalSkipped baris dilewati karena data NIK/Nama tidak lengkap).";
        }

        return redirect()->to(base_url('penduduk'))->with('success', $msg);
    }
}


