<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card-custom mb-4">
            <div class="card-header-custom">
                <div>
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-person-plus-fill text-teal me-2" style="color: #0f766e;"></i> Formulir Tambah Data Penduduk</h5>
                    <span class="text-muted small">Masukkan informasi identitas kependudukan warga secara lengkap.</span>
                </div>
                <a href="<?= base_url('penduduk') ?>" class="btn btn-outline-secondary btn-sm rounded-3">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="p-4">
                <form action="<?= base_url('penduduk/simpan') ?>" method="POST">
                    <?= csrf_field() ?>

                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-person-vcard text-teal me-2" style="color: #0f766e;"></i> 1. Identitas Pokok</h6>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Nomor Induk Kependudukan (NIK) <span class="text-danger">*</span></label>
                            <input type="text" name="nik" class="form-control" maxlength="16" placeholder="16 Digit NIK KTP" value="<?= old('nik') ?>" required autofocus>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Nomor Kartu Keluarga (No. KK) <span class="text-danger">*</span></label>
                            <input type="text" name="no_kk" list="listKK" class="form-control" maxlength="16" placeholder="16 Digit No. KK" value="<?= old('no_kk') ?>" required>
                            <datalist id="listKK">
                                <?php foreach ($kkList as $k): ?>
                                    <option value="<?= esc($k['no_kk']) ?>"><?= esc($k['no_kk']) ?> (<?= esc($k['alamat']) ?>)</option>
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-semibold">Nama Lengkap Sesuai Akta / KTP <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" value="<?= old('nama_lengkap') ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="L" <?= (old('jenis_kelamin') === 'L') ? 'selected' : '' ?>>Laki-Laki</option>
                                <option value="P" <?= (old('jenis_kelamin') === 'P') ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" placeholder="Kota / Kabupaten Lahir" value="<?= old('tempat_lahir', 'Bogor') ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="<?= old('tanggal_lahir') ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">Golongan Darah</label>
                            <select name="golongan_darah" class="form-select">
                                <option value="-">-</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>
                    </div>

                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-people text-teal me-2" style="color: #0f766e;"></i> 2. Hubungan Keluarga & Sosial</h6>

                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Agama</label>
                            <select name="agama" class="form-select">
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Khonghucu">Khonghucu</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Status Perkawinan</label>
                            <select name="status_perkawinan" class="form-select">
                                <option value="Belum Menikah">Belum Menikah</option>
                                <option value="Menikah">Menikah</option>
                                <option value="Cerai Hidup">Cerai Hidup</option>
                                <option value="Cerai Mati">Cerai Mati</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Status Hubungan (SHDK)</label>
                            <select name="shdk" class="form-select">
                                <option value="Kepala Keluarga">Kepala Keluarga</option>
                                <option value="Suami">Suami</option>
                                <option value="Istri">Istri</option>
                                <option value="Anak">Anak</option>
                                <option value="Mantu">Mantu</option>
                                <option value="Cucu">Cucu</option>
                                <option value="Orang Tua">Orang Tua</option>
                                <option value="Mertua">Mertua</option>
                                <option value="Famili Lain">Famili Lain</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Kewarganegaraan</label>
                            <select name="kewarganegaraan" class="form-select">
                                <option value="WNI">WNI</option>
                                <option value="WNA">WNA</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Pendidikan Terakhir</label>
                            <select name="pendidikan_terakhir" class="form-select">
                                <option value="TIDAK / BELUM SEKOLAH">TIDAK / BELUM SEKOLAH</option>
                                <option value="BELUM TAMAT SD/SEDERAJAT">BELUM TAMAT SD/SEDERAJAT</option>
                                <option value="TAMAT SD / SEDERAJAT">TAMAT SD / SEDERAJAT</option>
                                <option value="SLTP / SEDERAJAT">SLTP / SEDERAJAT</option>
                                <option value="SLTA / SEDERAJAT">SLTA / SEDERAJAT</option>
                                <option value="DIPLOMA I / II">DIPLOMA I / II</option>
                                <option value="AKADEMI/DIPLOMA III/S.MUDA">AKADEMI/DIPLOMA III/S.MUDA</option>
                                <option value="DIPLOMA IV/ STRATA I">DIPLOMA IV/ STRATA I</option>
                                <option value="STRATA II">STRATA II</option>
                                <option value="STRATA III">STRATA III</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control" placeholder="Contoh: Wiraswasta, Guru, Karyawan Swasta" value="<?= old('pekerjaan', 'Belum/Tidak Bekerja') ?>">
                        </div>
                    </div>

                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-geo-alt text-teal me-2" style="color: #0f766e;"></i> 3. Domisili & Wilayah Desa</h6>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Alamat Lengkap / Nama Jalan / Dusun</label>
                            <textarea name="alamat" class="form-control" rows="2" placeholder="Nama Jalan, Gang, Nomor Rumah..."><?= old('alamat', 'Jl. Raya Jampang') ?></textarea>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">RT</label>
                            <input type="text" name="rt" class="form-control" maxlength="3" placeholder="001" value="<?= old('rt', '001') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">RW</label>
                            <input type="text" name="rw" class="form-control" maxlength="3" placeholder="001" value="<?= old('rw', '001') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Desa / Kelurahan</label>
                            <input type="text" name="desa_kelurahan" class="form-control" value="Jampang" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control" value="Gunung Sindur" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Status Keberadaan Penduduk</label>
                            <select name="status_penduduk" class="form-select">
                                <option value="Ada">Ada (Aktif Berdomisili)</option>
                                <option value="Pindah">Pindah Luar Wilayah</option>
                                <option value="Meninggal">Meninggal Dunia</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('penduduk') ?>" class="btn btn-light border px-4">Batal</a>
                        <button type="submit" class="btn btn-primary-custom px-4">
                            <i class="bi bi-save me-1"></i> Simpan Data Penduduk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
