<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> - SIPENDUK DESA</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #042f2e 0%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #1e293b;
        }

        .header-section {
            padding: 3rem 1rem 2rem;
            text-align: center;
            color: #ffffff;
        }

        .search-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.3);
            max-width: 680px;
            width: 100%;
            margin: 0 auto 2rem;
            padding: 2rem;
        }

        .result-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            max-width: 680px;
            width: 100%;
            margin: 0 auto 1.5rem;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        /* Timeline Step Tracker */
        .stepper {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 2rem 1rem 1rem;
        }
        .stepper::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 30px;
            right: 30px;
            height: 4px;
            background-color: #e2e8f0;
            z-index: 1;
        }
        .step-item {
            position: relative;
            z-index: 2;
            text-align: center;
            width: 33.33%;
        }
        .step-circle {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background-color: #f1f5f9;
            color: #94a3b8;
            border: 3px solid #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            font-size: 1.1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        .step-item.active .step-circle {
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(20, 184, 166, 0.4);
        }
        .step-item.reject .step-circle {
            background: #ef4444;
            color: #ffffff;
        }
        .step-title {
            font-size: 0.78rem;
            font-weight: 600;
            color: #64748b;
        }
        .step-item.active .step-title {
            color: #0f766e;
            font-weight: 700;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header-section">
        <a href="<?= base_url('login') ?>" class="text-white text-decoration-none d-inline-flex align-items-center gap-2 mb-3 bg-white bg-opacity-10 px-3 py-1 rounded-pill small">
            <i class="bi bi-arrow-left"></i> Kembali ke Halaman Login
        </a>
        <h3 class="fw-bold mb-1">Lacak Status Permohonan Surat</h3>
        <p class="text-white-50 small mb-0">Cek progres verifikasi berkas dan penerbitan surat secara mandiri tanpa login</p>
    </div>

    <!-- Main Container -->
    <div class="container pb-5">
        <!-- Search Box -->
        <div class="search-card">
            <form action="<?= base_url('lacak-surat') ?>" method="GET">
                <label class="form-label small fw-bold text-dark mb-2">Cari Berdasarkan NIK Pemohon atau Nomor Surat / ID Pengajuan:</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="keyword" class="form-control border-start-0 py-2" placeholder="Contoh: 3201123456780001 atau SKTM" value="<?= esc($keyword ?? '') ?>" required autofocus>
                    <button type="submit" class="btn text-white px-4 fw-semibold" style="background: linear-gradient(135deg, #0f766e, #14b8a6);">
                        Lacak Surat
                    </button>
                </div>
                <div class="form-text" style="font-size: 0.75rem;">
                    Ketik 16 digit NIK Anda untuk melihat seluruh permohonan surat yang sedang atau telah diajukan.
                </div>
            </form>
        </div>

        <!-- Search Results -->
        <?php if (!empty($keyword)): ?>
            <?php if (empty($results)): ?>
                <div class="result-card p-5 text-center">
                    <i class="bi bi-file-earmark-x text-muted fs-1 d-block mb-2"></i>
                    <h5 class="fw-bold text-dark">Data Permohonan Tidak Ditemukan</h5>
                    <p class="text-muted small mb-0">
                        Tidak ada pengajuan surat yang cocok dengan kata kunci <strong>"<?= esc($keyword) ?>"</strong>. Pastikan NIK yang Anda masukkan benar.
                    </p>
                </div>
            <?php else: ?>
                <?php foreach ($results as $res): ?>
                    <div class="result-card">
                        <div class="p-4 border-bottom bg-light d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-primary-subtle text-primary fw-bold px-2 py-1 mb-1">
                                    <?= esc($res['nama_surat'] ?? $res['jenis_surat']) ?>
                                </span>
                                <h6 class="fw-bold mb-0 text-dark"><?= esc($res['nama_pemohon'] ?? 'Warga') ?></h6>
                                <span class="text-muted small">NIK: <?= esc($res['nik_pemohon']) ?></span>
                            </div>
                            <div class="text-end">
                                <?php 
                                    $stClass = match($res['status']) {
                                        'Pending' => 'bg-warning-subtle text-warning',
                                        'Proses' => 'bg-info-subtle text-info',
                                        'Disetujui' => 'bg-success-subtle text-success',
                                        'Ditolak' => 'bg-danger-subtle text-danger',
                                        default => 'bg-secondary'
                                    };
                                ?>
                                <span class="badge <?= $stClass ?> px-3 py-2 rounded-pill fw-bold">
                                    <?= esc($res['status']) ?>
                                </span>
                            </div>
                        </div>

                        <!-- Stepper Progress Tracker -->
                        <div class="p-4">
                            <div class="stepper">
                                <!-- Step 1: Diajukan -->
                                <div class="step-item active">
                                    <div class="step-circle"><i class="bi bi-send-check"></i></div>
                                    <div class="step-title">Permohonan Masuk</div>
                                    <span class="text-muted" style="font-size: 0.7rem;"><?= date('d M Y', strtotime($res['tanggal_pengajuan'])) ?></span>
                                </div>

                                <!-- Step 2: Diverifikasi -->
                                <div class="step-item <?= in_array($res['status'], ['Proses', 'Disetujui', 'Ditolak']) ? 'active' : '' ?>">
                                    <div class="step-circle"><i class="bi bi-search"></i></div>
                                    <div class="step-title">Verifikasi Berkas</div>
                                    <span class="text-muted" style="font-size: 0.7rem;">Operator Desa</span>
                                </div>

                                <!-- Step 3: Pengesahan Kades -->
                                <?php if ($res['status'] === 'Ditolak'): ?>
                                    <div class="step-item reject">
                                        <div class="step-circle"><i class="bi bi-x-circle"></i></div>
                                        <div class="step-title text-danger">Ditolak</div>
                                        <span class="text-muted" style="font-size: 0.7rem;">Perlu Revisi</span>
                                    </div>
                                <?php else: ?>
                                    <div class="step-item <?= ($res['status'] === 'Disetujui') ? 'active' : '' ?>">
                                        <div class="step-circle"><i class="bi bi-patch-check"></i></div>
                                        <div class="step-title">Disahkan Kades</div>
                                        <span class="text-muted" style="font-size: 0.7rem;">QR Code Terbit</span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <hr class="my-4">

                            <!-- Details -->
                            <div class="small mb-3">
                                <div><strong>Keperluan:</strong> <?= esc($res['keperluan']) ?></div>
                                <?php if (!empty($res['no_surat'])): ?>
                                    <div><strong>Nomor Surat Resmi:</strong> <span class="font-monospace text-primary fw-bold"><?= esc($res['no_surat']) ?></span></div>
                                <?php endif; ?>
                                <?php if ($res['status'] === 'Ditolak' && !empty($res['catatan_revisi'])): ?>
                                    <div class="alert alert-danger border-0 p-2 mt-2">
                                        <strong>Alasan Penolakan:</strong> <?= esc($res['catatan_revisi']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if ($res['status'] === 'Disetujui'): ?>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="<?= base_url('surat/cetak/' . $res['id_pengajuan']) ?>" target="_blank" class="btn btn-success btn-sm px-4 fw-bold rounded-pill">
                                        <i class="bi bi-printer me-1"></i> Cetak / Unduh Dokumen Resmi
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>

</body>
</html>
