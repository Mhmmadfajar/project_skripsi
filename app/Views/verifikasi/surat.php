<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> - Pemerintah Desa Jampang</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f0fdfa 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        .verify-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.15);
            max-width: 620px;
            width: 100%;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        .header-valid {
            background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
            color: #ffffff;
            padding: 2.5rem 2rem 2rem;
            text-align: center;
        }
        .header-invalid {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            color: #ffffff;
            padding: 2.5rem 2rem 2rem;
            text-align: center;
        }
        .icon-seal {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .verify-body {
            padding: 2rem;
        }
        .table-verify td {
            padding: 0.65rem 0.5rem;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <div class="verify-card">
        <?php if ($surat && $surat['status'] === 'Disetujui'): ?>
            <!-- Verified Header -->
            <div class="header-valid">
                <div class="icon-seal">
                    <i class="bi bi-patch-check-fill"></i>
                </div>
                <h4 class="fw-bold mb-1">SURAT RESMI & TERVERIFIKASI</h4>
                <p class="small text-white-50 mb-0">Sistem Informasi Administrasi Pemerintah Desa Jampang</p>
                <div class="mt-2">
                    <span class="badge bg-white text-dark px-3 py-1 fw-bold rounded-pill" style="font-size: 0.78rem;">
                        <i class="bi bi-shield-lock-fill text-success me-1"></i> TANDA TANGAN ELEKTRONIK SAH
                    </span>
                </div>
            </div>

            <!-- Details -->
            <div class="verify-body">
                <div class="alert alert-success border-0 small d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                    <div>
                        Dokumen ini dinyatakan <strong>ASLI</strong> dan tercatat secara legal dalam pangkalan data kependudukan desa.
                    </div>
                </div>

                <table class="table table-verify mb-4">
                    <tr>
                        <td class="text-muted" style="width: 170px;">Nomor Surat:</td>
                        <td class="fw-bold text-dark font-monospace"><?= esc($surat['no_surat']) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Jenis Surat:</td>
                        <td class="fw-bold text-teal" style="color: #0f766e;"><?= esc($surat['nama_surat'] ?? $surat['jenis_surat']) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Nama Pemohon:</td>
                        <td class="fw-bold text-dark"><?= esc($surat['nama_pemohon']) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">NIK Pemohon:</td>
                        <td class="font-monospace">
                            <?= substr(esc($surat['nik_pemohon']), 0, 6) ?>******<?= substr(esc($surat['nik_pemohon']), -4) ?>
                            <span class="badge bg-light text-muted border small ms-1">Terlindungi</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Keperluan:</td>
                        <td><?= esc($surat['keperluan']) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Disahkan Oleh:</td>
                        <td class="fw-semibold text-dark"><?= esc($surat['nama_kades'] ?: 'Maman Suherman, S.Pd (Kepala Desa)') ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tanggal Pengesahan:</td>
                        <td><?= date('d F Y, H:i', strtotime($surat['tanggal_persetujuan'] ?? $surat['tgl_disetujui'] ?? 'now')) ?> WIB</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Kode Verifikasi:</td>
                        <td class="font-monospace text-muted small"><?= esc($qr_code) ?></td>
                    </tr>
                </table>

                <div class="text-center pt-2 border-top">
                    <p class="text-muted small mb-0">
                        &copy; Pemerintah Desa Jampang, Kec. Gunung Sindur, Kab. Bogor
                    </p>
                </div>
            </div>

        <?php else: ?>
            <!-- Invalid Header -->
            <div class="header-invalid">
                <div class="icon-seal">
                    <i class="bi bi-x-octagon-fill"></i>
                </div>
                <h4 class="fw-bold mb-1">DOKUMEN TIDAK VALID</h4>
                <p class="small text-white-50 mb-0">Pemerintah Desa Jampang</p>
            </div>

            <div class="verify-body text-center py-5">
                <i class="bi bi-shield-x text-danger fs-1 d-block mb-3"></i>
                <h5 class="fw-bold text-dark">Data Surat Tidak Ditemukan!</h5>
                <p class="text-muted small mb-4">
                    Kode verifikasi atau QR Code ini tidak terdaftar dalam basis data resmi Pemerintah Desa Jampang, atau status surat belum disahkan oleh Kepala Desa.
                </p>
                <div class="bg-light p-2 rounded font-monospace small text-muted mb-4">
                    Token: <?= esc($qr_code) ?>
                </div>
                <a href="<?= base_url('login') ?>" class="btn btn-outline-secondary btn-sm px-4">
                    Kembali ke Halaman Utama
                </a>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
