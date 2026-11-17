<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<style>
    /* Custom Styling for Citizen Portal */
    .portal-hero {
        background: linear-gradient(135deg, #093c37 0%, #0f766e 55%, #14b8a6 100%);
        border-radius: 20px;
        position: relative;
        overflow: hidden;
        color: #ffffff;
        box-shadow: 0 10px 30px rgba(15, 118, 110, 0.25);
    }
    .portal-hero::before {
        content: "";
        position: absolute;
        top: -40%;
        right: -10%;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .portal-hero::after {
        content: "";
        position: absolute;
        bottom: -30%;
        left: 20%;
        width: 240px;
        height: 240px;
        background: radial-gradient(circle, rgba(20, 184, 166, 0.3) 0%, rgba(20, 184, 166, 0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .portal-badge-glass {
        background: rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        color: #ffffff;
    }
    .quick-action-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.25rem;
        transition: all 0.25s cubic-bezier(0.165, 0.84, 0.44, 1);
        text-decoration: none;
        color: inherit;
        display: block;
        height: 100%;
    }
    .quick-action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(15, 118, 110, 0.12);
        border-color: #14b8a6;
        color: inherit;
    }
    .quick-action-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 0.85rem;
        transition: transform 0.25s ease;
    }
    .quick-action-card:hover .quick-action-icon {
        transform: scale(1.08);
    }
    .announcement-card {
        border-left: 4px solid transparent;
        transition: all 0.2s ease;
    }
    .announcement-card:hover {
        border-left-color: #0f766e;
        background-color: #f8fafc;
    }
    .event-date-box {
        width: 60px;
        height: 64px;
        border-radius: 12px;
        background: #f0fdfa;
        border: 1px solid #ccfbf1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        flex-shrink: 0;
    }
    .status-counter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1rem;
        text-align: center;
        transition: all 0.2s ease;
    }
    .status-counter-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.05);
    }
</style>

<!-- ========================================== -->
<!-- 1. HERO WELCOME & RESIDENT PROFILE BANNER -->
<!-- ========================================== -->
<div class="portal-hero p-4 p-md-5 mb-4 position-relative">
    <div class="row align-items-center g-4 position-relative" style="z-index: 2;">
        <div class="col-lg-8">
            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                <span class="badge portal-badge-glass px-3 py-2 rounded-pill small fw-semibold">
                    <i class="bi bi-patch-check-fill text-warning me-1"></i> PORTAL WARGA DIGITAL
                </span>
                <span class="badge portal-badge-glass px-3 py-2 rounded-pill small">
                    <i class="bi bi-geo-alt-fill text-info me-1"></i> Desa Jampang, Kec. Kemang
                </span>
                <span class="badge portal-badge-glass px-3 py-2 rounded-pill small">
                    <i class="bi bi-calendar3 me-1"></i> <?= date('l, d F Y') ?>
                </span>
            </div>

            <h2 class="fw-bold mb-2 text-white">
                Selamat Datang, <?= esc(session()->get('nama_lengkap')) ?>! 👋
            </h2>
            
            <p class="text-white-50 mb-3" style="max-width: 600px; font-size: 0.95rem;">
                Akses pusat informasi resmi, agenda kegiatan desa, pengumuman bantuan, serta ajukan surat administrasi kependudukan Anda secara mandiri kapan saja.
            </p>

            <div class="d-flex flex-wrap gap-2 pt-1">
                <div class="portal-badge-glass px-3 py-2 rounded-3 small">
                    <span class="text-white-50 d-block" style="font-size: 0.72rem;">NIK Pemohon</span>
                    <strong class="font-monospace text-white"><?= esc(session()->get('nik') ?: '-') ?></strong>
                </div>
                <div class="portal-badge-glass px-3 py-2 rounded-3 small">
                    <span class="text-white-50 d-block" style="font-size: 0.72rem;">Nomor Kartu Keluarga (KK)</span>
                    <strong class="font-monospace text-white"><?= esc($penduduk['no_kk'] ?? '-') ?></strong>
                </div>
                <div class="portal-badge-glass px-3 py-2 rounded-3 small">
                    <span class="text-white-50 d-block" style="font-size: 0.72rem;">Wilayah Domisili</span>
                    <strong class="text-white">RT <?= esc($penduduk['rt'] ?? '-') ?> / RW <?= esc($penduduk['rw'] ?? '-') ?></strong>
                </div>
            </div>
        </div>

        <div class="col-lg-4 text-lg-end">
            <div class="d-flex flex-column flex-sm-row flex-lg-column gap-2 justify-content-lg-end">
                <a href="<?= base_url('surat/tambah') ?>" class="btn btn-warning btn-lg fw-bold px-4 py-3 rounded-4 shadow text-dark d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-file-earmark-plus-fill fs-5"></i>
                    <span>Ajukan Surat Mandiri</span>
                </a>
                <?php if (!empty($penduduk['no_kk'])): ?>
                    <button type="button" class="btn btn-outline-light px-4 py-2 rounded-4 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalDataKeluarga">
                        <i class="bi bi-people-fill me-1"></i> Lihat Data Keluarga
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- 2. NOTIFIKASI SURAT DISETUJUI (JIKA ADA)   -->
<!-- ========================================== -->
<?php if ($surat_disetujui > 0): ?>
    <div class="alert alert-success border-0 shadow-sm rounded-4 p-3 mb-4 d-flex align-items-center justify-content-between flex-wrap gap-3" style="background: #ecfdf5; border-left: 5px solid #10b981 !important;">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; flex-shrink: 0;">
                <i class="bi bi-patch-check-fill fs-5"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-1 text-success">Kabar Baik! Anda Memiliki <?= $surat_disetujui ?> Surat yang Telah Disetujui</h6>
                <p class="mb-0 text-muted small">Surat telah ditandatangani Kepala Desa dengan QR Code resmi. Anda dapat langsung mengunduh atau mencetak dokumen dari rumah.</p>
            </div>
        </div>
        <div>
            <a href="#tabelSurat" class="btn btn-success rounded-3 btn-sm px-3 fw-semibold">
                <i class="bi bi-arrow-down-circle me-1"></i> Lihat Surat Siap Cetak
            </a>
        </div>
    </div>
