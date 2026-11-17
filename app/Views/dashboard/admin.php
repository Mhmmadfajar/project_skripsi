<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row g-3 mb-4">
    <!-- Stat Card: Total Penduduk -->
    <div class="col-sm-6 col-xl-3">
        <div class="card-custom p-3 d-flex align-items-center gap-3">
            <div class="rounded-4 p-3 d-flex align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, #0f766e, #14b8a6); width: 56px; height: 56px;">
                <i class="bi bi-people fs-4"></i>
            </div>
            <div>
                <span class="text-muted small fw-semibold">Total Penduduk</span>
                <h3 class="fw-bold mb-0 text-dark"><?= number_format($statistik['total']) ?></h3>
                <span class="badge bg-success-subtle text-success small" style="font-size: 0.72rem;">Jiwa Terdaftar</span>
            </div>
        </div>
    </div>

    <!-- Stat Card: Total Kartu Keluarga -->
    <div class="col-sm-6 col-xl-3">
        <div class="card-custom p-3 d-flex align-items-center gap-3">
            <div class="rounded-4 p-3 d-flex align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, #2563eb, #38bdf8); width: 56px; height: 56px;">
                <i class="bi bi-card-heading fs-4"></i>
            </div>
            <div>
                <span class="text-muted small fw-semibold">Kartu Keluarga (KK)</span>
                <h3 class="fw-bold mb-0 text-dark"><?= number_format($total_kk) ?></h3>
                <span class="badge bg-primary-subtle text-primary small" style="font-size: 0.72rem;">Kepala Keluarga</span>
            </div>
        </div>
    </div>

    <!-- Stat Card: Layanan Surat Pending -->
    <div class="col-sm-6 col-xl-3">
        <div class="card-custom p-3 d-flex align-items-center gap-3">
            <div class="rounded-4 p-3 d-flex align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, #d97706, #fbbf24); width: 56px; height: 56px;">
                <i class="bi bi-hourglass-split fs-4"></i>
            </div>
            <div>
                <span class="text-muted small fw-semibold">Surat Menunggu</span>
                <h3 class="fw-bold mb-0 text-dark"><?= number_format($stat_surat['pending'] + $stat_surat['proses']) ?></h3>
                <span class="badge bg-warning-subtle text-warning small" style="font-size: 0.72rem;">Perlu Verifikasi</span>
            </div>
        </div>
    </div>

    <!-- Stat Card: Surat Selesai -->
    <div class="col-sm-6 col-xl-3">
        <div class="card-custom p-3 d-flex align-items-center gap-3">
            <div class="rounded-4 p-3 d-flex align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, #16a34a, #4ade80); width: 56px; height: 56px;">
                <i class="bi bi-patch-check-fill fs-4"></i>
            </div>
            <div>
                <span class="text-muted small fw-semibold">Surat Disetujui</span>
                <h3 class="fw-bold mb-0 text-dark"><?= number_format($stat_surat['disetujui']) ?></h3>
                <span class="badge bg-success-subtle text-success small" style="font-size: 0.72rem;">Tervalidasi QR</span>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mb-4">
    <!-- Chart: Demografi Usia -->
    <div class="col-lg-7">
        <div class="card-custom p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-bar-chart-fill text-teal me-2" style="color: #0f766e;"></i> Komposisi Kelompok Usia Penduduk</h6>
                <span class="badge bg-light text-muted border">Real-time</span>
            </div>
            <div style="height: 250px;">
                <canvas id="chartUsia"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart: Rasio Jenis Kelamin -->
    <div class="col-lg-5">
        <div class="card-custom p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-pie-chart-fill text-teal me-2" style="color: #0f766e;"></i> Perbandingan Jenis Kelamin</h6>
                <span class="badge bg-light text-muted border">Persentase</span>
            </div>
            <div style="height: 250px;" class="d-flex align-items-center justify-content-center">
                <canvas id="chartGender"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Quick Action Shortcuts -->
<div class="card-custom p-3 mb-4 bg-white">
    <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-teal text-white p-2" style="background-color: #0f766e;"><i class="bi bi-lightning-charge-fill"></i></span>
            <span class="fw-bold small text-dark">Akses Cepat Pengelolaan:</span>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= base_url('penduduk/tambah') ?>" class="btn btn-sm btn-outline-secondary rounded-3">
                <i class="bi bi-person-plus me-1"></i> Tambah Penduduk
            </a>
            <a href="<?= base_url('kartu-keluarga/tambah') ?>" class="btn btn-sm btn-outline-secondary rounded-3">
                <i class="bi bi-card-heading me-1"></i> Tambah KK
            </a>
            <a href="<?= base_url('mutasi/tambah') ?>" class="btn btn-sm btn-outline-secondary rounded-3">
                <i class="bi bi-arrow-left-right me-1"></i> Catat Mutasi
            </a>
            <a href="<?= base_url('surat/tambah') ?>" class="btn btn-sm btn-primary-custom">
                <i class="bi bi-file-earmark-plus me-1"></i> Buat Permohonan Surat
            </a>
        </div>
    </div>
