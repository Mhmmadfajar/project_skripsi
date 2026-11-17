<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card-custom mb-4">
            <div class="card-header-custom">
                <div>
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-file-earmark-check-fill text-teal me-2" style="color: #0f766e;"></i> Detail Permohonan Surat #<?= $surat['id_pengajuan'] ?></h5>
                    <span class="text-muted small">Status dan riwayat proses pengajuan surat administrasi warga.</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('surat') ?>" class="btn btn-outline-secondary btn-sm rounded-3">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    <?php if ($surat['status'] === 'Disetujui'): ?>
                        <a href="<?= base_url('surat/cetak/' . $surat['id_pengajuan']) ?>" target="_blank" class="btn btn-success btn-sm rounded-3">
                            <i class="bi bi-printer me-1"></i> Cetak Surat Resmi
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="p-4">
                <!-- Status & Number Header Banner -->
                <div class="p-3 rounded-4 mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3" style="background-color: #f8fafc; border: 1.5px solid #e2e8f0;">
                    <div>
                        <span class="text-muted small d-block">Status Saat Ini:</span>
                        <?php 
                            $stClass = match($surat['status']) {
                                'Pending' => 'badge-status-pending',
                                'Proses' => 'badge-status-proses',
                                'Disetujui' => 'badge-status-disetujui',
                                'Ditolak' => 'badge-status-ditolak',
                                default => 'bg-secondary text-white'
                            };
                        ?>
                        <span class="badge px-3 py-2 fs-6 rounded-pill <?= $stClass ?>"><?= esc($surat['status']) ?></span>
                    </div>

                    <?php if (!empty($surat['no_surat'])): ?>
                        <div class="text-md-end">
                            <span class="text-muted small d-block">Nomor Surat Resmi:</span>
                            <span class="fs-6 fw-bold font-monospace text-primary"><?= esc($surat['no_surat']) ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($surat['qr_code'])): ?>
                        <div class="text-md-end">
                            <span class="text-muted small d-block">Kode QR Verifikasi:</span>
                            <span class="badge bg-light text-muted border font-monospace"><?= esc($surat['qr_code']) ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Rejection Note if Rejected -->
                <?php if ($surat['status'] === 'Ditolak' && !empty($surat['catatan_revisi'])): ?>
                    <div class="alert alert-danger border-0 rounded-3 mb-4">
                        <h6 class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Alasan / Catatan Penolakan:</h6>
                        <p class="mb-0 small"><?= esc($surat['catatan_revisi']) ?></p>
                    </div>
                <?php endif; ?>

                <!-- Letter & Citizen Information -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-file-earmark-text text-teal me-1" style="color: #0f766e;"></i> Informasi Permohonan</h6>
                        <table class="table table-sm table-borderless small mb-0">
                            <tr>
                                <td class="text-muted" style="width: 140px;">Jenis Surat:</td>
                                <td class="fw-bold text-dark"><?= esc($surat['nama_surat'] ?? $surat['jenis_surat']) ?> (<?= esc($surat['kode_surat'] ?? '') ?>)</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Tanggal Diajukan:</td>
                                <td><?= date('d F Y, H:i', strtotime($surat['tanggal_pengajuan'])) ?> WIB</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Keperluan:</td>
                                <td class="fw-semibold text-dark"><?= esc($surat['keperluan']) ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Disetujui Oleh:</td>
                                <td><?= esc($surat['nama_kades'] ?: ($surat['status'] === 'Disetujui' ? 'Kepala Desa Jampang' : '-')) ?></td>
                            </tr>
                            <?php if (!empty($surat['tanggal_persetujuan'])): ?>
                                <tr>
                                    <td class="text-muted">Tgl. Disahkan:</td>
                                    <td><?= date('d F Y, H:i', strtotime($surat['tanggal_persetujuan'])) ?> WIB</td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-person-vcard text-teal me-1" style="color: #0f766e;"></i> Data Pemohon (Warga)</h6>
                        <table class="table table-sm table-borderless small mb-0">
                            <tr>
                                <td class="text-muted" style="width: 140px;">Nama Lengkap:</td>
                                <td class="fw-bold text-dark"><?= esc($surat['nama_pemohon']) ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">NIK:</td>
                                <td class="font-monospace fw-semibold"><?= esc($surat['nik_pemohon']) ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">No. KK:</td>
                                <td class="font-monospace"><?= esc($surat['no_kk']) ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">TTL / JK:</td>
                                <td><?= esc($surat['tempat_lahir']) ?>, <?= date('d/m/Y', strtotime($surat['tanggal_lahir'])) ?> (<?= ($surat['jenis_kelamin'] === 'L') ? 'Laki-Laki' : 'Perempuan' ?>)</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Alamat:</td>
                                <td><?= esc($surat['alamat']) ?>, RT <?= esc($surat['rt']) ?> / RW <?= esc($surat['rw']) ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Pekerjaan:</td>
                                <td><?= esc($surat['pekerjaan']) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Action Workflow Buttons Depending on Role -->
                <div class="p-3 bg-light rounded-4 border d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <span class="small text-muted"><strong>Workflow Pelayanan:</strong> Kelola status surat sesuai wewenang peran Anda.</span>
                    
                    <div class="d-flex flex-wrap gap-2">
                        <?php if (in_array($role, ['admin', 'staf']) && $surat['status'] === 'Pending'): ?>
                            <a href="<?= base_url('surat/proses/' . $surat['id_pengajuan']) ?>" class="btn btn-sm btn-info text-white px-3" onclick="return confirm('Ubah status surat menjadi Sedang Diproses?');">
                                <i class="bi bi-gear me-1"></i> Proses Berkas Ini
                            </a>
                        <?php endif; ?>

                        <?php if (in_array($role, ['admin', 'kades']) && $surat['status'] !== 'Disetujui'): ?>
                            <button type="button" class="btn btn-sm btn-outline-danger px-3" data-bs-toggle="modal" data-bs-target="#modalReject">
                                <i class="bi bi-x-circle me-1"></i> Tolak Permohonan
                            </button>
                            <button type="button" class="btn btn-sm btn-success px-4" data-bs-toggle="modal" data-bs-target="#modalApprove">
                                <i class="bi bi-patch-check-fill me-1"></i> Setujui Surat & Terbitkan QR
                            </button>
                        <?php endif; ?>

                        <?php if ($surat['status'] === 'Disetujui'): ?>
                            <button type="button" class="btn btn-sm btn-success px-3" data-bs-toggle="modal" data-bs-target="#modalWhatsApp" title="Kirim notifikasi pesan ke WhatsApp warga">
                                <i class="bi bi-whatsapp me-1"></i> Kirim Notif WA
                            </button>
                            <a href="<?= base_url('surat/cetak/' . $surat['id_pengajuan']) ?>" target="_blank" class="btn btn-sm btn-primary-custom px-4">
                                <i class="bi bi-printer me-1"></i> Cetak Surat Resmi
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Approve -->
<div class="modal fade" id="modalApprove" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0 shadow">
            <form action="<?= base_url('surat/approve/' . $surat['id_pengajuan']) ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-bold text-success"><i class="bi bi-patch-check-fill me-2"></i> Konfirmasi Persetujuan Surat</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="small text-muted mb-3">
                        Persetujuan surat akan menghasilkan <strong>Nomor Surat Resmi</strong> secara otomatis serta menyematkan <strong>QR Code Pengesahan Digital</strong>.
                    </p>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nomor Surat Resmi (Biarkan kosong untuk otomatis)</label>
                        <input type="text" name="no_surat" class="form-control" placeholder="Otomatis digenerate sistem">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-sm btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-success px-4 fw-semibold">
                        <i class="bi bi-check-circle me-1"></i> Sahkan Surat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Reject -->
