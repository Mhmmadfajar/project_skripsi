<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card-custom mb-4">
            <div class="card-header-custom">
                <div>
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-arrow-left-right text-teal me-2" style="color: #0f766e;"></i> Formulir Pencatatan Mutasi Kependudukan</h5>
                    <span class="text-muted small">Pilih jenis peristiwa mutasi kependudukan untuk menampilkan isian yang sesuai.</span>
                </div>
                <a href="<?= base_url('mutasi') ?>" class="btn btn-outline-secondary btn-sm rounded-3">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="p-4">
                <form action="<?= base_url('mutasi/simpan') ?>" method="POST" id="formMutasi">
                    <?= csrf_field() ?>

                    <!-- Select Mutation Type -->
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark">Pilih Jenis Peristiwa Mutasi <span class="text-danger">*</span></label>
                        <div class="row g-2">
                            <div class="col-sm-3 col-6">
                                <input type="radio" class="btn-check" name="jenis_mutasi" id="typeLahir" value="Kelahiran" checked onchange="toggleForm()">
                                <label class="btn btn-outline-success w-100 py-3 rounded-3 text-center" for="typeLahir">
                                    <i class="bi bi-gender-ambiguous fs-3 d-block mb-1"></i>
                                    <span class="fw-bold small d-block">Kelahiran</span>
                                    <span style="font-size: 0.7rem;" class="text-muted">Bayi Baru Lahir</span>
                                </label>
                            </div>
                            <div class="col-sm-3 col-6">
                                <input type="radio" class="btn-check" name="jenis_mutasi" id="typeMati" value="Kematian" onchange="toggleForm()">
                                <label class="btn btn-outline-dark w-100 py-3 rounded-3 text-center" for="typeMati">
                                    <i class="bi bi-heartbreak fs-3 d-block mb-1"></i>
                                    <span class="fw-bold small d-block">Kematian</span>
                                    <span style="font-size: 0.7rem;" class="text-muted">Warga Meninggal</span>
                                </label>
                            </div>
                            <div class="col-sm-3 col-6">
                                <input type="radio" class="btn-check" name="jenis_mutasi" id="typeKeluar" value="Pindah Keluar" onchange="toggleForm()">
                                <label class="btn btn-outline-danger w-100 py-3 rounded-3 text-center" for="typeKeluar">
                                    <i class="bi bi-box-arrow-right fs-3 d-block mb-1"></i>
                                    <span class="fw-bold small d-block">Pindah Keluar</span>
                                    <span style="font-size: 0.7rem;" class="text-muted">Keluar Wilayah</span>
                                </label>
                            </div>
                            <div class="col-sm-3 col-6">
                                <input type="radio" class="btn-check" name="jenis_mutasi" id="typeMasuk" value="Pindah Masuk" onchange="toggleForm()">
                                <label class="btn btn-outline-primary w-100 py-3 rounded-3 text-center" for="typeMasuk">
                                    <i class="bi bi-box-arrow-in-right fs-3 d-block mb-1"></i>
                                    <span class="fw-bold small d-block">Pindah Datang</span>
                                    <span style="font-size: 0.7rem;" class="text-muted">Masuk Wilayah</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Common Date -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Tanggal Terjadinya Peristiwa <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mutasi" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Keterangan / Dokumen Pendukung</label>
                            <input type="text" name="keterangan" class="form-control" placeholder="Contoh: No. Surat Keterangan Bidan / RT / Surat Pindah">
                        </div>
                    </div>

                    <!-- Section: Kelahiran -->
                    <div id="sectionKelahiran" class="border rounded-3 p-3 bg-light mb-4">
                        <h6 class="fw-bold text-success mb-3"><i class="bi bi-check-circle me-1"></i> Data Bayi Yang Lahir</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Nomor KK Orang Tua <span class="text-danger">*</span></label>
                                <select name="no_kk" class="form-select">
                                    <option value="">-- Pilih Kartu Keluarga --</option>
                                    <?php foreach ($kkList as $kk): ?>
                                        <option value="<?= esc($kk['no_kk']) ?>"><?= esc($kk['no_kk']) ?> (<?= esc($kk['alamat']) ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">NIK Bayi (Sesuai KK Baru) <span class="text-danger">*</span></label>
                                <input type="text" name="nik_bayi" class="form-control" maxlength="16" placeholder="16 digit NIK bayi">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Nama Lengkap Bayi <span class="text-danger">*</span></label>
                                <input type="text" name="nama_bayi" class="form-control" placeholder="Nama Bayi">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select">
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" value="Bogor">
                            </div>
                        </div>
                    </div>

                    <!-- Section: Kematian / Pindah Keluar -->
                    <div id="sectionPilihWarga" class="border rounded-3 p-3 bg-light mb-4" style="display: none;">
                        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-person-fill me-1"></i> Pilih Warga Yang Bersangkutan</h6>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Nama / NIK Penduduk <span class="text-danger">*</span></label>
                            <select name="nik_terkait" class="form-select">
                                <option value="">-- Cari / Pilih Penduduk --</option>
                                <?php foreach ($pendudukList as $p): ?>
                                    <option value="<?= esc($p['nik']) ?>">
                                        <?= esc($p['nama_lengkap']) ?> (NIK: <?= esc($p['nik']) ?> - RT <?= esc($p['rt']) ?>/RW <?= esc($p['rw']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text" style="font-size: 0.75rem;">Status kependudukan warga yang dipilih akan otomatis diperbarui.</div>
                        </div>
                    </div>

                    <!-- Section: Pindah Masuk -->
                    <div id="sectionPindahMasuk" class="border rounded-3 p-3 bg-light mb-4" style="display: none;">
                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-person-plus-fill me-1"></i> Data Penduduk Pendatang (Pindah Masuk)</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Kartu Keluarga Tujuan <span class="text-danger">*</span></label>
                                <select name="no_kk_tujuan" class="form-select">
                                    <option value="">-- Pilih Kartu Keluarga Tujuan --</option>
                                    <?php foreach ($kkList as $kk): ?>
                                        <option value="<?= esc($kk['no_kk']) ?>"><?= esc($kk['no_kk']) ?> (<?= esc($kk['alamat']) ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">NIK Pendatang <span class="text-danger">*</span></label>
                                <input type="text" name="nik_baru" class="form-control" maxlength="16" placeholder="16 digit NIK">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_baru" class="form-control" placeholder="Nama lengkap">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold">Jenis Kelamin</label>
                                <select name="jenis_kelamin_baru" class="form-select">
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold">Status Hubungan</label>
                                <select name="shdk_baru" class="form-select">
                                    <option value="Famili Lain">Famili Lain</option>
                                    <option value="Suami">Suami</option>
                                    <option value="Istri">Istri</option>
                                    <option value="Anak">Anak</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('mutasi') ?>" class="btn btn-light border px-4">Batal</a>
                        <button type="submit" class="btn btn-primary-custom px-4">
                            <i class="bi bi-save me-1"></i> Simpan Catatan Mutasi
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
    function toggleForm() {
        const typeLahir = document.getElementById('typeLahir').checked;
        const typeMati = document.getElementById('typeMati').checked;
        const typeKeluar = document.getElementById('typeKeluar').checked;
        const typeMasuk = document.getElementById('typeMasuk').checked;

        const secLahir = document.getElementById('sectionKelahiran');
        const secPilih = document.getElementById('sectionPilihWarga');
        const secMasuk = document.getElementById('sectionPindahMasuk');

        if (typeLahir) {
            secLahir.style.display = 'block';
            secPilih.style.display = 'none';
            secMasuk.style.display = 'none';
        } else if (typeMati || typeKeluar) {
            secLahir.style.display = 'none';
            secPilih.style.display = 'block';
            secMasuk.style.display = 'none';
        } else if (typeMasuk) {
            secLahir.style.display = 'none';
            secPilih.style.display = 'none';
            secMasuk.style.display = 'block';
        }
    }
</script>
<?= $this->endSection() ?>
