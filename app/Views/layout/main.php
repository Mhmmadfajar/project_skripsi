<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Sistem Informasi Kependudukan Desa') ?> - SIPENDUK DESA</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary-emerald: #0f766e;
            --primary-emerald-hover: #115e59;
            --primary-teal: #14b8a6;
            --primary-light: #f0fdfa;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: #0f766e;
            --sidebar-text: #94a3b8;
            --body-bg: #f8fafc;
            --card-border: #e2e8f0;
            --text-dark: #0f172a;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--body-bg);
            color: var(--text-dark);
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 270px;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            transition: all 0.3s ease;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.08);
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #14b8a6, #0f766e);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.4rem;
            box-shadow: 0 4px 12px rgba(20, 184, 166, 0.35);
        }

        .brand-title {
            color: #ffffff;
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.2;
            margin: 0;
        }

        .brand-subtitle {
            color: #94a3b8;
            font-size: 0.72rem;
            font-weight: 500;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .sidebar-menu {
            padding: 1.25rem 0.85rem;
            list-style: none;
            margin: 0;
        }

        .menu-header {
            color: #64748b;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 0.85rem 0.75rem 0.4rem;
        }

        .sidebar-item {
            margin-bottom: 4px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.7rem 0.85rem;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .sidebar-link i {
            font-size: 1.15rem;
            transition: transform 0.2s ease;
        }

        .sidebar-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.06);
            transform: translateX(3px);
        }

        .sidebar-link.active {
            color: #ffffff;
            background: linear-gradient(90deg, #0f766e, #14b8a6);
            box-shadow: 0 4px 14px rgba(15, 118, 110, 0.4);
            font-weight: 600;
        }

        /* Main Content Wrapper */
        .main-wrapper {
            margin-left: 270px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        /* Top Navbar */
        .top-navbar {
            height: 70px;
            background-color: #ffffff;
            border-bottom: 1px solid var(--card-border);
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1020;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        }

        .content-body {
            padding: 2rem;
            flex: 1;
        }

        /* Modern Card Styling */
        .card-custom {
            background-color: #ffffff;
            border: 1px solid var(--card-border);
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            transition: all 0.25s ease;
        }

        .card-custom:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        }

        .card-header-custom {
            background-color: transparent;
            border-bottom: 1px solid #f1f5f9;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Role Badges */
        .badge-role-admin {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .badge-role-kades {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .badge-role-staf {
            background-color: #e0e7ff;
            color: #3730a3;
            border: 1px solid #c7d2fe;
        }

        .badge-role-warga {
            background-color: #ccfbf1;
            color: #115e59;
            border: 1px solid #99f6e4;
        }

        /* Status Badges */
        .badge-status-pending {
            background-color: #fef9c3;
            color: #854d0e;
        }
        .badge-status-proses {
            background-color: #e0f2fe;
            color: #075985;
        }
        .badge-status-disetujui {
            background-color: #dcfce7;
            color: #166534;
        }
        .badge-status-ditolak {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Buttons */
        .btn-primary-custom {
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            color: #ffffff;
            border: none;
            padding: 0.55rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.88rem;
            box-shadow: 0 3px 10px rgba(20, 184, 166, 0.25);
            transition: all 0.2s ease;
        }

        .btn-primary-custom:hover {
            background: linear-gradient(135deg, #115e59, #0f766e);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(20, 184, 166, 0.35);
        }

        /* Table Styling */
        .table-custom {
            margin: 0;
        }
        .table-custom th {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            background-color: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            padding: 0.9rem 1rem;
        }
        .table-custom td {
            font-size: 0.875rem;
            padding: 0.9rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }
        .table-custom tr:hover td {
            background-color: #f8fafc;
        }

        /* Mobile Drawer */
        @media (max-width: 991.98px) {
            .sidebar {
                margin-left: -270px;
            }
            .sidebar.show {
                margin-left: 0;
            }
            .main-wrapper {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar Navigation -->
    <aside class="sidebar" id="appSidebar">
        <div class="sidebar-brand">
            <div class="brand-icon" style="background: rgba(255,255,255,0.15); box-shadow: none; padding: 4px;">
                <img src="<?= base_url('images/logo_kabupaten_bogor.png') ?>" alt="Logo Desa" style="width: 32px; height: auto;">
            </div>
            <div>
                <h5 class="brand-title">SIPENDUK</h5>
                <p class="brand-subtitle">Desa Jampang</p>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-header">Menu Utama</li>
            <li class="sidebar-item">
                <a href="<?= base_url('dashboard') ?>" class="sidebar-link <?= (uri_string() === 'dashboard') ? 'active' : '' ?>">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <?php $userRole = session()->get('role'); ?>

            <?php if (in_array($userRole, ['admin', 'staf', 'kades'])): ?>
                <li class="menu-header">Kependudukan</li>
                <li class="sidebar-item">
                    <a href="<?= base_url('penduduk') ?>" class="sidebar-link <?= (strpos(uri_string(), 'penduduk') === 0) ? 'active' : '' ?>">
                        <i class="bi bi-people-fill"></i>
                        <span>Data Penduduk</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?= base_url('kartu-keluarga') ?>" class="sidebar-link <?= (strpos(uri_string(), 'kartu-keluarga') === 0) ? 'active' : '' ?>">
                        <i class="bi bi-card-heading"></i>
                        <span>Kartu Keluarga (KK)</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?= base_url('mutasi') ?>" class="sidebar-link <?= (strpos(uri_string(), 'mutasi') === 0) ? 'active' : '' ?>">
                        <i class="bi bi-arrow-left-right"></i>
                        <span>Mutasi Penduduk</span>
                    </a>
                </li>
            <?php endif; ?>

            <li class="menu-header">Pelayanan</li>
            <li class="sidebar-item">
                <a href="<?= base_url('surat') ?>" class="sidebar-link <?= (strpos(uri_string(), 'surat') === 0) ? 'active' : '' ?>">
                    <i class="bi bi-file-earmark-text-fill"></i>
                    <span>Layanan Surat</span>
                </a>
            </li>

            <?php if (in_array($userRole, ['admin', 'staf', 'kades'])): ?>
                <li class="menu-header">Rekap & Laporan</li>
                <li class="sidebar-item">
                    <a href="<?= base_url('laporan') ?>" class="sidebar-link <?= (strpos(uri_string(), 'laporan') === 0) ? 'active' : '' ?>">
                        <i class="bi bi-bar-chart-line-fill"></i>
                        <span>Laporan Statistik</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($userRole === 'admin'): ?>
                <li class="menu-header">Pengaturan Sistem</li>
                <li class="sidebar-item">
                    <a href="<?= base_url('user') ?>" class="sidebar-link <?= (strpos(uri_string(), 'user') === 0) ? 'active' : '' ?>">
                        <i class="bi bi-person-gear"></i>
                        <span>Manajemen User</span>
                    </a>
                </li>
            <?php endif; ?>

            <li class="menu-header">Akun</li>
            <li class="sidebar-item">
                <a href="<?= base_url('profil') ?>" class="sidebar-link <?= (uri_string() === 'profil') ? 'active' : '' ?>">
                    <i class="bi bi-person-circle"></i>
                    <span>Profil Saya</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="<?= base_url('logout') ?>" class="sidebar-link text-danger">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Keluar (Logout)</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <header class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-lg-none p-1 px-2 border" id="sidebarToggle">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div class="d-none d-sm-block">
                    <span class="text-muted small">Pemerintah Desa Jampang, Kec. Gunung Sindur</span>
                    <h6 class="mb-0 fw-bold"><?= esc($title ?? 'Sistem Kependudukan') ?></h6>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <!-- Role Tag -->
                <span class="badge rounded-pill px-3 py-2 badge-role-<?= esc($userRole) ?> text-uppercase fw-bold" style="font-size: 0.75rem;">
                    <i class="bi bi-shield-check me-1"></i> <?= esc($userRole) ?>
                </span>

                <!-- User Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-light border dropdown-toggle d-flex align-items-center gap-2 py-1 px-2 rounded-3" type="button" data-bs-toggle="dropdown">
                        <div class="rounded-circle bg-teal text-white d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; background: #0f766e;">
                            <?= strtoupper(substr(session()->get('nama_lengkap') ?? 'U', 0, 1)) ?>
                        </div>
                        <span class="fw-semibold small d-none d-md-inline"><?= esc(session()->get('nama_lengkap')) ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li>
                            <div class="px-3 py-2 border-bottom">
                                <p class="mb-0 small fw-bold text-dark"><?= esc(session()->get('nama_lengkap')) ?></p>
                                <span class="text-muted" style="font-size: 0.75rem;">@<?= esc(session()->get('username')) ?></span>
                            </div>
                        </li>
                        <li><a class="dropdown-item py-2 small" href="<?= base_url('profil') ?>"><i class="bi bi-person me-2"></i> Pengaturan Akun</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2 small text-danger" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Content Body -->
        <main class="content-body">
            <!-- Flash Message Alerts -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <div><?= session()->getFlashdata('success') ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2 mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                    <div><?= session()->getFlashdata('error') ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('info')): ?>
                <div class="alert alert-info alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2 mb-4" role="alert">
                    <i class="bi bi-info-circle-fill fs-5"></i>
                    <div><?= session()->getFlashdata('info') ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- View Content Injection -->
            <?= $this->renderSection('content') ?>
        </main>

        <!-- Footer -->
        <footer class="py-3 px-4 bg-white border-top text-center text-muted small">
            &copy; <?= date('Y') ?> Pemerintah Desa Jampang - Sistem Informasi Administrasi & Kependudukan Terpadu (RAD CI4)
        </footer>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle for Mobile
        const sidebarToggle = document.getElementById('sidebarToggle');
        const appSidebar = document.getElementById('appSidebar');
        if (sidebarToggle && appSidebar) {
            sidebarToggle.addEventListener('click', () => {
                appSidebar.classList.toggle('show');
            });
        }
    </script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
