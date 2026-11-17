<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="card-custom mb-4">
    <div class="card-header-custom">
        <div>
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-people-fill text-teal me-2" style="color: #0f766e;"></i> Master Data Kependudukan</h5>
            <span class="text-muted small">Kelola seluruh data warga desa secara terintegrasi dan akurat.</span>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-outline-primary btn-sm rounded-3" data-bs-toggle="modal" data-bs-target="#modalImport">
                <i class="bi bi-file-earmark-arrow-up me-1"></i> Impor Excel / CSV
            </button>
            <a href="<?= base_url('penduduk/export') ?>" class="btn btn-outline-success btn-sm rounded-3">
                <i class="bi bi-file-earmark-excel me-1"></i> Ekspor CSV / Excel
            </a>
            <a href="<?= base_url('penduduk/tambah') ?>" class="btn btn-primary-custom btn-sm">
                <i class="bi bi-person-plus-fill me-1"></i> Tambah Warga
            </a>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="p-3 bg-light border-bottom">
        <form action="<?= base_url('penduduk') ?>" method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Cari NIK, Nama, atau No. KK..." value="<?= esc($search ?? '') ?>">
                </div>
            </div>
            <div class="col-md-2 col-6">
                <select name="rt" class="form-select form-select-sm">
                    <option value="">-- Semua RT --</option>
                    <?php foreach ($rtList as $r): ?>
                        <option value="<?= esc($r) ?>" <?= ($rt == $r) ? 'selected' : '' ?>>RT <?= esc($r) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 col-6">
                <select name="jk" class="form-select form-select-sm">
                    <option value="">-- Jenis Kelamin --</option>
                    <option value="L" <?= ($jk == 'L') ? 'selected' : '' ?>>Laki-Laki</option>
                    <option value="P" <?= ($jk == 'P') ? 'selected' : '' ?>>Perempuan</option>
                </select>
            </div>
            <div class="col-md-2 col-6">
                <select name="status" class="form-select form-select-sm">
                    <option value="">-- Status Penduduk --</option>
                    <option value="Ada" <?= ($status == 'Ada') ? 'selected' : '' ?>>Ada (Aktif)</option>
                    <option value="Pindah" <?= ($status == 'Pindah') ? 'selected' : '' ?>>Pindah</option>
                    <option value="Meninggal" <?= ($status == 'Meninggal') ? 'selected' : '' ?>>Meninggal</option>
                </select>
            </div>
            <div class="col-md-2 col-6 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-teal text-white w-100" style="background-color: #0f766e;">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                <a href="<?= base_url('penduduk') ?>" class="btn btn-sm btn-outline-secondary">
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
                    <th>NIK / No. KK</th>
                    <th>Nama Lengkap</th>
                    <th>JK / Usia</th>
                    <th>Alamat / RT-RW</th>
                    <th>SHDK</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($penduduk)): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-people fs-2 text-muted d-block mb-2"></i>
                            Tidak ada data kependudukan yang cocok dengan filter pencarian.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($penduduk as $p): ?>
                        <?php 
                            $birthDate = new DateTime($p['tanggal_lahir']);
                            $today = new DateTime();
                            $age = $today->diff($birthDate)->y;
                        ?>
                        <tr>
                            <td>
                                <div class="fw-bold text-dark font-monospace"><?= esc($p['nik']) ?></div>
                                <div class="text-muted small">KK: <?= esc($p['no_kk']) ?></div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark"><?= esc($p['nama_lengkap']) ?></div>
                                <div class="text-muted small"><?= esc($p['pekerjaan']) ?></div>
                            </td>
                            <td>
                                <span class="badge <?= ($p['jenis_kelamin'] === 'L') ? 'bg-primary-subtle text-primary' : 'bg-danger-subtle text-danger' ?> small">
                                    <?= ($p['jenis_kelamin'] === 'L') ? 'L' : 'P' ?>
                                </span>
                                <span class="text-muted small ms-1"><?= $age ?> thn</span>
                            </td>
                            <td>
                                <div class="small text-dark"><?= esc($p['alamat'] ?: 'Desa Jampang') ?></div>
                                <div class="text-muted small">RT <?= esc($p['rt'] ?? '-') ?> / RW <?= esc($p['rw'] ?? '-') ?></div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border small"><?= esc($p['shdk']) ?></span>
                            </td>
                            <td>
                                <?php 
                                    $stColor = match($p['status_penduduk']) {
                                        'Ada' => 'bg-success-subtle text-success',
                                        'Pindah' => 'bg-warning-subtle text-warning',
                                        'Meninggal' => 'bg-danger-subtle text-danger',
                                        default => 'bg-secondary-subtle text-secondary'
                                    };
                                ?>
                                <span class="badge <?= $stColor ?> small"><?= esc($p['status_penduduk']) ?></span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="<?= base_url('penduduk/detail/' . $p['nik']) ?>" class="btn btn-sm btn-light border py-1 px-2" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?= base_url('penduduk/edit/' . $p['nik']) ?>" class="btn btn-sm btn-light border py-1 px-2 text-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= base_url('penduduk/hapus/' . $p['nik']) ?>" class="btn btn-sm btn-light border py-1 px-2 text-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data <?= esc($p['nama_lengkap']) ?>?');">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Import Excel / CSV -->
<div class="modal fade" id="modalImport" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0 shadow">
            <form action="<?= base_url('penduduk/import') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-bold text-dark"><i class="bi bi-file-earmark-arrow-up text-teal me-2" style="color: #0f766e;"></i> Impor Data Penduduk Massal</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="small text-muted mb-3">
                        Gunakan fitur ini untuk memigrasikan data kependudukan dalam jumlah banyak sekaligus dari format Excel / CSV.
                    </p>

                    <!-- Template Download Step -->
                    <div class="p-3 bg-light rounded-3 mb-3 border">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold small text-dark d-block">1. Unduh Template Standar</span>
                                <span class="text-muted" style="font-size: 0.75rem;">Format kolom telah disesuaikan dengan sistem desa.</span>
                            </div>
                            <a href="<?= base_url('penduduk/template') ?>" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-download me-1"></i> Download Template
                            </a>
                        </div>
                    </div>

                    <!-- File Upload Step -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">2. Unggah File Yang Sudah Diisi (.csv)</label>
                        <input type="file" name="file_excel" class="form-control" accept=".csv, text/csv, .txt" required>
                        <div class="form-text" style="font-size: 0.75rem;">
                            Pastikan file disimpan dalam format <strong>CSV (Comma Delimited)</strong> dari Microsoft Excel.
                        </div>
                    </div>

                    <div class="alert alert-info border-0 p-2 rounded-3 small mb-0" style="font-size: 0.76rem;">
                        <i class="bi bi-info-circle me-1"></i> <strong>Catatan Otomatisasi:</strong>
                        <ul class="mb-0 ps-3 mt-1">
                            <li>Nomor KK yang belum ada di sistem akan <strong>otomatis dibuatkan</strong>.</li>
                            <li>Warga dengan status 'Kepala Keluarga' otomatis dihubungkan ke KK tersebut.</li>
                            <li>Jika NIK sudah terdaftar, data warga akan diperbarui (update).</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-sm btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary-custom px-4 fw-semibold">
                        <i class="bi bi-upload me-1"></i> Mulai Proses Impor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