<?php endif; ?>

<!-- ========================================== -->
<!-- 3. AKSES PINTAS CEPAT (QUICK ACTIONS)      -->
<!-- ========================================== -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <a href="<?= base_url('surat/tambah') ?>" class="quick-action-card">
            <div class="quick-action-icon bg-primary-subtle text-primary">
                <i class="bi bi-file-earmark-plus"></i>
            </div>
            <h6 class="fw-bold mb-1 text-dark">Buat Surat Baru</h6>
            <p class="text-muted mb-0 small" style="font-size: 0.78rem;">Pengantar SKTM, SKCK, Domisili, Usaha, dll.</p>
        </a>
    </div>

    <div class="col-6 col-lg-3">
        <a href="#tabelSurat" class="quick-action-card">
            <div class="quick-action-icon bg-warning-subtle text-warning">
                <i class="bi bi-search"></i>
            </div>
            <h6 class="fw-bold mb-1 text-dark">Lacak Berkas</h6>
            <p class="text-muted mb-0 small" style="font-size: 0.78rem;">Pantau status verifikasi surat secara live.</p>
        </a>
    </div>

    <div class="col-6 col-lg-3">
        <a href="#" class="quick-action-card" data-bs-toggle="modal" data-bs-target="#modalDataKeluarga">
            <div class="quick-action-icon bg-success-subtle text-success">
                <i class="bi bi-person-vcard"></i>
            </div>
            <h6 class="fw-bold mb-1 text-dark">Data Keluarga (KK)</h6>
            <p class="text-muted mb-0 small" style="font-size: 0.78rem;">Periksa data anggota KK yang terdaftar.</p>
        </a>
    </div>

    <div class="col-6 col-lg-3">
        <a href="#" class="quick-action-card" data-bs-toggle="modal" data-bs-target="#modalKontakDarurat">
            <div class="quick-action-icon bg-danger-subtle text-danger">
                <i class="bi bi-telephone-plus"></i>
            </div>
            <h6 class="fw-bold mb-1 text-dark">Bantuan & Darurat</h6>
            <p class="text-muted mb-0 small" style="font-size: 0.78rem;">Ambulans Siaga Desa & Babinsa 24 Jam.</p>
        </a>
    </div>
</div>

