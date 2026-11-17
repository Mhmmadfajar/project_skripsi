<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card-custom p-4 bg-white border-start border-4 border-teal" style="border-color: #0f766e !important;">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h5 class="fw-bold mb-1 text-dark">Selamat Datang, Bapak Kepala Desa (Maman Suherman, S.Pd)</h5>
                    <p class="text-muted small mb-0">Halaman eksekutif untuk persetujuan (approval) surat permohonan warga dan monitoring kependudukan.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('laporan') ?>" class="btn btn-outline-secondary btn-sm rounded-3">
                        <i class="bi bi-file-earmark-bar-graph me-1"></i> Rekapitulasi Desa
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Stat: Menunggu Persetujuan Kades -->
    <div class="col-sm-6 col-xl-3">
        <div class="card-custom p-3 d-flex align-items-center gap-3">
            <div class="rounded-4 p-3 d-flex align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, #e11d48, #fb7185); width: 56px; height: 56px;">
                <i class="bi bi-patch-question fs-4"></i>
            </div>
            <div>
                <span class="text-muted small fw-semibold">Menunggu Approval</span>
                <h3 class="fw-bold mb-0 text-dark"><?= count($antrean_approval) ?></h3>
                <span class="badge bg-danger-subtle text-danger small" style="font-size: 0.72rem;">Perlu Tanda Tangan</span>
            </div>
        </div>
    </div>

    <!-- Stat: Surat Disetujui -->
    <div class="col-sm-6 col-xl-3">
        <div class="card-custom p-3 d-flex align-items-center gap-3">
            <div class="rounded-4 p-3 d-flex align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, #16a34a, #4ade80); width: 56px; height: 56px;">
                <i class="bi bi-patch-check-fill fs-4"></i>
            </div>
            <div>
                <span class="text-muted small fw-semibold">Telah Disahkan</span>
                <h3 class="fw-bold mb-0 text-dark"><?= number_format($stat_surat['disetujui']) ?></h3>
                <span class="badge bg-success-subtle text-success small" style="font-size: 0.72rem;">QR Code Aktif</span>
            </div>
        </div>
    </div>

    <!-- Stat: Total Penduduk -->
    <div class="col-sm-6 col-xl-3">
        <div class="card-custom p-3 d-flex align-items-center gap-3">
            <div class="rounded-4 p-3 d-flex align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, #0f766e, #14b8a6); width: 56px; height: 56px;">
                <i class="bi bi-people-fill fs-4"></i>
            </div>
            <div>
                <span class="text-muted small fw-semibold">Total Penduduk</span>
                <h3 class="fw-bold mb-0 text-dark"><?= number_format($statistik['total']) ?></h3>
                <span class="badge bg-teal-subtle text-teal small" style="font-size: 0.72rem;">Jiwa</span>
            </div>
        </div>
    </div>

    <!-- Stat: Total KK -->
    <div class="col-sm-6 col-xl-3">
        <div class="card-custom p-3 d-flex align-items-center gap-3">
            <div class="rounded-4 p-3 d-flex align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, #2563eb, #38bdf8); width: 56px; height: 56px;">
                <i class="bi bi-houses-fill fs-4"></i>
            </div>
            <div>
                <span class="text-muted small fw-semibold">Kartu Keluarga</span>
                <h3 class="fw-bold mb-0 text-dark"><?= number_format($total_kk) ?></h3>
                <span class="badge bg-primary-subtle text-primary small" style="font-size: 0.72rem;">Keluarga</span>
            </div>
        </div>
    </div>
</div>

