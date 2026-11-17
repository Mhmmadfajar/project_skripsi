<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="card-custom mb-4">
    <div class="card-header-custom">
        <div>
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-bar-chart-line-fill text-teal me-2" style="color: #0f766e;"></i> Laporan & Rekapitulasi Kependudukan</h5>
            <span class="text-muted small">Statistik demografi agregat, piramida usia, dan performa pelayanan surat desa.</span>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= base_url('penduduk/export') ?>" class="btn btn-outline-success btn-sm rounded-3">
                <i class="bi bi-file-earmark-excel me-1"></i> Ekspor CSV
            </a>
            <a href="<?= base_url('laporan/cetak') ?>" target="_blank" class="btn btn-primary-custom btn-sm">
                <i class="bi bi-printer me-1"></i> Cetak Laporan Resmi
            </a>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="p-4 border-bottom bg-light">
        <div class="row g-3">
            <div class="col-sm-6 col-lg-3">
                <div class="card p-3 border-0 shadow-sm rounded-3">
                    <span class="text-muted small">Total Penduduk</span>
                    <h3 class="fw-bold mb-0 text-dark"><?= number_format($statistik['total']) ?> <small class="fs-6 text-muted">Jiwa</small></h3>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card p-3 border-0 shadow-sm rounded-3">
                    <span class="text-muted small">Total Kartu Keluarga</span>
                    <h3 class="fw-bold mb-0 text-dark"><?= number_format($totalKk) ?> <small class="fs-6 text-muted">KK</small></h3>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card p-3 border-0 shadow-sm rounded-3">
                    <span class="text-muted small">Laki-Laki</span>
                    <h3 class="fw-bold mb-0 text-primary"><?= number_format($statistik['laki']) ?> <small class="fs-6 text-muted">Jiwa</small></h3>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card p-3 border-0 shadow-sm rounded-3">
                    <span class="text-muted small">Perempuan</span>
                    <h3 class="fw-bold mb-0 text-danger"><?= number_format($statistik['perempuan']) ?> <small class="fs-6 text-muted">Jiwa</small></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Breakdown -->
    <div class="p-4">
        <div class="row g-4">
            <!-- Age & Religion -->
            <div class="col-lg-6">
                <div class="border rounded-4 p-3 mb-4">
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-people me-1 text-teal" style="color: #0f766e;"></i> Distribusi Kelompok Usia</h6>
                    <table class="table table-sm small mb-0">
                        <tr>
                            <td>Balita (0 - 5 tahun)</td>
                            <td class="text-end fw-bold"><?= (int) ($statistik['usia']['balita'] ?? 0) ?> Jiwa</td>
                        </tr>
                        <tr>
                            <td>Anak-Anak (6 - 17 tahun)</td>
                            <td class="text-end fw-bold"><?= (int) ($statistik['usia']['anak'] ?? 0) ?> Jiwa</td>
                        </tr>
                        <tr>
                            <td>Usia Produktif (18 - 59 tahun)</td>
                            <td class="text-end fw-bold"><?= (int) ($statistik['usia']['produktif'] ?? 0) ?> Jiwa</td>
                        </tr>
                        <tr>
                            <td>Lanjut Usia (60+ tahun)</td>
                            <td class="text-end fw-bold"><?= (int) ($statistik['usia']['lansia'] ?? 0) ?> Jiwa</td>
                        </tr>
                    </table>
                </div>

                <div class="border rounded-4 p-3">
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-geo me-1 text-teal" style="color: #0f766e;"></i> Distribusi Penduduk per RT</h6>
                    <table class="table table-sm small mb-0">
                        <?php if (empty($statistik['distribusi_rt'])): ?>
                            <tr><td colspan="2" class="text-muted text-center">Data RT belum lengkap.</td></tr>
                        <?php else: ?>
                            <?php foreach ($statistik['distribusi_rt'] as $drt): ?>
                                <tr>
                                    <td><?= esc($drt['nama_rt']) ?></td>
                                    <td class="text-end fw-bold"><?= $drt['jumlah'] ?> Jiwa</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </table>
                </div>
            </div>

            <!-- Letter & Mutation Breakdown -->
            <div class="col-lg-6">
                <div class="border rounded-4 p-3 mb-4">
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-file-earmark-check me-1 text-teal" style="color: #0f766e;"></i> Rekapitulasi Pelayanan Surat</h6>
                    <table class="table table-sm small mb-0">
                        <thead>
                            <tr class="text-muted">
                                <th>Jenis Surat</th>
                                <th class="text-center">Total Diajukan</th>
                                <th class="text-end">Disetujui</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($suratPerJenis as $spj): ?>
                                <tr>
                                    <td><?= esc($spj['nama_surat']) ?></td>
                                    <td class="text-center"><?= $spj['total'] ?></td>
                                    <td class="text-end fw-bold text-success"><?= $spj['disetujui'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="border rounded-4 p-3">
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-arrow-left-right me-1 text-teal" style="color: #0f766e;"></i> Rekapitulasi Mutasi Penduduk (Tahun Berjalan)</h6>
                    <table class="table table-sm small mb-0">
                        <?php if (empty($statMutasi)): ?>
                            <tr><td colspan="2" class="text-muted text-center">Belum ada mutasi tahun ini.</td></tr>
                        <?php else: ?>
                            <?php foreach ($statMutasi as $sm): ?>
                                <tr>
                                    <td><?= esc($sm['jenis_mutasi']) ?></td>
                                    <td class="text-end fw-bold"><?= $sm['total'] ?> Peristiwa</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