<!-- ======================================================== -->
<!-- 4. KONTEN UTAMA: PENGUMUMAN & AGENDA DESA (2 KOLOM)      -->
<!-- ======================================================== -->
<div class="row g-4 mb-4">
    <!-- Kolom Kiri: Papan Pengumuman Resmi Desa -->
    <div class="col-lg-7">
        <div class="card-custom h-100">
            <div class="card-header-custom">
                <div class="d-flex align-items-center gap-2">
                    <div class="p-2 rounded-3 text-white" style="background: linear-gradient(135deg, #0f766e, #14b8a6);">
                        <i class="bi bi-megaphone-fill"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">Papan Pengumuman Resmi Desa</h6>
                        <small class="text-muted">Informasi terbaru langsung dari Kantor Pemerintah Desa</small>
                    </div>
                </div>
            </div>

            <div class="p-3">
                <div class="d-flex flex-column gap-3">
                    <?php foreach ($pengumuman as $p): ?>
                        <div class="card border rounded-4 p-3 announcement-card bg-white shadow-sm">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-<?= esc($p['badge']) ?>-subtle text-<?= esc($p['badge']) ?> px-2 py-1 rounded-pill small fw-semibold">
                                    <i class="bi <?= esc($p['icon']) ?> me-1"></i> <?= esc($p['kategori']) ?>
                                </span>
                                <small class="text-muted"><i class="bi bi-calendar-event me-1"></i> <?= esc($p['tanggal']) ?></small>
                            </div>

                            <h6 class="fw-bold text-dark mb-1 lh-base">
                                <?= esc($p['judul']) ?>
                            </h6>

                            <p class="text-muted small mb-3">
                                <?= esc($p['ringkasan']) ?>
                            </p>

                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                <small class="text-muted">
                                    <i class="bi bi-person-check me-1 text-teal" style="color: #0f766e;"></i> <?= esc($p['penulis']) ?>
                                </small>
                                <button type="button" class="btn btn-sm btn-outline-teal rounded-3 px-3 fw-semibold btn-detail-pengumuman"
                                        style="color: #0f766e; border-color: #0f766e;"
                                        data-judul="<?= esc($p['judul']) ?>"
                                        data-kategori="<?= esc($p['kategori']) ?>"
                                        data-tanggal="<?= esc($p['tanggal']) ?>"
                                        data-waktu="<?= esc($p['waktu']) ?>"
                                        data-lokasi="<?= esc($p['lokasi']) ?>"
                                        data-penulis="<?= esc($p['penulis']) ?>"
                                        data-isi="<?= esc($p['isi']) ?>">
                                    Baca Detail <i class="bi bi-arrow-right ms-1"></i>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Agenda Kegiatan Warga Desa & Sekilas Desa -->
    <div class="col-lg-5">
        <!-- Card Agenda Desa -->
        <div class="card-custom mb-4">
            <div class="card-header-custom">
                <div class="d-flex align-items-center gap-2">
                    <div class="p-2 rounded-3 text-white" style="background: linear-gradient(135deg, #2563eb, #38bdf8);">
                        <i class="bi bi-calendar-check-fill"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">Agenda & Kegiatan Desa</h6>
                        <small class="text-muted">Jadwal kegiatan warga bulan ini</small>
                    </div>
                </div>
            </div>

            <div class="p-3">
                <div class="d-flex flex-column gap-3">
                    <?php foreach ($agenda as $ag): ?>
                        <div class="d-flex gap-3 align-items-start p-2 rounded-3 border-bottom pb-3">
                            <div class="event-date-box">
                                <?php 
                                    // Parse date simple preview
                                    $parts = explode(' ', $ag['tanggal']);
                                    $tglNum = preg_replace('/[^0-9]/', '', $ag['tanggal']);
                                ?>
                                <span class="fw-bold text-teal" style="color: #0f766e; font-size: 1.15rem; line-height: 1;"><?= substr($tglNum, 0, 2) ?: '15' ?></span>
                                <span class="text-muted fw-semibold" style="font-size: 0.65rem; text-transform: uppercase;">OKT</span>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between gap-1 mb-1">
                                    <span class="badge bg-<?= esc($ag['badge']) ?>-subtle text-<?= esc($ag['badge']) ?> rounded-pill" style="font-size: 0.7rem;">
                                        <?= esc($ag['status']) ?>
                                    </span>
                                    <small class="text-muted" style="font-size: 0.72rem;"><i class="bi bi-clock me-1"></i> <?= esc($ag['waktu']) ?></small>
                                </div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">
                                    <?= esc($ag['nama']) ?>
                                </h6>
                                <p class="text-muted mb-1 small" style="font-size: 0.78rem;">
                                    <i class="bi bi-geo-alt text-danger me-1"></i> <?= esc($ag['lokasi']) ?>
                                </p>
                                <span class="text-muted" style="font-size: 0.72rem;">
                                    <i class="bi bi-flag me-1"></i> <?= esc($ag['penyelenggara']) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Card Statistik Transparansi Desa -->
        <div class="card-custom p-3 bg-white">
            <h6 class="fw-bold mb-3 text-dark d-flex align-items-center gap-2">
                <i class="bi bi-graph-up-arrow text-teal" style="color: #0f766e;"></i> Sekilas Profil Desa Jampang
            </h6>
            <div class="row g-2 text-center">
                <div class="col-6">
                    <div class="p-2 rounded-3 bg-light border">
                        <span class="text-muted d-block small" style="font-size: 0.72rem;">Total Penduduk</span>
                        <strong class="fs-5 text-teal" style="color: #0f766e;"><?= number_format($total_warga_desa ?? 0) ?></strong>
                        <span class="text-muted d-block" style="font-size: 0.65rem;">Jiwa Terdaftar</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-2 rounded-3 bg-light border">
                        <span class="text-muted d-block small" style="font-size: 0.72rem;">Kepala Keluarga</span>
                        <strong class="fs-5 text-primary"><?= number_format($total_kk_desa ?? 0) ?></strong>
                        <span class="text-muted d-block" style="font-size: 0.65rem;">Kartu Keluarga</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-2 rounded-3 bg-light border">
                        <span class="text-muted d-block small" style="font-size: 0.72rem;">Wilayah Administrasi</span>
                        <strong class="fs-5 text-dark">6 RW / 24 RT</strong>
                        <span class="text-muted d-block" style="font-size: 0.65rem;">Dusun I, II, & III</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-2 rounded-3 bg-light border">
                        <span class="text-muted d-block small" style="font-size: 0.72rem;">Kepala Desa</span>
                        <strong class="fs-6 text-dark text-truncate d-block">Maman Suherman, S.Pd.</strong>
                        <span class="text-muted d-block" style="font-size: 0.65rem;">Periode Aktif</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- 5. DIREKTORI KONTAK PENTING & DARURAT DESA -->