</div>

<!-- Recent Letter Applications & Recent Mutations -->
<div class="row g-4">
    <!-- Recent Letter Applications -->
    <div class="col-lg-7">
        <div class="card-custom h-100">
            <div class="card-header-custom">
                <h6 class="fw-bold mb-0"><i class="bi bi-file-text me-2 text-teal" style="color: #0f766e;"></i> Permohonan Surat Terkini</h6>
                <a href="<?= base_url('surat') ?>" class="small text-decoration-none fw-semibold" style="color: #0f766e;">Lihat Semua <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>Pemohon</th>
                            <th>Jenis Surat</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pengajuan_terbaru)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada pengajuan surat.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($pengajuan_terbaru as $s): ?>
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-dark"><?= esc($s['nama_pemohon'] ?? 'Warga') ?></div>
                                        <div class="text-muted" style="font-size: 0.75rem;">NIK: <?= esc($s['nik_pemohon']) ?></div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border"><?= esc($s['kode_surat'] ?? $s['jenis_surat']) ?></span>
                                    </td>
                                    <td class="text-muted small">
                                        <?= date('d M Y', strtotime($s['tanggal_pengajuan'])) ?>
                                    </td>
                                    <td>
                                        <?php 
                                            $stClass = match($s['status']) {
                                                'Pending' => 'badge-status-pending',
                                                'Proses' => 'badge-status-proses',
                                                'Disetujui' => 'badge-status-disetujui',
                                                'Ditolak' => 'badge-status-ditolak',
                                                default => 'bg-secondary text-white'
                                            };
                                        ?>
                                        <span class="badge px-2 py-1 <?= $stClass ?>"><?= esc($s['status']) ?></span>
                                    </td>
                                    <td class="text-end">
                                        <a href="<?= base_url('surat/detail/' . $s['id_pengajuan']) ?>" class="btn btn-sm btn-light border py-1 px-2 rounded-2">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Mutations -->
    <div class="col-lg-5">
        <div class="card-custom h-100">
            <div class="card-header-custom">
                <h6 class="fw-bold mb-0"><i class="bi bi-clock-history me-2 text-teal" style="color: #0f766e;"></i> Mutasi Penduduk Terbaru</h6>
                <a href="<?= base_url('mutasi') ?>" class="small text-decoration-none fw-semibold" style="color: #0f766e;">Kelola <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>Warga</th>
                            <th>Mutasi</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($mutasi_terbaru)): ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">Belum ada catatan mutasi.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($mutasi_terbaru as $m): ?>
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-dark"><?= esc($m['nama_lengkap'] ?? 'Penduduk') ?></div>
                                        <div class="text-muted" style="font-size: 0.75rem;">NIK: <?= esc($m['nik']) ?></div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary small"><?= esc($m['jenis_mutasi']) ?></span>
                                    </td>
                                    <td class="text-muted small">
                                        <?= date('d/m/Y', strtotime($m['tanggal_mutasi'])) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Chart Usia
    const ctxUsia = document.getElementById('chartUsia').getContext('2d');
    new Chart(ctxUsia, {
        type: 'bar',
        data: {
            labels: ['Balita (0-5)', 'Anak (6-17)', 'Produktif (18-59)', 'Lansia (60+)'],
            datasets: [{
                label: 'Jumlah Penduduk',
                data: [
                    <?= (int) ($statistik['usia']['balita'] ?? 0) ?>,
                    <?= (int) ($statistik['usia']['anak'] ?? 0) ?>,
                    <?= (int) ($statistik['usia']['produktif'] ?? 0) ?>,
                    <?= (int) ($statistik['usia']['lansia'] ?? 0) ?>
                ],
                backgroundColor: ['#14b8a6', '#0f766e', '#2563eb', '#f59e0b'],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Chart Gender
    const ctxGender = document.getElementById('chartGender').getContext('2d');
    new Chart(ctxGender, {
        type: 'doughnut',
        data: {
            labels: ['Laki-Laki', 'Perempuan'],
            datasets: [{
                data: [<?= (int) $statistik['laki'] ?>, <?= (int) $statistik['perempuan'] ?>],
                backgroundColor: ['#0284c7', '#ec4899'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            },
            cutout: '70%'
        }
    });
</script>
<?= $this->endSection() ?>
