<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    
    <!-- Google Fonts: Times New Roman alternative or Georgia for authentic government documents -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Plus+Jakarta+Sans:wght@400;600;700&family=Tinos:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- QRCode Generator CDN -->
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>

    <style>
        body {
            background-color: #f1f5f9;
            font-family: 'Tinos', 'Times New Roman', serif;
            color: #111827;
            margin: 0;
            padding: 20px 0;
            font-size: 15px;
            line-height: 1.6;
        }

        /* Printable Paper Container */
        .paper {
            background: #ffffff;
            width: 210mm;
            min-height: 297mm;
            padding: 20mm 25mm;
            margin: 0 auto;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            position: relative;
            box-sizing: border-box;
        }

        /* Kop Surat Resmi Standard Tata Naskah Dinas */
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

        .kop-text h4 {
            font-size: 17px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .kop-text h3 {
            font-size: 19px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .kop-text h2 {
            font-size: 22px;
            font-weight: 800;
            margin: 2px 0 0;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .kop-text p {
            font-size: 12px;
            margin: 4px 0 0;
            font-style: italic;
            color: #374151;
        }

        .garis-kop {
            border-top: 3px solid #000000;
            border-bottom: 1px solid #000000;
            height: 5px;
            margin-top: 6px;
            margin-bottom: 24px;
        }

        /* Judul Surat */
        .judul-surat {
            text-align: center;
            margin-bottom: 24px;
        }

        .judul-surat h4 {
            font-size: 18px;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            margin: 0;
            letter-spacing: 0.05em;
        }

        .judul-surat .nomor-surat {
            font-size: 14px;
            margin-top: 4px;
        }

        /* Isi Surat */
        .isi-surat p {
            margin-bottom: 12px;
            text-align: justify;
        }

        .tabel-identitas {
            width: 100%;
            margin: 14px 0 18px 24px;
        }

        .tabel-identitas td {
            padding: 3px 6px;
            vertical-align: top;
        }

        .tabel-identitas td.label {
            width: 200px;
        }

        .tabel-identitas td.titik {
            width: 15px;
        }

        /* Tanda Tangan */
        .ttd-wrapper {
            margin-top: 35px;
            display: flex;
            justify-content: flex-end;
        }

        .ttd-box {
            width: 260px;
            text-align: center;
        }

        .ttd-jabatan {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .qr-ttd-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin: 12px 0;
        }

        .qr-frame {
            padding: 4px;
            background: #ffffff;
            border: 1px solid #d1d5db;
            display: inline-block;
        }

        .stempel-digital {
            font-size: 10px;
            border: 1.5px dashed #0f766e;
            padding: 4px 8px;
            border-radius: 6px;
            color: #0f766e;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .ttd-nama {
            font-weight: bold;
            text-decoration: underline;
            font-size: 15px;
            margin-top: 6px;
        }

        /* Print Controls Floating Bar */
        .print-controls {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            background: #1e293b;
            color: #ffffff;
            padding: 10px 24px;
            border-radius: 50px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            gap: 16px;
            z-index: 9999;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        @media print {
            body {
                background: none;
                padding: 0;
            }
            .paper {
                box-shadow: none;
                padding: 15mm 20mm;
                margin: 0;
                width: 100%;
                min-height: auto;
            }
            .print-controls {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <!-- Printable Paper -->
    <div class="paper">
        <!-- Kop Surat Resmi -->
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

        <!-- Judul & Nomor Surat -->
        <div class="judul-surat">
            <h4><?= strtoupper(esc($surat['nama_surat'] ?? 'SURAT KETERANGAN')) ?></h4>
            <div class="nomor-surat">Nomor : <strong><?= esc($surat['no_surat'] ?? '470/..../DS-JMP/' . date('Y')) ?></strong></div>
        </div>

        <!-- Isi Surat -->
        <div class="isi-surat">
            <p>
                Yang bertanda tangan di bawah ini Kepala Desa Jampang, Kecamatan Gunung Sindur, Kabupaten Bogor, Provinsi Jawa Barat, dengan ini menerangkan bahwa:
            </p>

            <table class="tabel-identitas">
                <tr>
                    <td class="label">Nama Lengkap</td>
                    <td class="titik">:</td>
                    <td><strong><?= esc($surat['nama_pemohon']) ?></strong></td>
                </tr>
                <tr>
                    <td class="label">Nomor Induk Kependudukan (NIK)</td>
                    <td class="titik">:</td>
                    <td><?= esc($surat['nik_pemohon']) ?></td>
                </tr>
                <tr>
                    <td class="label">Nomor Kartu Keluarga (KK)</td>
                    <td class="titik">:</td>
                    <td><?= esc($surat['no_kk']) ?></td>
                </tr>
                <tr>
                    <td class="label">Tempat, Tanggal Lahir</td>
                    <td class="titik">:</td>
                    <td><?= esc($surat['tempat_lahir']) ?>, <?= date('d F Y', strtotime($surat['tanggal_lahir'])) ?></td>
                </tr>
                <tr>
                    <td class="label">Jenis Kelamin</td>
                    <td class="titik">:</td>
                    <td><?= ($surat['jenis_kelamin'] === 'L') ? 'Laki-Laki' : 'Perempuan' ?></td>
                </tr>
                <tr>
                    <td class="label">Agama</td>
                    <td class="titik">:</td>
                    <td><?= esc($surat['agama']) ?></td>
                </tr>
                <tr>
                    <td class="label">Status Perkawinan</td>
                    <td class="titik">:</td>
                    <td><?= esc($surat['status_perkawinan']) ?></td>
                </tr>
                <tr>
                    <td class="label">Pekerjaan</td>
                    <td class="titik">:</td>
                    <td><?= esc($surat['pekerjaan']) ?></td>
                </tr>
                <tr>
                    <td class="label">Kewarganegaraan</td>
                    <td class="titik">:</td>
                    <td><?= esc($surat['kewarganegaraan'] ?? 'WNI') ?></td>
                </tr>
                <tr>
                    <td class="label">Alamat / Tempat Tinggal</td>
                    <td class="titik">:</td>
                    <td><?= esc($surat['alamat']) ?>, RT <?= esc($surat['rt']) ?> / RW <?= esc($surat['rw']) ?>, Desa <?= esc($surat['desa_kelurahan'] ?? 'Jampang') ?>, Kec. <?= esc($surat['kecamatan'] ?? 'Gunung Sindur') ?>, Kab. Bogor</td>
                </tr>
            </table>

            <!-- Content According to Letter Type -->
            <?php 
                $kode = strtoupper($surat['kode_surat'] ?? '');
            ?>
            <?php if ($kode === 'SKTM'): ?>
                <p>
                    Bahwa nama tersebut di atas adalah benar-benar warga penduduk Desa Jampang yang berdomisili pada alamat tersebut, dan berdasarkan hasil pengamatan dan data administrasi kami, yang bersangkutan tergolong dalam keluarga <strong>Kurang Mampu / Berpenghasilan Rendah</strong>.
                </p>
            <?php elseif ($kode === 'SKU'): ?>
                <p>
                    Bahwa nama tersebut di atas adalah benar-benar warga penduduk Desa Jampang dan memiliki kegiatan usaha aktif yang berlokasi di wilayah Desa Jampang, Kecamatan Gunung Sindur, Kabupaten Bogor.
                </p>
            <?php elseif ($kode === 'SKCK'): ?>
                <p>
                    Bahwa nama tersebut di atas adalah benar-benar penduduk Desa Jampang, dan sepanjang pengetahuan kami selama bertempat tinggal di desa ini berkelakuan baik, tidak sedang menjalani proses hukum, serta tidak pernah terlibat tindak pidana kejahatan apapun.
                </p>
            <?php elseif ($kode === 'SKD'): ?>
                <p>
                    Bahwa nama tersebut di atas adalah benar-benar penduduk yang bertempat tinggal dan berdomisili sah di wilayah Desa Jampang, Kecamatan Gunung Sindur, Kabupaten Bogor.
                </p>
            <?php elseif ($kode === 'SKP'): ?>
                <p>
                    Bahwa nama tersebut di atas adalah benar-benar warga Desa Jampang yang telah tercatat mengajukan permohonan kepindahan alamat domisili ke luar wilayah administrasi desa kami.
                </p>
            <?php else: ?>
                <p>
                    Bahwa nama tersebut di atas adalah benar-benar penduduk Desa Jampang yang tercatat sah dalam pangkalan data administrasi kependudukan kami.
                </p>
            <?php endif; ?>

            <p>
                Surat Keterangan ini diberikan kepada yang bersangkutan untuk keperluan : <strong><?= esc($surat['keperluan']) ?></strong>.
            </p>

            <p>
                Demikian surat keterangan ini kami buat dengan sebenarnya, agar dapat dipergunakan sebagaimana mestinya oleh pihak yang berkepentingan.
            </p>
        </div>

        <!-- Tanda Tangan & QR Code Digital Validation -->
        <div class="ttd-wrapper">
            <div class="ttd-box">
                <div>Jampang, <?= date('d F Y', strtotime($surat['tanggal_persetujuan'] ?? 'now')) ?></div>
                <div class="ttd-jabatan">Kepala Desa Jampang</div>

                <!-- QR Code & Digital Signature Stamp -->
                <div class="qr-ttd-container">
                    <div class="qr-frame">
                        <div id="qrcode"></div>
                    </div>
                </div>

                <div class="stempel-digital mb-1">
                    <i class="bi bi-shield-check"></i> TTE Tervalidasi Resmi
                </div>

                <div class="ttd-nama"><?= esc($surat['nama_kades'] ?: 'MAMAN SUHERMAN, S.Pd') ?></div>
                <div style="font-size: 12px; color: #4b5563;">NIP. 19780512 200604 1 008</div>
            </div>
        </div>

        <!-- Verification Footnote -->
        <div style="position: absolute; bottom: 15mm; left: 25mm; right: 25mm; font-size: 10px; color: #6b7280; border-top: 1px dashed #d1d5db; padding-top: 4px; display: flex; justify-content: space-between;">
            <span>Dokumen ini sah & diterbitkan oleh Sistem Informasi Kependudukan Desa Jampang.</span>
            <span>Scan QR Code untuk verifikasi keaslian surat secara online.</span>
        </div>
    </div>

    <!-- Floating Print Controls -->
    <div class="print-controls">
        <span class="small fw-semibold"><i class="bi bi-printer me-1"></i> Cetak / Simpan PDF</span>
        <button onclick="window.print()" class="btn btn-sm btn-success px-3 fw-bold rounded-pill">
            <i class="bi bi-printer-fill me-1"></i> Cetak Dokumen
        </button>
        <button onclick="window.close()" class="btn btn-sm btn-outline-light px-3 rounded-pill">
            Tutup
        </button>
    </div>

    <!-- Generate Scannable QR Code -->
    <script>
        const verifyUrl = "<?= esc($verificationUrl) ?>";
        new QRCode(document.getElementById("qrcode"), {
            text: verifyUrl,
            width: 82,
            height: 82,
            colorDark : "#0f766e",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    </script>
</body>
</html>
