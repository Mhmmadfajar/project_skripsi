<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Summary Pills -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <a href="<?= base_url('surat?status=Semua') ?>" class="text-decoration-none">
            <div class="card-custom p-3 text-center <?= ($status === 'Semua') ? 'border-primary shadow-sm' : '' ?>">
                <span class="text-muted small fw-semibold">Semua Pengajuan</span>
                <h4 class="fw-bold mb-0 text-dark"><?= $statistik['total'] ?></h4>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="<?= base_url('surat?status=Pending') ?>" class="text-decoration-none">
            <div class="card-custom p-3 text-center <?= ($status === 'Pending') ? 'border-warning shadow-sm' : '' ?>">
                <span class="text-warning small fw-semibold">Menunggu Verifikasi</span>
                <h4 class="fw-bold mb-0 text-warning"><?= $statistik['pending'] ?></h4>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="<?= base_url('surat?status=Proses') ?>" class="text-decoration-none">
            <div class="card-custom p-3 text-center <?= ($status === 'Proses') ? 'border-info shadow-sm' : '' ?>">
                <span class="text-info small fw-semibold">Sedang Diproses</span>
                <h4 class="fw-bold mb-0 text-info"><?= $statistik['proses'] ?></h4>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="<?= base_url('surat?status=Disetujui') ?>" class="text-decoration-none">
            <div class="card-custom p-3 text-center <?= ($status === 'Disetujui') ? 'border-success shadow-sm' : '' ?>">
                <span class="text-success small fw-semibold">Telah Disetujui</span>
                <h4 class="fw-bold mb-0 text-success"><?= $statistik['disetujui'] ?></h4>
            </div>
        </a>
    </div>
</div>

<div class="card-custom mb-4">
    <div class="card-header-custom">
        <div>
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-file-earmark-text-fill text-teal me-2" style="color: #0f766e;"></i> Layanan Surat Menyurat Terpadu</h5>
            <span class="text-muted small">Kelola alur verifikasi berkas, persetujuan Kepala Desa, dan penerbitan surat resmi ber-QR Code.</span>
        </div>
        <a href="<?= base_url('surat/tambah') ?>" class="btn btn-primary-custom btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Buat Permohonan Baru
        </a>
    </div>

    <!-- Search Bar -->
    <div class="p-3 bg-light border-bottom">
        <form action="<?= base_url('surat') ?>" method="GET" class="row g-2 align-items-center">
            <input type="hidden" name="status" value="<?= esc($status) ?>">
            <div class="col-md-9">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Cari nomor surat, NIK, nama pemohon, atau jenis surat..." value="<?= esc($search ?? '') ?>">
                </div>
            </div>
            <div class="col-md-3 d-flex gap-1">
                <button type="submit" class="btn btn-sm text-white w-100" style="background-color: #0f766e;">
                    <i class="bi bi-search me-1"></i> Cari
                </button>
                <a href="<?= base_url('surat') ?>" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th>Pemohon</th>
                    <th>Jenis Surat</th>
                    <th>Keperluan</th>
                    <th>Tanggal Diajukan</th>
                    <th>Nomor Surat</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pengajuan)): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-2 text-muted d-block mb-2"></i>
                            Tidak ada data pengajuan surat yang sesuai kriteria.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pengajuan as $s): ?>
                        <tr>
                            <td>
                                <div class="fw-bold text-dark"><?= esc($s['nama_pemohon'] ?? 'Pemohon') ?></div>
                                <div class="text-muted small">NIK: <?= esc($s['nik_pemohon']) ?></div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark"><?= esc($s['nama_surat'] ?? $s['jenis_surat']) ?></div>
                                <span class="badge bg-light text-muted border small"><?= esc($s['kode_surat'] ?? $s['jenis_surat']) ?></span>
                            </td>
                            <td>
                                <span class="text-muted small"><?= esc(mb_strimwidth($s['keperluan'], 0, 45, '...')) ?></span>
                            </td>
                            <td class="text-muted small">
                                <?= date('d M Y, H:i', strtotime($s['tanggal_pengajuan'])) ?>
                            </td>
                            <td>
                                <?php if (!empty($s['no_surat'])): ?>
                                    <span class="font-monospace small fw-bold text-primary"><?= esc($s['no_surat']) ?></span>
                                <?php else: ?>
                                    <span class="text-muted small">- Belum Terbit -</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php 
                                    $stClass = match($s['status']) {
                                        'Pending' => 'badge-status-pending',
                                        'Proses' => 'badge-status-proses',
                                        'Disetujui' => 'badge-status-disetujui',
                                        'Ditolak' => 'badge-status-ditolak',
                                        default => 'bg-secondary text-white'
                                    };
                                ?>
                                <span class="badge px-2 py-1 rounded-pill <?= $stClass ?>"><?= esc($s['status']) ?></span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="<?= base_url('surat/detail/' . $s['id_pengajuan']) ?>" class="btn btn-sm btn-light border py-1 px-2" title="Detail Permohonan">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                    <?php if ($s['status'] === 'Disetujui'): ?>
                                        <a href="<?= base_url('surat/cetak/' . $s['id_pengajuan']) ?>" target="_blank" class="btn btn-sm btn-success py-1 px-2" title="Cetak Surat Ber-QR Code">
                                            <i class="bi bi-printer"></i>
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

<?= $this->endSection() ?>
