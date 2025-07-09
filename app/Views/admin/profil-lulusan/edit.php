<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0"><?= $title ?></h5>
    </div>
    <div class="card-body">
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

        <form action="<?= base_url('admin/profil-lulusan/update/' . $profil['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                <input
                    class="form-control <?= (isset($errors['gambar'])) ? 'is-invalid' : '' ?>"
                    type="file"
                    id="gambar"
                    name="gambar"
                    accept="image/*" />
                <div id="gambarHelpId" class="form-text text-muted">Pilih gambar baru (maksimal 2MB). Kosongkan jika tidak ingin mengubah gambar.</div>
                <?php if (isset($errors['gambar'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['gambar'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3" id="gambarPreviewContainer">
                <label class="form-label">Pratinjau Gambar Saat Ini</label>
                <div class="border rounded p-2 text-center">
                    <?php if (!empty($profil['gambar'])): ?>
                        <img id="gambarPreview" src="<?= base_url('uploads/profil_lulusan/' . $profil['gambar']) ?>" alt="Pratinjau Gambar" class="img-fluid" style="max-height: 200px; object-fit: contain;">
                    <?php else: ?>
                        <p class="text-muted">Tidak ada gambar saat ini.</p>
                        <img id="gambarPreview" src="#" alt="Pratinjau Gambar Baru" class="img-fluid" style="max-height: 200px; object-fit: contain; display: none;">
                    <?php endif; ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="judul" class="form-label">Judul (Opsional)</label>
                <input
                    type="text"
                    class="form-control <?= (isset($errors['judul'])) ? 'is-invalid' : '' ?>"
                    name="judul"
                    id="judul"
                    value="<?= old('judul', $profil['judul'] ?? '') ?>"
                    placeholder="Masukkan judul profil lulusan" />
                <?php if (isset($errors['judul'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['judul'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi (Opsional)</label>
                <textarea
                    class="form-control <?= (isset($errors['deskripsi'])) ? 'is-invalid' : '' ?>"
                    name="deskripsi"
                    id="deskripsi"
                    rows="5"
                    placeholder="Masukkan deskripsi profil lulusan"><?= old('deskripsi', $profil['deskripsi'] ?? '') ?></textarea>
                <?php if (isset($errors['deskripsi'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['deskripsi'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <hr>

            <div class="d-flex justify-content-end gap-2">
                <a
                    class="btn btn-secondary"
                    href="<?= base_url('admin/profil-lulusan') ?>"
                    role="button">
                    Kembali
                </a>
                <button
                    type="submit"
                    class="btn btn-primary">
                    Perbarui Profil Lulusan
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<!-- TinyMCE Editor -->
<script src="<?= base_url('assets/vendor/tinymce/tinymce.min.js') ?>"></script>
<script>
    // Inisialisasi TinyMCE
    // TinyMCE hanya akan diinisialisasi pada textarea dengan class 'editor'
    tinymce.init({
        selector: 'textarea.editor', // Selector untuk textarea Anda
        plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        content_css: '<?= base_url('assets/css/tinymce-content.css') ?>', // Opsional: CSS kustom untuk konten editor
        height: 300,
    });

    // JavaScript untuk pratinjau gambar
    document.getElementById('gambar').addEventListener('change', function(event) {
        const [file] = event.target.files;
        const previewImage = document.getElementById('gambarPreview');
        const currentImageExists = "<?= !empty($profil['gambar']) ? 'true' : 'false' ?>";

        if (file) {
            if (file.type.startsWith('image/')) {
                previewImage.src = URL.createObjectURL(file);
                previewImage.style.display = 'block';
            } else {
                // Jika file bukan gambar, tampilkan gambar lama jika ada, atau sembunyikan pratinjau
                if (currentImageExists === 'true') {
                    previewImage.src = "<?= base_url('uploads/profil_lulusan/' . $profil['gambar']) ?>";
                    previewImage.style.display = 'block';
                } else {
                    previewImage.style.display = 'none';
                    previewImage.src = '#';
                }
            }
        } else {
            // Jika tidak ada file yang dipilih, tampilkan gambar lama jika ada, atau sembunyikan pratinjau
            if (currentImageExists === 'true') {
                previewImage.src = "<?= base_url('uploads/profil_lulusan/' . $profil['gambar']) ?>";
                previewImage.style.display = 'block';
            } else {
                previewImage.style.display = 'none';
                previewImage.src = '#';
            }
        }
    });
</script>
<?= $this->endSection() ?>