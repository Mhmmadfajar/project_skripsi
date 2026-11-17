<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card-custom mb-4">
            <div class="card-header-custom">
                <div>
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square text-teal me-2" style="color: #0f766e;"></i> Edit Data Penduduk: <?= esc($penduduk['nama_lengkap']) ?></h5>
                    <span class="text-muted small">Perbarui data kependudukan warga dengan teliti.</span>
                </div>
                <a href="<?= base_url('penduduk') ?>" class="btn btn-outline-secondary btn-sm rounded-3">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="p-4">
                <form action="<?= base_url('penduduk/update/' . $penduduk['nik']) ?>" method="POST">
                    <?= csrf_field() ?>

                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-person-vcard text-teal me-2" style="color: #0f766e;"></i> 1. Identitas Pokok</h6>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Nomor Induk Kependudukan (NIK)</label>
                            <input type="text" class="form-control bg-light font-monospace" value="<?= esc($penduduk['nik']) ?>" readonly>
                            <div class="form-text" style="font-size: 0.75rem;">NIK bersifat permanen dan tidak dapat diubah langsung.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Nomor Kartu Keluarga (No. KK) <span class="text-danger">*</span></label>
                            <input type="text" name="no_kk" list="listKK" class="form-control" maxlength="16" value="<?= esc(old('no_kk', $penduduk['no_kk'])) ?>" required>
                            <datalist id="listKK">
                                <?php foreach ($kkList as $k): ?>
                                    <option value="<?= esc($k['no_kk']) ?>"><?= esc($k['no_kk']) ?> (<?= esc($k['alamat']) ?>)</option>
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-semibold">Nama Lengkap Sesuai Akta / KTP <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" class="form-control" value="<?= esc(old('nama_lengkap', $penduduk['nama_lengkap'])) ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="L" <?= ($penduduk['jenis_kelamin'] === 'L') ? 'selected' : '' ?>>Laki-Laki</option>
                                <option value="P" <?= ($penduduk['jenis_kelamin'] === 'P') ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" value="<?= esc(old('tempat_lahir', $penduduk['tempat_lahir'])) ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="<?= esc(old('tanggal_lahir', $penduduk['tanggal_lahir'])) ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Golongan Darah</label>
                            <select name="golongan_darah" class="form-select">
                                <?php foreach (['-', 'A', 'B', 'AB', 'O'] as $gd): ?>
                                    <option value="<?= $gd ?>" <?= ($penduduk['golongan_darah'] === $gd) ? 'selected' : '' ?>><?= $gd ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-people text-teal me-2" style="color: #0f766e;"></i> 2. Hubungan Keluarga & Sosial</h6>

                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Agama</label>
                            <select name="agama" class="form-select">
                                <?php foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu', 'Lainnya'] as $agm): ?>
                                    <option value="<?= $agm ?>" <?= ($penduduk['agama'] === $agm) ? 'selected' : '' ?>><?= $agm ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Status Perkawinan</label>
                            <select name="status_perkawinan" class="form-select">
                                <?php foreach (['Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati'] as $sp): ?>
                                    <option value="<?= $sp ?>" <?= ($penduduk['status_perkawinan'] === $sp) ? 'selected' : '' ?>><?= $sp ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Status Hubungan (SHDK)</label>
                            <select name="shdk" class="form-select">
                                <?php foreach (['Kepala Keluarga', 'Suami', 'Istri', 'Anak', 'Mantu', 'Cucu', 'Orang Tua', 'Mertua', 'Famili Lain', 'Lainnya'] as $sh): ?>
                                    <option value="<?= $sh ?>" <?= ($penduduk['shdk'] === $sh) ? 'selected' : '' ?>><?= $sh ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Kewarganegaraan</label>
                            <select name="kewarganegaraan" class="form-select">
                                <option value="WNI" <?= ($penduduk['kewarganegaraan'] === 'WNI') ? 'selected' : '' ?>>WNI</option>
                                <option value="WNA" <?= ($penduduk['kewarganegaraan'] === 'WNA') ? 'selected' : '' ?>>WNA</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Pendidikan Terakhir</label>
                            <select name="pendidikan_terakhir" class="form-select">
                                <?php foreach ([
                                    'TIDAK / BELUM SEKOLAH', 'BELUM TAMAT SD/SEDERAJAT', 'TAMAT SD / SEDERAJAT',
                                    'SLTP / SEDERAJAT', 'SLTA / SEDERAJAT', 'DIPLOMA I / II',
                                    'AKADEMI/DIPLOMA III/S.MUDA', 'DIPLOMA IV/ STRATA I', 'STRATA II', 'STRATA III'
                                ] as $pen): ?>
                                    <option value="<?= $pen ?>" <?= ($penduduk['pendidikan_terakhir'] === $pen) ? 'selected' : '' ?>><?= $pen ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control" value="<?= esc(old('pekerjaan', $penduduk['pekerjaan'])) ?>">
                        </div>
                    </div>

                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-geo-alt text-teal me-2" style="color: #0f766e;"></i> 3. Domisili & Wilayah Desa</h6>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="2"><?= esc(old('alamat', $penduduk['alamat'])) ?></textarea>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">RT</label>
                            <input type="text" name="rt" class="form-control" maxlength="3" value="<?= esc(old('rt', $penduduk['rt'])) ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">RW</label>
                            <input type="text" name="rw" class="form-control" maxlength="3" value="<?= esc(old('rw', $penduduk['rw'])) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Desa / Kelurahan</label>
                            <input type="text" name="desa_kelurahan" class="form-control" value="<?= esc(old('desa_kelurahan', $penduduk['desa_kelurahan'])) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control" value="<?= esc(old('kecamatan', $penduduk['kecamatan'])) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Status Keberadaan Penduduk</label>
                            <select name="status_penduduk" class="form-select">
                                <option value="Ada" <?= ($penduduk['status_penduduk'] === 'Ada') ? 'selected' : '' ?>>Ada (Aktif Berdomisili)</option>
                                <option value="Pindah" <?= ($penduduk['status_penduduk'] === 'Pindah') ? 'selected' : '' ?>>Pindah Luar Wilayah</option>
                                <option value="Meninggal" <?= ($penduduk['status_penduduk'] === 'Meninggal') ? 'selected' : '' ?>>Meninggal Dunia</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('penduduk') ?>" class="btn btn-light border px-4">Batal</a>
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