<!-- Antrean Persetujuan Surat (Approval Queue) -->
<div class="card-custom mb-4">
    <div class="card-header-custom">
        <div>
            <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-inbox-fill me-2 text-danger"></i> Antrean Surat Perlu Persetujuan Kepala Desa</h6>
            <span class="text-muted small">Surat yang diajukan warga dan menunggu tanda tangan elektronik & QR Code verifikasi.</span>
        </div>
        <span class="badge bg-danger rounded-pill px-3 py-2"><?= count($antrean_approval) ?> Berkas</span>
    </div>

    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th>Pemohon</th>
                    <th>Jenis Surat</th>
                    <th>Keperluan</th>
                    <th>Tanggal Diajukan</th>
                    <th class="text-end">Tindakan Kepala Desa</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($antrean_approval)): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="bi bi-check2-all text-success fs-2 d-block mb-2"></i>
                            Semua permohonan surat telah diproses! Tidak ada antrean yang tertunda.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($antrean_approval as $row): ?>
                        <tr>
                            <td>
                                <div class="fw-bold text-dark"><?= esc($row['nama_pemohon']) ?></div>
                                <div class="text-muted small">NIK: <?= esc($row['nik_pemohon']) ?> | RT <?= esc($row['rt'] ?? '-') ?>/RW <?= esc($row['rw'] ?? '-') ?></div>
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary fw-semibold px-2 py-1"><?= esc($row['nama_surat'] ?? $row['jenis_surat']) ?></span>
                            </td>
                            <td>
                                <span class="text-muted small"><?= esc($row['keperluan']) ?></span>
                            </td>
                            <td class="text-muted small">
                                <?= date('d M Y, H:i', strtotime($row['tanggal_pengajuan'])) ?> WIB
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="<?= base_url('surat/detail/' . $row['id_pengajuan']) ?>" class="btn btn-sm btn-light border py-1 px-2" title="Periksa Detail">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                    <button type="button" class="btn btn-sm btn-success py-1 px-3" data-bs-toggle="modal" data-bs-target="#modalApprove<?= $row['id_pengajuan'] ?>">
                                        <i class="bi bi-check-lg me-1"></i> Setujui
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2" data-bs-toggle="modal" data-bs-target="#modalReject<?= $row['id_pengajuan'] ?>">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>

                                <!-- Modal Approve -->
                                <div class="modal fade text-start" id="modalApprove<?= $row['id_pengajuan'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <form action="<?= base_url('surat/approve/' . $row['id_pengajuan']) ?>" method="POST">
                                                <?= csrf_field() ?>
                                                <div class="modal-header border-0 pb-0">
                                                    <h6 class="modal-title fw-bold text-success"><i class="bi bi-patch-check-fill me-2"></i> Konfirmasi Persetujuan Surat</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body py-3">
                                                    <p class="small text-muted mb-3">
                                                        Dengan menyetujui surat ini, sistem akan secara otomatis menerbitkan <strong>Nomor Surat Resmi</strong> serta <strong>Tanda Tangan Digital & QR Code Verifikasi</strong> atas nama Kepala Desa.
                                                    </p>
                                                    <div class="bg-light p-3 rounded-3 mb-3 small">
                                                        <div><strong>Pemohon:</strong> <?= esc($row['nama_pemohon']) ?> (NIK: <?= esc($row['nik_pemohon']) ?>)</div>
                                                        <div><strong>Surat:</strong> <?= esc($row['nama_surat'] ?? $row['jenis_surat']) ?></div>
                                                        <div><strong>Keperluan:</strong> <?= esc($row['keperluan']) ?></div>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label small fw-semibold">Nomor Surat (Biarkan kosong untuk otomatis)</label>
                                                        <input type="text" name="no_surat" class="form-control form-control-sm" placeholder="Otomatis digenerate sistem">
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 pt-0">
                                                    <button type="button" class="btn btn-sm btn-light border" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-sm btn-success px-3 fw-semibold">
                                                        <i class="bi bi-check-circle me-1"></i> Sahkan & Terbitkan QR
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Reject -->
                                <div class="modal fade text-start" id="modalReject<?= $row['id_pengajuan'] ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <form action="<?= base_url('surat/reject/' . $row['id_pengajuan']) ?>" method="POST">
                                                <?= csrf_field() ?>
                                                <div class="modal-header border-0 pb-0">
                                                    <h6 class="modal-title fw-bold text-danger"><i class="bi bi-x-circle-fill me-2"></i> Tolak Permohonan Surat</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body py-3">
                                                    <p class="small text-muted mb-3">
                                                        Berikan alasan atau catatan revisi agar pemohon dapat memperbaiki dokumen persyaratannya.
                                                    </p>
                                                    <div class="mb-2">
                                                        <label class="form-label small fw-semibold">Catatan / Alasan Penolakan <span class="text-danger">*</span></label>
                                                        <textarea name="catatan_revisi" class="form-control" rows="3" placeholder="Contoh: Berkas fotokopi KK tidak jelas, mohon ajukan ulang dengan berkas asli." required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 pt-0">
                                                    <button type="button" class="btn btn-sm btn-light border" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-sm btn-danger px-3 fw-semibold">Tolak Permohonan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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
