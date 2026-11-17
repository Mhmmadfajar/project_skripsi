<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="card-custom mb-4">
    <div class="card-header-custom">
        <div>
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-person-gear text-teal me-2" style="color: #0f766e;"></i> Manajemen Pengguna Sistem</h5>
            <span class="text-muted small">Kelola hak akses akun petugas desa, kepala desa, dan warga.</span>
        </div>
        <a href="<?= base_url('user/tambah') ?>" class="btn btn-primary-custom btn-sm">
            <i class="bi bi-person-plus me-1"></i> Tambah Pengguna
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Peran (Role)</th>
                    <th>NIK Terkait</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td>
                            <strong class="text-dark font-monospace">@<?= esc($u['username']) ?></strong>
                        </td>
                        <td><?= esc($u['nama_lengkap']) ?></td>
                        <td class="text-muted small"><?= esc($u['email'] ?: '-') ?></td>
                        <td>
                            <span class="badge badge-role-<?= esc($u['role']) ?> px-2 py-1 text-uppercase fw-bold" style="font-size: 0.75rem;">
                                <?= esc($u['role']) ?>
                            </span>
                        </td>
                        <td class="font-monospace small text-muted"><?= esc($u['nik'] ?: '-') ?></td>
                        <td>
                            <?php if ($u['is_active']): ?>
                                <span class="badge bg-success-subtle text-success small">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-danger-subtle text-danger small">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <?php if ($u['id_user'] != session()->get('id_user')): ?>
                                <a href="<?= base_url('user/toggle/' . $u['id_user']) ?>" class="btn btn-sm <?= $u['is_active'] ? 'btn-outline-danger' : 'btn-outline-success' ?> py-1 px-2" title="Ubah Status">
                                    <i class="bi <?= $u['is_active'] ? 'bi-lock' : 'bi-unlock' ?>"></i>
                                    <?= $u['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>
                                </a>
                            <?php else: ?>
                                <span class="badge bg-light text-muted border">Akun Anda</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
