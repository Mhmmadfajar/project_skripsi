<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card-custom mb-4">
            <div class="card-header-custom">
                <div>
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-person-circle text-teal me-2" style="color: #0f766e;"></i> Pengaturan Profil Akun</h5>
                    <span class="text-muted small">Perbarui data diri dan kata sandi login Anda.</span>
                </div>
            </div>

            <div class="p-4">
                <form action="<?= base_url('profil') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Username</label>
                        <input type="text" class="form-control bg-light font-monospace" value="<?= esc($user['username']) ?>" readonly>
                        <div class="form-text" style="font-size: 0.75rem;">Username bersifat tetap dan tidak dapat diganti.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Peran Sistem (Role)</label>
                        <div>
                            <span class="badge badge-role-<?= esc($user['role']) ?> px-3 py-2 text-uppercase fw-bold">
                                <?= esc($user['role']) ?>
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" value="<?= esc(old('nama_lengkap', $user['nama_lengkap'])) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Alamat Email</label>
                        <input type="email" name="email" class="form-control" value="<?= esc(old('email', $user['email'])) ?>" placeholder="nama@email.com">
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-bold text-dark mb-2"><i class="bi bi-key me-1"></i> Ganti Kata Sandi (Password)</h6>
                    <p class="small text-muted mb-3">Biarkan kosong jika tidak ingin mengubah password Anda saat ini.</p>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Kata Sandi Baru</label>
                        <input type="password" name="password" class="form-control" placeholder="Ketik kata sandi baru (minimal 6 karakter)">
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <button type="submit" class="btn btn-primary-custom px-4">
                            <i class="bi bi-check2-circle me-1"></i> Simpan Perubahan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
