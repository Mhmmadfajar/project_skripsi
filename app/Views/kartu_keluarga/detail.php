<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="card-custom mb-4">
    <div class="card-header-custom">
        <div>
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-card-heading text-teal me-2" style="color: #0f766e;"></i> Kartu Keluarga: <?= esc($kk['no_kk']) ?></h5>
            <span class="text-muted small">Informasi susunan keluarga dan anggota dalam satu kartu keluarga.</span>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= base_url('kartu-keluarga') ?>" class="btn btn-outline-secondary btn-sm rounded-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <a href="<?= base_url('kartu-keluarga/cetak/' . $kk['no_kk']) ?>" target="_blank" class="btn btn-outline-success btn-sm rounded-3">
                <i class="bi bi-printer me-1"></i> Cetak KK Resmi
            </a>
            <a href="<?= base_url('kartu-keluarga/edit/' . $kk['no_kk']) ?>" class="btn btn-outline-primary btn-sm rounded-3">
                <i class="bi bi-pencil me-1"></i> Edit KK
            </a>
            <a href="<?= base_url('penduduk/tambah?no_kk=' . $kk['no_kk']) ?>" class="btn btn-primary-custom btn-sm">
                <i class="bi bi-person-plus me-1"></i> Tambah Anggota
            </a>
        </div>
    </div>

    <!-- Header Details -->
    <div class="p-4 bg-light border-bottom">
        <div class="row g-3 small">
            <div class="col-md-3">
                <span class="text-muted d-block">Nomor Kartu Keluarga:</span>
                <strong class="font-monospace fs-6 text-dark"><?= esc($kk['no_kk']) ?></strong>
            </div>
            <div class="col-md-3">
                <span class="text-muted d-block">Kepala Keluarga:</span>
                <strong class="text-dark fs-6"><?= esc($kk['nama_kepala_keluarga'] ?: 'Belum Ditentukan') ?></strong>
            </div>
            <div class="col-md-3">
                <span class="text-muted d-block">Alamat Domisili:</span>
                <span class="text-dark"><?= esc($kk['alamat']) ?>, RT <?= esc($kk['rt']) ?> / RW <?= esc($kk['rw']) ?></span>
            </div>
            <div class="col-md-3">
                <span class="text-muted d-block">Desa / Kecamatan:</span>
                <span class="text-dark"><?= esc($kk['desa_kelurahan']) ?>, <?= esc($kk['kecamatan']) ?></span>
            </div>
        </div>
    </div>

    <!-- Family Members Table -->
    <div class="p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-people-fill text-teal me-2" style="color: #0f766e;"></i> Daftar Anggota Keluarga (<?= count($anggota) ?> Jiwa)</h6>
        </div>

        <div class="table-responsive">
            <table class="table table-custom border">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>JK</th>
                        <th>Hubungan (SHDK)</th>
                        <th>Tempat, Tanggal Lahir</th>
                        <th>Pendidikan</th>
                        <th>Pekerjaan</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($anggota)): ?>
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                Belum ada anggota keluarga yang terdaftar dalam KK ini.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($anggota as $a): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <a href="<?= base_url('penduduk/detail/' . $a['nik']) ?>" class="font-monospace text-decoration-none fw-bold" style="color: #0f766e;">
                                        <?= esc($a['nik']) ?>
                                    </a>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark"><?= esc($a['nama_lengkap']) ?></div>
                                </td>
                                <td>
                                    <span class="badge <?= ($a['jenis_kelamin'] === 'L') ? 'bg-primary-subtle text-primary' : 'bg-danger-subtle text-danger' ?> small">
                                        <?= $a['jenis_kelamin'] ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border small"><?= esc($a['shdk']) ?></span>
                                </td>
                                <td class="small">
                                    <?= esc($a['tempat_lahir']) ?>, <?= date('d/m/Y', strtotime($a['tanggal_lahir'])) ?>
                                </td>
                                <td class="small text-muted"><?= esc($a['pendidikan_terakhir']) ?></td>
                                <td class="small text-muted"><?= esc($a['pekerjaan']) ?></td>
                                <td>
                                    <span class="badge <?= ($a['status_penduduk'] === 'Ada') ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' ?> small">
                                        <?= esc($a['status_penduduk']) ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a href="<?= base_url('penduduk/detail/' . $a['nik']) ?>" class="btn btn-sm btn-light border py-1 px-2" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('penduduk/edit/' . $a['nik']) ?>" class="btn btn-sm btn-light border py-1 px-2 text-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
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
</div>

<?= $this->endSection() ?>
