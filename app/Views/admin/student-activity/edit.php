<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-body">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check2-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="post" action="/admin/student-activity/update/<?= $activity['id'] ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="judul" class="form-label">Judul Aktivitas</label>
                <input
                    type="text"
                    class="form-control <?= (isset($errors['judul'])) ? 'is-invalid' : '' ?>"
                    name="judul"
                    id="judul"
                    placeholder="Masukkan judul aktivitas"
                    value="<?= old('judul', $activity['judul']) ?>" />
                <?php if (isset($errors['judul'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['judul'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Aktivitas</label>
                <textarea
                    class="form-control <?= (isset($errors['deskripsi'])) ? 'is-invalid' : '' ?>"
                    name="deskripsi"
                    id="deskripsi"
                    rows="5"
                    placeholder="Masukkan deskripsi lengkap aktivitas"><?= old('deskripsi', $activity['deskripsi']) ?></textarea>
                <?php if (isset($errors['deskripsi'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['deskripsi'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Aktivitas</label>
                <input
                    type="date"
                    class="form-control <?= (isset($errors['tanggal'])) ? 'is-invalid' : '' ?>"
                    name="tanggal"
                    id="tanggal"
                    value="<?= old('tanggal', $activity['tanggal']) ?>" />
                <?php if (isset($errors['tanggal'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['tanggal'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="gambar" class="form-label">Unggah Gambar (Biarkan kosong jika tidak ingin mengubah)</label>
                <input
                    type="file"
                    class="form-control <?= (isset($errors['gambar'])) ? 'is-invalid' : '' ?>"
                    name="gambar"
                    id="gambar"
                    aria-describedby="gambarHelpId"
                    accept="image/*" />
                <div id="gambarHelpId" class="form-text text-muted">Pilih file gambar baru (JPG, JPEG, PNG, GIF, WEBP).</div>
                <?php if (isset($errors['gambar'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['gambar'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3" id="imagePreviewContainer" style="display: <?= !empty($activity['gambar']) ? 'block' : 'none' ?>;">
                <label class="form-label">Pratinjau Gambar Saat Ini</label>
                <div class="border rounded p-2 text-center">
                    <img id="imagePreview"
                        src="<?= !empty($activity['gambar']) ? base_url('student-activity/' . $activity['gambar']) : '#' ?>"
                        alt="Pratinjau Gambar"
                        class="img-fluid"
                        style="max-height: 200px; object-fit: contain;">
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-end gap-2">
                <a
                    class="btn btn-secondary"
                    href="/admin/student-activity"
                    role="button">
                    Kembali
                </a>

                <button
                    type="submit"
                    class="btn btn-primary">
                    Perbarui Aktivitas
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
    document.getElementById('gambar').addEventListener('change', function(event) {
        const [file] = event.target.files;
        const previewContainer = document.getElementById('imagePreviewContainer');
        const previewImage = document.getElementById('imagePreview');

        if (file) {
            if (file.type.startsWith('image/')) {
                previewImage.src = URL.createObjectURL(file);
                previewContainer.style.display = 'block';
            } else {
                previewContainer.style.display = 'none';
                previewImage.src = '#'; // Reset src jika bukan gambar
            }
        } else {
            // Jika file dihapus setelah dipilih, atau tidak ada file baru yang dipilih
            // dan sebelumnya sudah ada gambar, tampilkan gambar lama
            // Jika tidak ada gambar lama dan tidak ada file baru, sembunyikan
            const currentImageUrl = "<?= !empty($activity['gambar']) ? base_url('student-activity/' . $activity['gambar']) : '#' ?>";
            if (currentImageUrl !== '#') {
                previewImage.src = currentImageUrl;
                previewContainer.style.display = 'block';
            } else {
                previewContainer.style.display = 'none';
                previewImage.src = '#';
            }
        }
    });
</script>
<?= $this->endSection() ?>