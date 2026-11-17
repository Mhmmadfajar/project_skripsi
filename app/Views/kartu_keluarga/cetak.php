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
            font-size: 11px;
        }

        /* Landscape A4 Paper */
        .paper-landscape {
            background: #ffffff;
            width: 297mm;
            min-height: 210mm;
            padding: 12mm 15mm;
            margin: 0 auto;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            position: relative;
            box-sizing: border-box;
        }

        .header-kk {
            text-align: center;
            margin-bottom: 12px;
        }

        .garuda-emblem {
            width: 55px;
            height: 55px;
            margin-bottom: 4px;
        }

        .header-kk h2 {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 0.15em;
            margin: 0;
            text-transform: uppercase;
        }

        .header-kk .no-kk-title {
            font-size: 16px;
            font-weight: bold;
            font-family: monospace;
            margin-top: 2px;
        }

        /* Metadata Header Grid */
        .table-meta {
            width: 100%;
            margin-bottom: 10px;
            font-size: 11px;
        }

        .table-meta td {
            padding: 2px 4px;
            vertical-align: top;
        }

        /* Data Tables */
        .table-kk {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            font-size: 10.5px;
        }

        .table-kk th, .table-kk td {
            border: 1px solid #000000;
            padding: 4px 5px;
            vertical-align: middle;
        }

        .table-kk th {
            background-color: #f3f4f6;
            text-align: center;
            font-weight: bold;
            font-size: 10px;
        }

        .ttd-container {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding: 0 40px;
            font-size: 11px;
        }

        .ttd-box {
            text-align: center;
            width: 220px;
        }

        @media print {
            @page {
                size: A4 landscape;
                margin: 5mm;
            }
            body {
                background: none;
                padding: 0;
            }
            .paper-landscape {
                box-shadow: none;
                padding: 5mm;
                width: 100%;
            }
            .print-bar {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="paper-landscape">
        <!-- Header KK -->
        <div class="header-kk">
            <!-- Garuda Emblem SVG -->
            <svg class="garuda-emblem" viewBox="0 0 100 100">
                <circle cx="50" cy="50" r="45" fill="#ca8a04" stroke="#854d0e" stroke-width="2"/>
                <polygon points="50,15 63,38 88,40 68,57 74,82 50,68 26,82 32,57 12,40 37,38" fill="#fef08a"/>
                <rect x="42" y="42" width="16" height="16" fill="#dc2626"/>
            </svg>
            <h2>KARTU KELUARGA</h2>
            <div class="no-kk-title">No. <?= esc($kk['no_kk']) ?></div>
        </div>

        <!-- Meta Info 2 Columns -->
        <table class="table-meta">
            <tr>
                <td style="width: 180px;">Nama Kepala Keluarga</td>
                <td style="width: 10px;">:</td>
                <td style="width: 35%; font-weight: bold;"><?= esc($kk['nama_kepala_keluarga'] ?: '-') ?></td>

                <td style="width: 160px;">Kecamatan</td>
                <td style="width: 10px;">:</td>
                <td><?= esc($kk['kecamatan']) ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?= esc($kk['alamat']) ?></td>

                <td>Kabupaten/Kota</td>
                <td>:</td>
                <td><?= esc($kk['kabupaten']) ?></td>
            </tr>
            <tr>
                <td>RT / RW</td>
                <td>:</td>
                <td><?= esc($kk['rt']) ?> / <?= esc($kk['rw']) ?></td>

                <td>Kode Pos</td>
                <td>:</td>
                <td><?= esc($kk['kode_pos'] ?: '16340') ?></td>
            </tr>
            <tr>
                <td>Desa / Kelurahan</td>
                <td>:</td>
                <td><?= esc($kk['desa_kelurahan']) ?></td>

                <td>Provinsi</td>
                <td>:</td>
                <td><?= esc($kk['provinsi']) ?></td>
            </tr>
        </table>

        <!-- Table I: Personal Biodata -->
        <table class="table-kk">
            <thead>
                <tr>
                    <th style="width: 25px;">No</th>
                    <th>Nama Lengkap</th>
                    <th style="width: 140px;">NIK</th>
                    <th style="width: 35px;">JK</th>
                    <th>Tempat Lahir</th>
                    <th style="width: 85px;">Tanggal Lahir</th>
                    <th>Agama</th>
                    <th>Pendidikan</th>
                    <th>Jenis Pekerjaan</th>
                    <th style="width: 35px;">Gol.</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($anggota)): ?>
                    <tr>
                        <td colspan="10" class="text-center py-2 text-muted">Belum ada anggota keluarga terdaftar.</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($anggota as $a): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="fw-bold"><?= esc($a['nama_lengkap']) ?></td>
                            <td class="text-center font-monospace"><?= esc($a['nik']) ?></td>
                            <td class="text-center"><?= $a['jenis_kelamin'] ?></td>
                            <td><?= esc($a['tempat_lahir']) ?></td>
                            <td class="text-center"><?= date('d-m-Y', strtotime($a['tanggal_lahir'])) ?></td>
                            <td><?= esc($a['agama']) ?></td>
                            <td><?= esc($a['pendidikan_terakhir']) ?></td>
                            <td><?= esc($a['pekerjaan']) ?></td>
                            <td class="text-center"><?= esc($a['golongan_darah'] ?: '-') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Table II: Status & Relation -->
        <table class="table-kk">
            <thead>
                <tr>
                    <th style="width: 25px;">No</th>
                    <th>Status Perkawinan</th>
                    <th>Status Hubungan Dalam Keluarga</th>
                    <th>Kewarganegaraan</th>
                    <th>No. Paspor / Dokumen Imigrasi</th>
                    <th>Nama Ayah</th>
                    <th>Nama Ibu</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($anggota)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-2 text-muted">-</td>
                    </tr>
                <?php else: ?>
                    <?php $no2 = 1; foreach ($anggota as $a): ?>
                        <tr>
                            <td class="text-center"><?= $no2++ ?></td>
                            <td><?= esc($a['status_perkawinan']) ?></td>
                            <td class="fw-bold"><?= esc($a['shdk']) ?></td>
                            <td class="text-center"><?= esc($a['kewarganegaraan']) ?></td>
                            <td class="text-center">-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Signatures -->
        <div class="ttd-container">
            <div class="ttd-box">
                <div>KEPALA KELUARGA</div>
                <div style="height: 55px;"></div>
                <div class="fw-bold text-decoration-underline"><?= esc($kk['nama_kepala_keluarga'] ?: '..........................................') ?></div>
                <div style="font-size: 9px; color: #4b5563;">Tanda Tangan / Cap Jempol</div>
            </div>

            <div class="ttd-box">
                <div>Dikeluarkan di : Jampang</div>
                <div>Pada Tanggal : <?= date('d F Y') ?></div>
                <div class="fw-bold mt-1">KEPALA DESA JAMPANG</div>
                <div style="height: 40px;"></div>
                <div class="fw-bold text-decoration-underline"><?= esc($kades['nama_lengkap'] ?? 'MAMAN SUHERMAN, S.Pd') ?></div>
                <div style="font-size: 9px; color: #4b5563;">NIP. 19780512 200604 1 008</div>
            </div>
        </div>
    </div>

    <!-- Floating Print Controls -->
    <div class="print-bar text-center mt-3">
        <button onclick="window.print()" class="btn btn-success btn-sm px-4 fw-bold shadow">
            <i class="bi bi-printer me-1"></i> Cetak Format Kartu Keluarga (A4 Landscape)
        </button>
        <button onclick="window.close()" class="btn btn-secondary btn-sm px-3 ms-2">
            Tutup
        </button>
    </div>

</body>
</html>
