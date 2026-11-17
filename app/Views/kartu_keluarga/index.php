<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="card-custom mb-4">
    <div class="card-header-custom">
        <div>
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-card-heading text-teal me-2" style="color: #0f766e;"></i> Data Kartu Keluarga (KK)</h5>
            <span class="text-muted small">Kelola data kepala keluarga dan anggota dalam susunan kartu keluarga desa.</span>
        </div>
        <a href="<?= base_url('kartu-keluarga/tambah') ?>" class="btn btn-primary-custom btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah KK Baru
        </a>
    </div>

    <!-- Filter Form -->
    <div class="p-3 bg-light border-bottom">
        <form action="<?= base_url('kartu-keluarga') ?>" method="GET" class="row g-2 align-items-center">
            <div class="col-md-6">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Cari No. KK, Nama Kepala Keluarga, atau Alamat..." value="<?= esc($search ?? '') ?>">
                </div>
            </div>
            <div class="col-md-3">
                <select name="rt" class="form-select form-select-sm">
                    <option value="">-- Semua RT --</option>
                    <?php foreach ($rtList as $r): ?>
                        <option value="<?= esc($r) ?>" <?= ($rt == $r) ? 'selected' : '' ?>>RT <?= esc($r) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-1">
                <button type="submit" class="btn btn-sm text-white w-100" style="background-color: #0f766e;">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                <a href="<?= base_url('kartu-keluarga') ?>" class="btn btn-sm btn-outline-secondary">
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
                    <th>Nomor KK</th>
                    <th>Kepala Keluarga</th>
                    <th>Alamat Domisili</th>
                    <th>RT / RW</th>
                    <th>Anggota Aktif</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($dataKK)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-card-heading fs-2 text-muted d-block mb-2"></i>
                            Tidak ada data Kartu Keluarga ditemukan.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($dataKK as $row): ?>
                        <tr>
                            <td>
                                <a href="<?= base_url('kartu-keluarga/detail/' . $row['no_kk']) ?>" class="fw-bold font-monospace text-decoration-none" style="color: #0f766e;">
                                    <?= esc($row['no_kk']) ?>
                                </a>
                            </td>
                            <td>
                                <?php if (!empty($row['nama_kepala_keluarga'])): ?>
                                    <div class="fw-semibold text-dark"><?= esc($row['nama_kepala_keluarga']) ?></div>
                                    <div class="text-muted small">NIK: <?= esc($row['nik_kepala_keluarga']) ?></div>
                                <?php else: ?>
                                    <span class="badge bg-warning-subtle text-warning small">Belum Ditentukan</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="small text-dark"><?= esc($row['alamat']) ?></div>
                                <div class="text-muted small">Desa <?= esc($row['desa_kelurahan']) ?></div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">RT <?= esc($row['rt']) ?> / RW <?= esc($row['rw']) ?></span>
                            </td>
                            <td>
                                <span class="badge bg-teal-subtle text-teal px-2 py-1" style="background-color: #f0fdfa; color: #0f766e;">
                                    <i class="bi bi-people me-1"></i> <?= $row['jumlah_anggota'] ?> Jiwa
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="<?= base_url('kartu-keluarga/detail/' . $row['no_kk']) ?>" class="btn btn-sm btn-light border py-1 px-2" title="Lihat Anggota Keluarga">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                    <a href="<?= base_url('kartu-keluarga/edit/' . $row['no_kk']) ?>" class="btn btn-sm btn-light border py-1 px-2 text-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= base_url('kartu-keluarga/hapus/' . $row['no_kk']) ?>" class="btn btn-sm btn-light border py-1 px-2 text-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data KK ini?');">
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

<?= $this->endSection() ?>
