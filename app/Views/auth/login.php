<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Login') ?> - SIPENDUK DESA</title>
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
            padding: 2rem 1rem;
        }
        .login-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            max-width: 460px;
            width: 100%;
        }
        .login-header {
            background: linear-gradient(135deg, #0f766e 0%, #115e59 100%);
            padding: 2.5rem 2rem 2rem;
            color: #ffffff;
            text-align: center;
            position: relative;
        }
        .login-header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 0;
            right: 0;
            height: 20px;
            background: #ffffff;
            border-radius: 20px 20px 0 0;
        }
        .login-body {
            padding: 1.5rem 2.25rem 2.25rem;
        }
        .brand-badge {
            width: 58px;
            height: 58px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }
        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 1.5px solid #e2e8f0;
            font-size: 0.92rem;
        }
        .form-control:focus {
            border-color: #0f766e;
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.15);
        }
        .btn-login {
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
        .btn-login:hover {
            background: linear-gradient(135deg, #115e59 0%, #0f766e 100%);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(20, 184, 166, 0.35);
        }
        .role-chip {
            font-size: 0.75rem;
            padding: 0.35rem 0.65rem;
            border-radius: 8px;
            cursor: pointer;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            color: #334155;
            transition: all 0.15s ease;
        }
        .role-chip:hover {
            border-color: #0f766e;
            background: #f0fdfa;
            color: #0f766e;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <div class="brand-badge" style="background: rgba(255, 255, 255, 0.95); padding: 5px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                <img src="<?= base_url('images/logo_kabupaten_bogor.png') ?>" alt="Logo Kabupaten Bogor" style="width: 42px; height: auto;">
            </div>
            <h4 class="fw-bold mb-1">SIPENDUK DESA</h4>
            <p class="small text-white-50 mb-0">Sistem Informasi Kependudukan & Pelayanan Terpadu</p>
            <div class="small text-white-50 mt-1" style="font-size: 0.75rem;">Pemerintah Desa Jampang, Kab. Bogor</div>
        </div>

        <div class="login-body">
            <!-- Flash Message Alerts -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 py-2 small d-flex align-items-center gap-2 mb-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div><?= session()->getFlashdata('error') ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show border-0 py-2 small d-flex align-items-center gap-2 mb-3" role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    <div><?= session()->getFlashdata('success') ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('info')): ?>
                <div class="alert alert-info alert-dismissible fade show border-0 py-2 small d-flex align-items-center gap-2 mb-3" role="alert">
                    <i class="bi bi-info-circle-fill"></i>
                    <div><?= session()->getFlashdata('info') ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-muted">Username / Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="bi bi-person text-muted"></i></span>
                        <input type="text" name="login" id="loginInput" class="form-control border-start-0" placeholder="Masukkan username atau email" value="<?= old('login') ?>" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-semibold text-muted">Kata Sandi (Password)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="bi bi-lock text-muted"></i></span>
                        <input type="password" name="password" id="passwordInput" class="form-control border-start-0" placeholder="Masukkan kata sandi" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-login mb-3">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke Sistem
                </button>
            </form>

            <!-- Quick Demo Login Selection -->
            <div class="pt-2 border-top">
                <span class="d-block text-muted text-center mb-2" style="font-size: 0.72rem; font-weight: 600;">KLIK UNTUK ISI OTOMATIS AKUN PENGUJIAN:</span>
                <div class="d-flex flex-wrap gap-1 justify-content-center">
                    <button type="button" class="role-chip" onclick="fillCred('admin', 'admin123')">
                        <i class="bi bi-shield-lock-fill text-danger"></i> Admin
                    </button>
                    <button type="button" class="role-chip" onclick="fillCred('kades', 'kades123')">
                        <i class="bi bi-patch-check-fill text-warning"></i> Kades
                    </button>
                    <button type="button" class="role-chip" onclick="fillCred('staf', 'staf123')">
                        <i class="bi bi-person-workspace text-primary"></i> Staf
                    </button>
                    <button type="button" class="role-chip" onclick="fillCred('warga', 'warga123')">
                        <i class="bi bi-person-fill text-teal"></i> Warga
                    </button>
                </div>
            </div>

            <!-- Citizen Register & Tracking Links -->
            <div class="text-center mt-3 pt-2">
                <p class="small text-muted mb-2">
                    Warga baru belum punya akun? 
                    <a href="<?= base_url('register') ?>" class="text-decoration-none fw-bold text-teal" style="color: #0f766e;">Daftar Mandiri Di Sini</a>
                </p>
                <div class="pt-2 border-top">
                    <a href="<?= base_url('lacak-surat') ?>" class="text-decoration-none small fw-bold text-teal d-inline-flex align-items-center gap-1" style="color: #0f766e;">
                        <i class="bi bi-search"></i> Lacak Status Permohonan Surat (Tanpa Login) <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function fillCred(user, pass) {
            document.getElementById('loginInput').value = user;
            document.getElementById('passwordInput').value = pass;
        }
    </script>
</body>
</html>