<div class="modal fade" id="modalReject" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0 shadow">
            <form action="<?= base_url('surat/reject/' . $surat['id_pengajuan']) ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-bold text-danger"><i class="bi bi-x-circle-fill me-2"></i> Tolak Permohonan Surat</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="small text-muted mb-2">
                        Tuliskan catatan alasan penolakan agar pemohon dapat mengetahuinya:
                    </p>
                    <div class="mb-2">
                        <textarea name="catatan_revisi" class="form-control" rows="3" placeholder="Contoh: Lampiran foto KTP tidak jelas, silakan ajukan ulang." required></textarea>
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

<?php if ($surat['status'] === 'Disetujui'): ?>
<!-- Modal WhatsApp Notification -->
<div class="modal fade text-start" id="modalWhatsApp" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold text-success"><i class="bi bi-whatsapp me-2"></i> Kirim Notifikasi WhatsApp ke Warga</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-3">
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Nomor WhatsApp Warga (Opsional)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                        <input type="text" id="waPhone" class="form-control" placeholder="Contoh: 081234567890 (atau biarkan kosong)">
                    </div>
                    <div class="form-text" style="font-size: 0.72rem;">Jika nomor dikosongkan, Anda dapat memilih kontak secara manual saat WhatsApp terbuka.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Pratinjau Pesan Resmi</label>
                    <?php 
                        $rawPesan = "Halo Bapak/Ibu " . $surat['nama_pemohon'] . ",\n\nKabar baik! Permohonan surat *" . ($surat['nama_surat'] ?? $surat['jenis_surat']) . "* dengan Nomor Surat: *" . $surat['no_surat'] . "* telah *DISETUJUI* dan disahkan oleh Kepala Desa Jampang (Bpk. Maman Suherman, S.Pd).\n\nDokumen resmi ber-QR Code dapat dicek, diverifikasi, atau diunduh di tautan resmi:\n" . base_url('verifikasi/surat/' . $surat['qr_code']) . "\n\nTerima kasih.\n*Pemerintah Desa Jampang, Kec. Gunung Sindur, Kab. Bogor*";
                    ?>
                    <textarea id="waMessage" class="form-control bg-light font-monospace small" rows="8" readonly><?= esc($rawPesan) ?></textarea>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0 d-flex justify-content-between">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="copyWaText()">
                    <i class="bi bi-clipboard me-1"></i> <span id="btnCopyLabel">Salin Teks</span>
                </button>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-light border" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-sm btn-success px-3 fw-semibold" onclick="sendToWhatsApp()">
                        <i class="bi bi-whatsapp me-1"></i> Buka WhatsApp
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyWaText() {
    const text = document.getElementById('waMessage').value;
    navigator.clipboard.writeText(text).then(() => {
        const lbl = document.getElementById('btnCopyLabel');
        lbl.textContent = 'Tersalin!';
        setTimeout(() => { lbl.textContent = 'Salin Teks'; }, 2000);
    });
}

function sendToWhatsApp() {
    let phone = document.getElementById('waPhone').value.trim();
    if (phone.startsWith('0')) {
        phone = '62' + phone.substring(1);
    } else if (phone.startsWith('+62')) {
        phone = phone.substring(1);
    }
    phone = phone.replace(/[^0-9]/g, '');

    const text = encodeURIComponent(document.getElementById('waMessage').value);
    let waUrl = 'https://api.whatsapp.com/send?text=' + text;
    if (phone !== '') {
        waUrl = 'https://api.whatsapp.com/send?phone=' + phone + '&text=' + text;
    }
    window.open(waUrl, '_blank');
}
</script>
<?php endif; ?>

<?= $this->endSection() ?>
