<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Summary Cards for Mutations -->
<div class="row g-3 mb-4">
    <?php 
        $statArray = [];
        foreach ($statistik as $s) {
            $statArray[$s['jenis_mutasi']] = $s['total'];
        }
    ?>
    <div class="col-sm-6 col-xl-3">
        <div class="card-custom p-3 d-flex align-items-center gap-3">
            <div class="rounded-4 p-3 d-flex align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, #10b981, #34d399); width: 52px; height: 52px;">
                <i class="bi bi-gender-ambiguous fs-4"></i>
            </div>
            <div>
                <span class="text-muted small fw-semibold">Kelahiran</span>
                <h4 class="fw-bold mb-0 text-dark"><?= number_format($statArray['Kelahiran'] ?? 0) ?></h4>
                <span class="text-muted" style="font-size: 0.72rem;">Jiwa Baru</span>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card-custom p-3 d-flex align-items-center gap-3">
            <div class="rounded-4 p-3 d-flex align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, #64748b, #94a3b8); width: 52px; height: 52px;">
                <i class="bi bi-heartbreak fs-4"></i>
            </div>
            <div>
                <span class="text-muted small fw-semibold">Kematian</span>
                <h4 class="fw-bold mb-0 text-dark"><?= number_format($statArray['Kematian'] ?? 0) ?></h4>
                <span class="text-muted" style="font-size: 0.72rem;">Meninggal Dunia</span>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card-custom p-3 d-flex align-items-center gap-3">
            <div class="rounded-4 p-3 d-flex align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, #0284c7, #38bdf8); width: 52px; height: 52px;">
                <i class="bi bi-box-arrow-in-right fs-4"></i>
            </div>
            <div>
                <span class="text-muted small fw-semibold">Pindah Datang</span>
                <h4 class="fw-bold mb-0 text-dark"><?= number_format($statArray['Pindah Masuk'] ?? 0) ?></h4>
                <span class="text-muted" style="font-size: 0.72rem;">Penduduk Baru Masuk</span>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card-custom p-3 d-flex align-items-center gap-3">
            <div class="rounded-4 p-3 d-flex align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, #e11d48, #fb7185); width: 52px; height: 52px;">
                <i class="bi bi-box-arrow-right fs-4"></i>
            </div>
            <div>
                <span class="text-muted small fw-semibold">Pindah Keluar</span>
                <h4 class="fw-bold mb-0 text-dark"><?= number_format($statArray['Pindah Keluar'] ?? 0) ?></h4>
                <span class="text-muted" style="font-size: 0.72rem;">Keluar Wilayah</span>
            </div>
        </div>
    </div>
</div>

<div class="card-custom mb-4">
    <div class="card-header-custom">
        <div>
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-arrow-left-right text-teal me-2" style="color: #0f766e;"></i> Log Mutasi & Peristiwa Kependudukan</h5>
            <span class="text-muted small">Catat dan pantau perubahan status kependudukan warga desa.</span>
        </div>
        <a href="<?= base_url('mutasi/tambah') ?>" class="btn btn-primary-custom btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Catat Mutasi Baru
        </a>
    </div>

    <!-- Filter Form -->
    <div class="p-3 bg-light border-bottom">
        <form action="<?= base_url('mutasi') ?>" method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <select name="jenis" class="form-select form-select-sm">
                    <option value="">-- Semua Jenis Peristiwa --</option>
                    <option value="Kelahiran" <?= ($jenis === 'Kelahiran') ? 'selected' : '' ?>>Kelahiran</option>
                    <option value="Kematian" <?= ($jenis === 'Kematian') ? 'selected' : '' ?>>Kematian</option>
                    <option value="Pindah Masuk" <?= ($jenis === 'Pindah Masuk') ? 'selected' : '' ?>>Pindah Datang (Masuk)</option>
                    <option value="Pindah Keluar" <?= ($jenis === 'Pindah Keluar') ? 'selected' : '' ?>>Pindah Keluar</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="bulan" class="form-select form-select-sm">
                    <option value="">-- Semua Bulan --</option>
                    <?php 
                        $bulanArr = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                        foreach ($bulanArr as $k => $b):
                    ?>
                        <option value="<?= $k ?>" <?= ($bulan == $k) ? 'selected' : '' ?>><?= $b ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" name="tahun" class="form-control form-control-sm" placeholder="Tahun (Contoh: <?= date('Y') ?>)" value="<?= esc($tahun ?? '') ?>">
            </div>
            <div class="col-md-2 d-flex gap-1">
                <button type="submit" class="btn btn-sm text-white w-100" style="background-color: #0f766e;">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                <a href="<?= base_url('mutasi') ?>" class="btn btn-sm btn-outline-secondary">
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
                    <th>Peristiwa Mutasi</th>
                    <th>Warga Bersangkutan</th>
                    <th>Tanggal Peristiwa</th>
                    <th>Keterangan / Alasan</th>
                    <th>Petugas Pencatat</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($mutasiList)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-arrow-left-right fs-2 text-muted d-block mb-2"></i>
                            Belum ada riwayat mutasi kependudukan yang tercatat.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($mutasiList as $m): ?>
                        <tr>
                            <td>
                                <?php 
                                    $badgeM = match($m['jenis_mutasi']) {
                                        'Kelahiran' => 'bg-success-subtle text-success',
                                        'Kematian' => 'bg-dark-subtle text-dark',
                                        'Pindah Masuk' => 'bg-info-subtle text-info',
                                        'Pindah Keluar' => 'bg-danger-subtle text-danger',
                                        default => 'bg-secondary'
                                    };
                                ?>
                                <span class="badge <?= $badgeM ?> px-2 py-1 fw-bold"><?= esc($m['jenis_mutasi']) ?></span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark"><?= esc($m['nama_lengkap'] ?? 'Penduduk') ?></div>
                                <div class="text-muted small">NIK: <?= esc($m['nik']) ?></div>
                            </td>
                            <td class="small">
                                <?= date('d F Y', strtotime($m['tanggal_mutasi'])) ?>
                            </td>
                            <td class="small text-muted">
                                <?= esc($m['keterangan'] ?: '-') ?>
                            </td>
                            <td class="small text-muted">
                                <i class="bi bi-person me-1"></i> <?= esc($m['nama_petugas'] ?: 'Admin Sistem') ?>
                            </td>
                            <td class="text-end">
                                <a href="<?= base_url('mutasi/hapus/' . $m['id_mutasi']) ?>" class="btn btn-sm btn-light border py-1 px-2 text-danger" title="Hapus Riwayat" onclick="return confirm('Hapus catatan mutasi ini?');">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