<!-- ========================================== -->
<div class="card-custom p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
        <div>
            <h6 class="fw-bold mb-1 text-dark d-flex align-items-center gap-2">
                <i class="bi bi-shield-fill-plus text-danger fs-5"></i> Nomor Penting & Bantuan Cepat Warga
            </h6>
            <p class="text-muted small mb-0">Hubungi petugas desa jika membutuhkan bantuan darurat atau pendampingan.</p>
        </div>
        <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill small fw-semibold">
            <i class="bi bi-telephone-inbound-fill me-1"></i> Layanan Siaga
        </span>
    </div>

    <div class="row g-3">
        <?php foreach ($kontak_darurat as $kd): ?>
            <div class="col-md-6 col-xl-3">
                <div class="p-3 rounded-4 border bg-light h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi <?= esc($kd['icon']) ?> fs-4"></i>
                            <span class="badge bg-white text-dark border small fw-semibold"><?= esc($kd['badge']) ?></span>
                        </div>
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 0.92rem;"><?= esc($kd['instansi']) ?></h6>
                        <small class="text-muted d-block mb-2"><?= esc($kd['petugas']) ?></small>
                        <div class="fw-bold font-monospace text-teal mb-3" style="color: #0f766e;"><?= esc($kd['nomor']) ?></div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="https://wa.me/<?= esc($kd['wa']) ?>?text=Halo%20saya%20warga%20Desa%20Jampang%20ingin%20meminta%20informasi%20atau%20bantuan" target="_blank" class="btn btn-sm btn-success rounded-3 w-100 fw-semibold">
                            <i class="bi bi-whatsapp me-1"></i> WhatsApp
                        </a>
                        <a href="tel:<?= esc(str_replace(['-', ' '], '', $kd['nomor'])) ?>" class="btn btn-sm btn-outline-secondary rounded-3 px-3" title="Telepon Langsung">
                            <i class="bi bi-telephone-fill"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ========================================== -->
