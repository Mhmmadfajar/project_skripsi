<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-custom mb-4">
            <div class="card-header-custom">
                <div>
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square text-teal me-2" style="color: #0f766e;"></i> Edit Kartu Keluarga: <?= esc($kk['no_kk']) ?></h5>
                    <span class="text-muted small">Perbarui data alamat dan tentukan kepala keluarga.</span>
                </div>
                <a href="<?= base_url('kartu-keluarga/detail/' . $kk['no_kk']) ?>" class="btn btn-outline-secondary btn-sm rounded-3">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="p-4">
                <form action="<?= base_url('kartu-keluarga/update/' . $kk['no_kk']) ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nomor Kartu Keluarga (No. KK)</label>
                        <input type="text" class="form-control bg-light font-monospace" value="<?= esc($kk['no_kk']) ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Pilih Kepala Keluarga</label>
                        <select name="nik_kepala_keluarga" class="form-select">
                            <option value="">-- Belum Ditentukan --</option>
                            <?php foreach ($anggota as $ang): ?>
                                <option value="<?= esc($ang['nik']) ?>" <?= ($kk['nik_kepala_keluarga'] == $ang['nik']) ? 'selected' : '' ?>>
                                    <?= esc($ang['nama_lengkap']) ?> (NIK: <?= esc($ang['nik']) ?> - <?= esc($ang['shdk']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text" style="font-size: 0.75rem;">Pilih dari salah satu anggota keluarga yang terdaftar pada KK ini.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Alamat Lengkap Tempat Tinggal <span class="text-danger">*</span></label>
                        <textarea name="alamat" class="form-control" rows="2" required><?= esc(old('alamat', $kk['alamat'])) ?></textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">RT <span class="text-danger">*</span></label>
                            <input type="text" name="rt" class="form-control" maxlength="3" value="<?= esc(old('rt', $kk['rt'])) ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">RW <span class="text-danger">*</span></label>
                            <input type="text" name="rw" class="form-control" maxlength="3" value="<?= esc(old('rw', $kk['rw'])) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Kode Pos</label>
                            <input type="text" name="kode_pos" class="form-control" maxlength="5" value="<?= esc(old('kode_pos', $kk['kode_pos'])) ?>">
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Desa / Kelurahan</label>
                            <input type="text" name="desa_kelurahan" class="form-control" value="<?= esc($kk['desa_kelurahan']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control" value="<?= esc($kk['kecamatan']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Kabupaten / Kota</label>
                            <input type="text" name="kabupaten" class="form-control" value="<?= esc($kk['kabupaten']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Provinsi</label>
                            <input type="text" name="provinsi" class="form-control" value="<?= esc($kk['provinsi']) ?>">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('kartu-keluarga') ?>" class="btn btn-light border px-4">Batal</a>
                        <button type="submit" class="btn btn-primary-custom px-4">
                            <i class="bi bi-check2-circle me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
