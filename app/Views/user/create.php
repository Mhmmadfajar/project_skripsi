<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card-custom mb-4">
            <div class="card-header-custom">
                <div>
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-person-plus text-teal me-2" style="color: #0f766e;"></i> Tambah Pengguna Baru</h5>
                    <span class="text-muted small">Buat akun petugas desa atau kepala desa.</span>
                </div>
                <a href="<?= base_url('user') ?>" class="btn btn-outline-secondary btn-sm rounded-3">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="p-4">
                <form action="<?= base_url('user/simpan') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Lengkap Petugas <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Petugas" value="<?= old('nama_lengkap') ?>" required autofocus>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control" placeholder="Username unik" value="<?= old('username') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="petugas@desa.id" value="<?= old('email') ?>">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Peran / Hak Akses (Role) <span class="text-danger">*</span></label>
                            <select name="role" class="form-select" required>
                                <option value="staf">Staf Pelayanan / Operator Desa</option>
                                <option value="kades">Kepala Desa (Approval)</option>
                                <option value="admin">Administrator Sistem</option>
                                <option value="warga">Warga</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">NIK (Wajib jika peran Warga)</label>
                            <input type="text" name="nik" class="form-control" maxlength="16" placeholder="16 digit NIK">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Kata Sandi (Password) <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('user') ?>" class="btn btn-light border px-4">Batal</a>
                        <button type="submit" class="btn btn-primary-custom px-4">
                            <i class="bi bi-save me-1"></i> Simpan Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
