<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row g-4">
    <!-- Left Column: Profile Card -->
    <div class="col-lg-4">
        <div class="card-custom text-center p-4 mb-4">
            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem; background: linear-gradient(135deg, #0f766e, #14b8a6);">
                <?= strtoupper(substr($penduduk['nama_lengkap'], 0, 1)) ?>
            </div>
            <h5 class="fw-bold text-dark mb-1"><?= esc($penduduk['nama_lengkap']) ?></h5>
            <div class="font-monospace text-muted small mb-2">NIK: <?= esc($penduduk['nik']) ?></div>
            
            <div class="d-flex justify-content-center gap-2 mb-3">
                <span class="badge <?= ($penduduk['jenis_kelamin'] === 'L') ? 'bg-primary-subtle text-primary' : 'bg-danger-subtle text-danger' ?> px-2 py-1">
                    <?= ($penduduk['jenis_kelamin'] === 'L') ? 'Laki-Laki' : 'Perempuan' ?>
                </span>
                <?php 
                    $stBadge = match($penduduk['status_penduduk']) {
                        'Ada' => 'bg-success-subtle text-success',
                        'Pindah' => 'bg-warning-subtle text-warning',
                        'Meninggal' => 'bg-danger-subtle text-danger',
                        default => 'bg-secondary'
                    };
                ?>
                <span class="badge <?= $stBadge ?> px-2 py-1"><?= esc($penduduk['status_penduduk']) ?></span>
            </div>

            <div class="border-top pt-3 text-start small">
                <div class="mb-2"><strong>No. Kartu Keluarga:</strong><br>
                    <a href="<?= base_url('kartu-keluarga/detail/' . $penduduk['no_kk']) ?>" class="font-monospace text-decoration-none fw-bold" style="color: #0f766e;">
                        <?= esc($penduduk['no_kk']) ?> <i class="bi bi-box-arrow-up-right ms-1"></i>
                    </a>
                </div>
                <div class="mb-2"><strong>Kepala Keluarga:</strong><br><?= esc($penduduk['nama_kepala_keluarga'] ?: 'Belum Ditentukan') ?></div>
                <div class="mb-2"><strong>Kedudukan (SHDK):</strong><br><?= esc($penduduk['shdk']) ?></div>
                <div class="mb-2"><strong>Alamat Domisili:</strong><br><?= esc($penduduk['alamat']) ?>, RT <?= esc($penduduk['rt']) ?> / RW <?= esc($penduduk['rw']) ?></div>
            </div>

            <div class="d-grid gap-2 mt-3 pt-3 border-top">
                <a href="<?= base_url('penduduk/edit/' . $penduduk['nik']) ?>" class="btn btn-outline-primary btn-sm rounded-3">
                    <i class="bi bi-pencil me-1"></i> Edit Data Warga
                </a>
                <a href="<?= base_url('surat/tambah?nik=' . $penduduk['nik']) ?>" class="btn btn-primary-custom btn-sm">
                    <i class="bi bi-file-earmark-plus me-1"></i> Buatkan Surat
                </a>
            </div>
        </div>
    </div>

    <!-- Right Column: Details & Histories -->
    <div class="col-lg-8">
        <!-- Biodata Lengkap -->
        <div class="card-custom p-4 mb-4">
            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-card-text text-teal me-2" style="color: #0f766e;"></i> Biodata Lengkap Penduduk</h6>
            
            <div class="row g-3 small">
                <div class="col-sm-6">
                    <span class="text-muted d-block">Tempat, Tanggal Lahir</span>
                    <strong class="text-dark"><?= esc($penduduk['tempat_lahir']) ?>, <?= date('d F Y', strtotime($penduduk['tanggal_lahir'])) ?></strong>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted d-block">Agama</span>
                    <strong class="text-dark"><?= esc($penduduk['agama']) ?></strong>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted d-block">Status Perkawinan</span>
                    <strong class="text-dark"><?= esc($penduduk['status_perkawinan']) ?></strong>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted d-block">Golongan Darah</span>
                    <strong class="text-dark"><?= esc($penduduk['golongan_darah'] ?: '-') ?></strong>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted d-block">Pendidikan Terakhir</span>
                    <strong class="text-dark"><?= esc($penduduk['pendidikan_terakhir']) ?></strong>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted d-block">Pekerjaan</span>
                    <strong class="text-dark"><?= esc($penduduk['pekerjaan']) ?></strong>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted d-block">Kewarganegaraan</span>
                    <strong class="text-dark"><?= esc($penduduk['kewarganegaraan']) ?></strong>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted d-block">Wilayah Administratif</span>
                    <strong class="text-dark">Desa <?= esc($penduduk['desa_kelurahan']) ?>, Kec. <?= esc($penduduk['kecamatan']) ?></strong>
                </div>
            </div>
        </div>

        <!-- Riwayat Mutasi Warga -->
        <div class="card-custom mb-4">
            <div class="card-header-custom">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-arrow-left-right text-teal me-2" style="color: #0f766e;"></i> Riwayat Peristiwa Mutasi</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>Peristiwa</th>
                            <th>Tanggal Peristiwa</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($mutasi)): ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3 small">Tidak ada riwayat mutasi khusus yang tercatat.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($mutasi as $m): ?>
                                <tr>
                                    <td><span class="badge bg-secondary-subtle text-secondary"><?= esc($m['jenis_mutasi']) ?></span></td>
                                    <td class="small"><?= date('d M Y', strtotime($m['tanggal_mutasi'])) ?></td>
                                    <td class="small text-muted"><?= esc($m['keterangan']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Riwayat Layanan Surat Warga -->
        <div class="card-custom">
            <div class="card-header-custom">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-file-earmark-check text-teal me-2" style="color: #0f766e;"></i> Riwayat Permohonan Surat</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>Jenis Surat</th>
                            <th>Nomor Surat</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($surat)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3 small">Belum pernah mengajukan surat.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($surat as $s): ?>
                                <tr>
                                    <td class="fw-semibold small"><?= esc($s['nama_surat'] ?? $s['jenis_surat']) ?></td>
                                    <td class="font-monospace small text-primary"><?= esc($s['no_surat'] ?: '-') ?></td>
                                    <td class="text-muted small"><?= date('d/m/Y', strtotime($s['tanggal_pengajuan'])) ?></td>
                                    <td>
                                        <span class="badge px-2 py-1 <?= match($s['status']) { 'Disetujui' => 'badge-status-disetujui', 'Pending' => 'badge-status-pending', 'Proses' => 'badge-status-proses', default => 'badge-status-ditolak' } ?> small">
                                            <?= esc($s['status']) ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="<?= base_url('surat/detail/' . $s['id_pengajuan']) ?>" class="btn btn-sm btn-light border py-1 px-2">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
