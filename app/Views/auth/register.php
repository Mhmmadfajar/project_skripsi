<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Registrasi Warga') ?> - SIPENDUK DESA</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #042f2e 0%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1rem;
        }
        .register-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            max-width: 540px;
            width: 100%;
        }
        .register-header {
            background: linear-gradient(135deg, #0f766e 0%, #115e59 100%);
            padding: 2rem 2rem 1.5rem;
            color: #ffffff;
            text-align: center;
        }
        .register-body {
            padding: 2rem;
        }
        .form-control, .form-select {
            border-radius: 12px;
            padding: 0.7rem 1rem;
            border: 1.5px solid #e2e8f0;
            font-size: 0.9rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #0f766e;
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.15);
        }
        .btn-register {
            background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 0.8rem;
            font-weight: 700;
            font-size: 0.95rem;
            width: 100%;
            transition: all 0.25s ease;
        }
        .btn-register:hover {
            background: linear-gradient(135deg, #115e59 0%, #0f766e 100%);
            color: #ffffff;
            box-shadow: 0 8px 20px rgba(20, 184, 166, 0.35);
        }
    </style>
</head>
<body>

    <div class="register-card">
        <div class="register-header">
            <h4 class="fw-bold mb-1"><i class="bi bi-person-plus-fill me-2"></i> Pendaftaran Akun Warga</h4>
            <p class="small text-white-50 mb-0">Layanan Mandiri Administrasi Kependudukan Desa Jampang</p>
        </div>

        <div class="register-body">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 py-2 small d-flex align-items-center gap-2 mb-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div><?= session()->getFlashdata('error') ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('register') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-muted">Nomor Induk Kependudukan (NIK) <span class="text-danger">*</span></label>
                    <input type="text" name="nik" class="form-control" placeholder="16 digit NIK sesuai KTP" maxlength="16" value="<?= old('nik') ?>" required autofocus>
                    <div class="form-text" style="font-size: 0.75rem;">Pastikan NIK sesuai dengan KTP elektronik Anda.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-muted">Nama Lengkap Sesuai KTP <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap" value="<?= old('nama_lengkap') ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-muted">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select">
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-muted">Nomor KK (Opsional)</label>
                        <input type="text" name="no_kk" class="form-control" placeholder="16 digit No. KK" maxlength="16" value="<?= old('no_kk') ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-muted">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" placeholder="Pilih username unik" value="<?= old('username') ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-muted">Email (Opsional)</label>
                        <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="<?= old('email') ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-muted">Kata Sandi <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-semibold text-muted">Ulangi Kata Sandi <span class="text-danger">*</span></label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Ketik ulang password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-register mb-3 mt-2">
                    <i class="bi bi-check2-circle me-1"></i> Selesaikan Pendaftaran
                </button>
            </form>

            <div class="text-center pt-2 border-top">
                <p class="small text-muted mb-0">
                    Sudah memiliki akun? 
                    <a href="<?= base_url('login') ?>" class="text-decoration-none fw-bold" style="color: #0f766e;">Login ke Sistem</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