<!-- 6. RIWAYAT PERMOHONAN SURAT SAYA          -->
<!-- ========================================== -->
<div id="tabelSurat" class="card-custom">
    <div class="card-header-custom flex-wrap gap-2">
        <div>
            <h6 class="fw-bold mb-1 text-dark d-flex align-items-center gap-2">
                <i class="bi bi-file-earmark-text-fill text-teal" style="color: #0f766e;"></i> Riwayat Permohonan Surat Saya
            </h6>
            <small class="text-muted">Pantau status pengajuan surat administrasi Anda secara real-time</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="<?= base_url('surat/tambah') ?>" class="btn btn-primary-custom btn-sm px-3 rounded-3">
                <i class="bi bi-plus-circle-fill me-1"></i> Ajukan Surat Baru
            </a>
        </div>
    </div>

    <!-- Status Counters Filter Box -->
    <div class="p-3 bg-light border-bottom">
        <div class="row g-2">
            <div class="col-6 col-md-3">
                <div class="status-counter-card">
                    <span class="text-muted d-block small" style="font-size: 0.72rem;">Total Diajukan</span>
                    <h4 class="fw-bold mb-0 text-dark"><?= $total_surat ?></h4>
                    <span class="text-muted" style="font-size: 0.65rem;">Semua Dokumen</span>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="status-counter-card">
                    <span class="text-muted d-block small" style="font-size: 0.72rem;">Menunggu (Pending)</span>
                    <h4 class="fw-bold mb-0 text-warning"><?= $surat_pending ?></h4>
                    <span class="text-muted" style="font-size: 0.65rem;">Antrean Awal</span>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="status-counter-card">
                    <span class="text-muted d-block small" style="font-size: 0.72rem;">Sedang Diverifikasi</span>
                    <h4 class="fw-bold mb-0 text-info"><?= $surat_proses ?></h4>
                    <span class="text-muted" style="font-size: 0.65rem;">Pemeriksaan Operator</span>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="status-counter-card">
                    <span class="text-muted d-block small" style="font-size: 0.72rem;">Disetujui Kades</span>
                    <h4 class="fw-bold mb-0 text-success"><?= $surat_disetujui ?></h4>
                    <span class="text-success fw-semibold" style="font-size: 0.65rem;">Siap Cetak / QR Terbit</span>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th>Jenis Surat</th>
                    <th>Keperluan</th>
                    <th>Tanggal Diajukan</th>
                    <th>Nomor Surat Resmi</th>
                    <th>Status Berkas</th>
                    <th class="text-end">Aksi Dokumen</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($surat_saya)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <div class="p-4">
                                <i class="bi bi-file-earmark-excel fs-1 text-muted d-block mb-3"></i>
                                <h6 class="fw-bold text-dark">Belum Ada Pengajuan Surat</h6>
                                <p class="text-muted small mb-3">Anda belum pernah mengajukan permohonan surat administrasi desa.</p>
                                <a href="<?= base_url('surat/tambah') ?>" class="btn btn-primary-custom btn-sm px-4 py-2">
                                    <i class="bi bi-plus-lg me-1"></i> Ajukan Surat Sekarang
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($surat_saya as $row): ?>
                        <tr>
                            <td>
                                <div class="fw-bold text-dark"><?= esc($row['nama_surat'] ?? $row['jenis_surat']) ?></div>
                                <span class="badge bg-light text-muted border small"><?= esc($row['kode_surat'] ?? $row['jenis_surat']) ?></span>
                            </td>
                            <td>
                                <span class="text-dark small d-block"><?= esc($row['keperluan']) ?></span>
                                <?php if ($row['status'] === 'Ditolak' && !empty($row['catatan_revisi'])): ?>
                                    <div class="alert alert-danger py-1 px-2 small mt-1 mb-0" style="font-size: 0.75rem;">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i> Catatan: <?= esc($row['catatan_revisi']) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="text-muted small">
                                <i class="bi bi-clock me-1"></i> <?= date('d M Y, H:i', strtotime($row['tanggal_pengajuan'])) ?>
                            </td>
                            <td>
                                <?php if (!empty($row['no_surat'])): ?>
                                    <span class="font-monospace small fw-bold text-teal" style="color: #0f766e;"><?= esc($row['no_surat']) ?></span>
                                <?php else: ?>
                                    <span class="text-muted small font-italic">- Menunggu Approval -</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php 
                                    $stClass = match($row['status']) {
                                        'Pending' => 'badge-status-pending',
                                        'Proses' => 'badge-status-proses',
                                        'Disetujui' => 'badge-status-disetujui',
                                        'Ditolak' => 'badge-status-ditolak',
                                        default => 'bg-secondary text-white'
                                    };
                                    $stIcon = match($row['status']) {
                                        'Pending' => 'bi-hourglass-split',
                                        'Proses' => 'bi-arrow-repeat',
                                        'Disetujui' => 'bi-check-circle-fill',
                                        'Ditolak' => 'bi-x-circle-fill',
                                        default => 'bi-info-circle'
                                    };
                                ?>
                                <span class="badge px-3 py-2 rounded-pill <?= $stClass ?> small fw-semibold">
                                    <i class="bi <?= $stIcon ?> me-1"></i> <?= esc($row['status']) ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="<?= base_url('surat/detail/' . $row['id_pengajuan']) ?>" class="btn btn-sm btn-light border py-1 px-2" title="Detail Pengajuan">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                    <?php if ($row['status'] === 'Disetujui'): ?>
                                        <a href="<?= base_url('surat/cetak/' . $row['id_pengajuan']) ?>" target="_blank" class="btn btn-sm btn-success py-1 px-3 fw-semibold shadow-sm" title="Cetak / Unduh Dokumen Resmi">
                                            <i class="bi bi-printer-fill me-1"></i> Cetak
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL 1: LIHAT DATA ANGGOTA KELUARGA (KK)  -->
<!-- ========================================== -->
<div class="modal fade" id="modalDataKeluarga" tabindex="-1" aria-labelledby="modalDataKeluargaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom pb-3" style="background: #f8fafc;">
                <div class="d-flex align-items-center gap-2">
                    <div class="p-2 rounded-3 text-white" style="background: linear-gradient(135deg, #0f766e, #14b8a6);">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark" id="modalDataKeluargaLabel">Daftar Anggota Keluarga Terdaftar</h5>
                        <small class="text-muted">Nomor KK: <span class="font-monospace fw-bold text-dark"><?= esc($penduduk['no_kk'] ?? '-') ?></span></small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-toggle="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <div class="alert alert-info border-0 rounded-3 small mb-3">
                    <i class="bi bi-info-circle-fill me-1"></i> Data di bawah ini bersumber langsung dari pangkalan data kependudukan resmi Desa Jampang. Jika terdapat kekeliruan data, silakan laporkan ke kantor desa.
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light small text-uppercase">
                            <tr>
                                <th>Nama Lengkap</th>
                                <th>NIK</th>
                                <th>JK</th>
                                <th>Hubungan (SHDK)</th>
                                <th>Pekerjaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($anggota_keluarga)): ?>
                                <?php foreach ($anggota_keluarga as $ak): ?>
                                    <tr class="<?= ($ak['nik'] === session()->get('nik')) ? 'table-warning' : '' ?>">
                                        <td>
                                            <strong class="text-dark"><?= esc($ak['nama_lengkap']) ?></strong>
                                            <?php if ($ak['nik'] === session()->get('nik')): ?>
                                                <span class="badge bg-warning text-dark ms-1" style="font-size: 0.65rem;">Akun Anda</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="font-monospace small"><?= esc($ak['nik']) ?></td>
                                        <td><?= ($ak['jenis_kelamin'] === 'L') ? 'Laki-laki' : 'Perempuan' ?></td>
                                        <td>
                                            <span class="badge bg-light text-dark border"><?= esc($ak['shdk']) ?></span>
                                        </td>
                                        <td class="small text-muted"><?= esc($ak['pekerjaan']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">Tidak ada data anggota keluarga lain dalam database.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-secondary rounded-3 btn-sm px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL 2: DETAIL PENGUMUMAN DESA            -->
<!-- ========================================== -->
<div class="modal fade" id="modalDetailPengumuman" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <div class="p-2 rounded-3 text-white" style="background: linear-gradient(135deg, #0f766e, #14b8a6);">
                        <i class="bi bi-megaphone-fill"></i>
                    </div>
                    <div>
                        <span class="badge bg-primary-subtle text-primary rounded-pill small" id="mKategori">Pengumuman</span>
                        <h6 class="modal-title fw-bold text-dark mt-1" id="mJudul">Judul Pengumuman</h6>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <div class="p-3 rounded-3 bg-light border mb-3 small">
                    <div class="row g-2">
                        <div class="col-6">
                            <span class="text-muted d-block" style="font-size: 0.72rem;">Tanggal & Waktu</span>
                            <strong id="mTanggalWaktu" class="text-dark">-</strong>
                        </div>
                        <div class="col-6">
                            <span class="text-muted d-block" style="font-size: 0.72rem;">Lokasi Kegiatan</span>
                            <strong id="mLokasi" class="text-dark">-</strong>
                        </div>
                    </div>
                </div>

                <div class="text-dark lh-base" id="mIsi" style="font-size: 0.95rem; white-space: pre-line;">
                    Konten isi pengumuman...
                </div>

                <div class="border-top pt-3 mt-4 d-flex justify-content-between align-items-center">
                    <small class="text-muted">Diterbitkan oleh: <strong id="mPenulis" class="text-teal" style="color: #0f766e;">Pemerintah Desa</strong></small>
                    <a href="#" id="mBtnWa" target="_blank" class="btn btn-sm btn-success rounded-3 px-3">
                        <i class="bi bi-whatsapp me-1"></i> Bagikan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL 3: DIREKTORI KONTAK DARURAT DESA     -->
<!-- ========================================== -->
<div class="modal fade" id="modalKontakDarurat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <div class="p-2 rounded-3 text-white bg-danger">
                        <i class="bi bi-telephone-plus-fill"></i>
                    </div>
                    <div>
                        <h6 class="modal-title fw-bold text-dark">Layanan Bantuan Cepat & Darurat</h6>
                        <small class="text-muted">Desa Jampang, Kecamatan Kemang, Kab. Bogor</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <p class="text-muted small mb-3">Klik tombol untuk langsung menelepon atau menghubungi via WhatsApp petugas siaga:</p>

                <div class="d-flex flex-column gap-3">
                    <?php foreach ($kontak_darurat as $kd): ?>
                        <div class="p-3 rounded-3 border bg-light d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-danger-subtle text-danger rounded-pill" style="font-size: 0.7rem;"><?= esc($kd['badge']) ?></span>
                                <h6 class="fw-bold text-dark mb-0 mt-1"><?= esc($kd['instansi']) ?></h6>
                                <small class="text-muted"><?= esc($kd['petugas']) ?></small>
                                <div class="font-monospace text-teal fw-bold" style="color: #0f766e;"><?= esc($kd['nomor']) ?></div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="https://wa.me/<?= esc($kd['wa']) ?>" target="_blank" class="btn btn-sm btn-success rounded-3 px-3" title="Chat WhatsApp">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                                <a href="tel:<?= esc(str_replace(['-', ' '], '', $kd['nomor'])) ?>" class="btn btn-sm btn-outline-secondary rounded-3 px-3" title="Telepon">
                                    <i class="bi bi-telephone-fill"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Handler Interactive Modal Detail Pengumuman
    document.querySelectorAll('.btn-detail-pengumuman').forEach(btn => {
        btn.addEventListener('click', function() {
            const judul = this.getAttribute('data-judul');
            const kategori = this.getAttribute('data-kategori');
            const tanggal = this.getAttribute('data-tanggal');
            const waktu = this.getAttribute('data-waktu');
            const lokasi = this.getAttribute('data-lokasi');
            const penulis = this.getAttribute('data-penulis');
            const isi = this.getAttribute('data-isi');

            document.getElementById('mJudul').innerText = judul;
            document.getElementById('mKategori').innerText = kategori;
            document.getElementById('mTanggalWaktu').innerText = tanggal + ' (' + waktu + ')';
            document.getElementById('mLokasi').innerText = lokasi;
            document.getElementById('mPenulis').innerText = penulis;
            document.getElementById('mIsi').innerText = isi;

            const waText = encodeURIComponent('*PENGUMUMAN DESA JAMPANG*\n*' + judul + '*\n\n' + isi + '\n\nLokasi: ' + lokasi);
            document.getElementById('mBtnWa').href = 'https://api.whatsapp.com/send?text=' + waText;

            const modal = new bootstrap.Modal(document.getElementById('modalDetailPengumuman'));
            modal.show();
        });
    });
</script>

<?= $this->endSection() ?>
