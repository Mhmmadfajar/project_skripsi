<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-custom mb-4">
            <div class="card-header-custom">
                <div>
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-file-earmark-plus text-teal me-2" style="color: #0f766e;"></i> Formulir Permohonan Surat</h5>
                    <span class="text-muted small">Pilih jenis surat keterangan/pengantar dan cantumkan keperluan pembuatan.</span>
                </div>
                <a href="<?= base_url('surat') ?>" class="btn btn-outline-secondary btn-sm rounded-3">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="p-4">
                <form action="<?= base_url('surat/simpan') ?>" method="POST">
                    <?= csrf_field() ?>

                    <!-- Applicant Selector -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Pemohon Surat <span class="text-danger">*</span></label>
                        <?php if ($role === 'warga'): ?>
                            <input type="text" class="form-control bg-light" value="<?= esc(session()->get('nama_lengkap')) ?> (NIK: <?= esc($userNik) ?>)" readonly>
                            <input type="hidden" name="nik_pemohon" value="<?= esc($userNik) ?>">
                        <?php else: ?>
                            <select name="nik_pemohon" class="form-select" required autofocus>
                                <option value="">-- Pilih Warga Pemohon --</option>
                                <?php foreach ($pendudukList as $p): ?>
                                    <option value="<?= esc($p['nik']) ?>" <?= (isset($_GET['nik']) && $_GET['nik'] === $p['nik']) ? 'selected' : '' ?>>
                                        <?= esc($p['nama_lengkap']) ?> (NIK: <?= esc($p['nik']) ?> - RT <?= esc($p['rt']) ?>/RW <?= esc($p['rw']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text" style="font-size: 0.75rem;">Pilih data warga yang mengajukan surat ke kantor desa.</div>
                        <?php endif; ?>
                    </div>

                    <!-- Letter Type Selector -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Jenis Surat Keterangan / Pengantar <span class="text-danger">*</span></label>
                        <select name="id_jenis_surat" id="selectJenisSurat" class="form-select" required onchange="updateSyarat()">
                            <option value="">-- Pilih Jenis Surat --</option>
                            <?php foreach ($jenisSurat as $js): ?>
                                <option value="<?= $js['id_jenis_surat'] ?>" data-syarat="<?= esc($js['persyaratan']) ?>">
                                    [<?= esc($js['kode_surat']) ?>] <?= esc($js['nama_surat']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Dynamic Requirements Banner -->
                    <div id="boxSyarat" class="alert alert-info border-0 p-3 rounded-3 small mb-3" style="display: none;">
                        <h6 class="fw-bold mb-1"><i class="bi bi-info-circle-fill me-1"></i> Persyaratan Berkas Yang Harus Dilengkapi:</h6>
                        <span id="textSyarat">Silakan bawa dokumen berikut saat verifikasi.</span>
                    </div>

                    <!-- Purpose -->
                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Keperluan / Keterangan Tambahan <span class="text-danger">*</span></label>
                        <textarea name="keperluan" class="form-control" rows="3" placeholder="Contoh: Untuk persyaratan pendaftaran beasiswa anak di PTN / Pembukaan usaha warung makan / Kelengkapan berkas kepolisian..." required><?= old('keperluan') ?></textarea>
                        <div class="form-text" style="font-size: 0.75rem;">Jelaskan tujuan penggunaan surat keterangan ini secara jelas dan lugas.</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('surat') ?>" class="btn btn-light border px-4">Batal</a>
                        <button type="submit" class="btn btn-primary-custom px-4">
                            <i class="bi bi-send me-1"></i> Kirim Permohonan Surat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function updateSyarat() {
        const select = document.getElementById('selectJenisSurat');
        const box = document.getElementById('boxSyarat');
        const text = document.getElementById('textSyarat');
        
        const selectedOption = select.options[select.selectedIndex];
        const syarat = selectedOption.getAttribute('data-syarat');

        if (syarat && syarat.trim() !== '') {
            text.textContent = syarat;
            box.style.display = 'block';
        } else {
            box.style.display = 'none';
        }
    }
</script>
<?= $this->endSection() ?>
