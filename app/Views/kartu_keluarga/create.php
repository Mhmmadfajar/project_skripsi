<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-custom mb-4">
            <div class="card-header-custom">
                <div>
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-card-heading text-teal me-2" style="color: #0f766e;"></i> Tambah Kartu Keluarga Baru</h5>
                    <span class="text-muted small">Daftarkan nomor KK dan alamat domisili keluarga.</span>
                </div>
                <a href="<?= base_url('kartu-keluarga') ?>" class="btn btn-outline-secondary btn-sm rounded-3">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="p-4">
                <form action="<?= base_url('kartu-keluarga/simpan') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nomor Kartu Keluarga (No. KK) <span class="text-danger">*</span></label>
                        <input type="text" name="no_kk" class="form-control" maxlength="16" placeholder="16 Digit Nomor KK" value="<?= old('no_kk') ?>" required autofocus>
                        <div class="form-text" style="font-size: 0.75rem;">Pastikan 16 digit angka sesuai blanko KK resmi dari Disdukcapil.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Alamat Lengkap Tempat Tinggal <span class="text-danger">*</span></label>
                        <textarea name="alamat" class="form-control" rows="2" placeholder="Nama Jalan, Kampung, Gang, Nomor Rumah..." required><?= old('alamat') ?></textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">RT <span class="text-danger">*</span></label>
                            <input type="text" name="rt" class="form-control" maxlength="3" placeholder="001" value="<?= old('rt', '001') ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">RW <span class="text-danger">*</span></label>
                            <input type="text" name="rw" class="form-control" maxlength="3" placeholder="001" value="<?= old('rw', '001') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Kode Pos</label>
                            <input type="text" name="kode_pos" class="form-control" maxlength="5" placeholder="16340" value="<?= old('kode_pos', '16340') ?>">
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Desa / Kelurahan</label>
                            <input type="text" name="desa_kelurahan" class="form-control" value="Jampang" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control" value="Gunung Sindur" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Kabupaten / Kota</label>
                            <input type="text" name="kabupaten" class="form-control" value="Bogor" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Provinsi</label>
                            <input type="text" name="provinsi" class="form-control" value="Jawa Barat" readonly>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('kartu-keluarga') ?>" class="btn btn-light border px-4">Batal</a>
                        <button type="submit" class="btn btn-primary-custom px-4">
                            <i class="bi bi-save me-1"></i> Simpan Kartu Keluarga
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
