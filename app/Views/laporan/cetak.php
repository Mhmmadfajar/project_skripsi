<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Tinos:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-color: #f1f5f9;
            font-family: 'Tinos', 'Times New Roman', serif;
            color: #000000;
            padding: 20px 0;
            font-size: 14px;
        }

        .paper {
            background: #ffffff;
            width: 210mm;
            min-height: 297mm;
            padding: 20mm 20mm;
            margin: 0 auto;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .kop-surat {
            position: relative;
            min-height: 90px;
            padding-bottom: 6px;
            text-align: center;
        }

        .logo-desa {
            position: absolute;
            left: 5px;
            top: 50%;
            transform: translateY(-50%);
            width: 80px;
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-desa img {
            width: 78px;
            height: auto;
            max-height: 88px;
            object-fit: contain;
        }

        .kop-text {
            text-align: center;
            line-height: 1.25;
            padding: 0 85px;
        }

        .kop-text h4 { font-size: 16px; margin: 0; font-weight: bold; }
        .kop-text h3 { font-size: 18px; margin: 0; font-weight: bold; }
        .kop-text h2 { font-size: 20px; margin: 2px 0 0; font-weight: 800; }
        .kop-text p { font-size: 12px; margin: 4px 0 0; font-style: italic; }

        .garis-kop {
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 4px;
            margin: 8px 0 20px;
        }

        .judul-laporan {
            text-align: center;
            margin-bottom: 20px;
        }
        .judul-laporan h4 {
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
            margin: 0;
            text-transform: uppercase;
        }

        .table-cetak {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        .table-cetak th, .table-cetak td {
            border: 1px solid #000;
            padding: 5px 8px;
            font-size: 13px;
        }
        .table-cetak th {
            background-color: #f3f4f6;
            text-align: center;
            font-weight: bold;
        }

        .ttd-box {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
        }

        @media print {
            body { background: none; padding: 0; }
            .paper { box-shadow: none; padding: 15mm 15mm; width: 100%; }
            .print-bar { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="paper">
        <!-- Kop Surat -->
        <div class="kop-surat">
            <div class="logo-desa">
                <img src="<?= base_url('images/logo_kabupaten_bogor.png') ?>" alt="Lambang Kabupaten Bogor">
            </div>
            <div class="kop-text">
                <h4>PEMERINTAH KABUPATEN BOGOR</h4>
                <h3>KECAMATAN GUNUNG SINDUR</h3>
                <h2>PEMERINTAH DESA JAMPANG</h2>
                <p>Jl. Raya Jampang No. 01, Gunung Sindur, Kab. Bogor - Jawa Barat 16340 | Email: pemdes@jampang.desa.id</p>
            </div>
        </div>
        <div class="garis-kop"></div>

        <!-- Judul Laporan -->
        <?php
            $bulanIndo = [
                1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
            $tglSekarang = date('j') . ' ' . $bulanIndo[(int)date('n')] . ' ' . date('Y');
            $periodeSekarang = $bulanIndo[(int)date('n')] . ' ' . date('Y');
        ?>
        <div class="judul-laporan">
            <h4>LAPORAN REKAPITULASI KEPENDUDUKAN & PELAYANAN</h4>
            <div>Periode: Bulan <?= $periodeSekarang ?></div>
        </div>

        <!-- 1. Rekapitulasi Demografi Pokok -->
        <h6 class="fw-bold mb-2">I. DATA AGREGAT KEPENDUDUKAN</h6>
        <table class="table-cetak mb-4">
            <thead>
                <tr>
                    <th>Indikator Demografi</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Penduduk Terdaftar</td>
                    <td class="text-center fw-bold"><?= number_format($statistik['total']) ?></td>
                    <td class="text-center">Jiwa</td>
                    <td>Status Berdomisili Aktif</td>
                </tr>
                <tr>
                    <td>Jumlah Kepala Keluarga (KK)</td>
                    <td class="text-center fw-bold"><?= number_format($totalKk) ?></td>
                    <td class="text-center">KK</td>
                    <td>Terdata dalam buku register desa</td>
                </tr>
                <tr>
                    <td>Penduduk Laki-Laki</td>
                    <td class="text-center fw-bold"><?= number_format($statistik['laki']) ?></td>
                    <td class="text-center">Jiwa</td>
                    <td><?= $statistik['total'] > 0 ? round(($statistik['laki'] / $statistik['total']) * 100, 1) : 0 ?>% dari total</td>
                </tr>
                <tr>
                    <td>Penduduk Perempuan</td>
                    <td class="text-center fw-bold"><?= number_format($statistik['perempuan']) ?></td>
                    <td class="text-center">Jiwa</td>
                    <td><?= $statistik['total'] > 0 ? round(($statistik['perempuan'] / $statistik['total']) * 100, 1) : 0 ?>% dari total</td>
                </tr>
            </tbody>
        </table>

        <!-- 2. Kelompok Usia -->
        <h6 class="fw-bold mb-2">II. DISTRIBUSI KELOMPOK USIA</h6>
        <table class="table-cetak mb-4">
            <thead>
                <tr>
                    <th>Kelompok Usia</th>
                    <th>Rentang Usia</th>
                    <th>Jumlah (Jiwa)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Balita</td>
                    <td class="text-center">0 - 5 Tahun</td>
                    <td class="text-center fw-bold"><?= (int) ($statistik['usia']['balita'] ?? 0) ?></td>
                </tr>
                <tr>
                    <td>Anak-Anak</td>
                    <td class="text-center">6 - 17 Tahun</td>
                    <td class="text-center fw-bold"><?= (int) ($statistik['usia']['anak'] ?? 0) ?></td>
                </tr>
                <tr>
                    <td>Usia Produktif</td>
                    <td class="text-center">18 - 59 Tahun</td>
                    <td class="text-center fw-bold"><?= (int) ($statistik['usia']['produktif'] ?? 0) ?></td>
                </tr>
                <tr>
                    <td>Lanjut Usia (Lansia)</td>
                    <td class="text-center">&ge; 60 Tahun</td>
                    <td class="text-center fw-bold"><?= (int) ($statistik['usia']['lansia'] ?? 0) ?></td>
                </tr>
            </tbody>
        </table>

        <!-- 3. Rekapitulasi Pelayanan Surat -->
        <h6 class="fw-bold mb-2">III. REKAPITULASI PELAYANAN SURAT ADMINISTRASI</h6>
        <table class="table-cetak mb-4">
            <thead>
                <tr>
                    <th>Jenis Surat Keterangan / Pengantar</th>
                    <th>Kode</th>
                    <th>Total Permohonan</th>
                    <th>Disetujui & Tervalidasi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($suratPerJenis as $row): ?>
                    <tr>
                        <td><?= esc($row['nama_surat']) ?></td>
                        <td class="text-center"><?= esc($row['kode_surat']) ?></td>
                        <td class="text-center"><?= $row['total'] ?></td>
                        <td class="text-center fw-bold"><?= $row['disetujui'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Tanda Tangan -->
        <div class="ttd-box">
            <div style="width: 250px; text-align: center;">
                <div>Jampang, <?= $tglSekarang ?></div>
                <div class="fw-bold mb-5">Kepala Desa Jampang</div>
                <div class="fw-bold text-decoration-underline"><?= esc($kades['nama_lengkap'] ?? 'MAMAN SUHERMAN, S.Pd') ?></div>
                <div style="font-size: 11px;">NIP. 19780512 200604 1 008</div>
            </div>
        </div>
    </div>

    <!-- Print Control Bar -->
    <div class="print-bar text-center mt-3">
        <button onclick="window.print()" class="btn btn-success btn-sm px-4 fw-bold">
            <i class="bi bi-printer me-1"></i> Cetak Dokumen Rekapitulasi
        </button>
        <button onclick="window.close()" class="btn btn-secondary btn-sm px-3 ms-2">
            Tutup
        </button>
    </div>

</body>
</html>
