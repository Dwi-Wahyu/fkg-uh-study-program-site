<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="card">

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

        <form action="<?= base_url('admin/profil-lulusan/store') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar <span class="text-danger">*</span></label>
                <input
                    class="form-control <?= (isset($errors['gambar'])) ? 'is-invalid' : '' ?>"
                    type="file"
                    id="gambar"
                    name="gambar"
                    accept="image/*"
                    required />
                <div id="gambarHelpId" class="form-text text-muted">Pilih gambar (maksimal 20MB).</div> <!-- Diubah dari 2MB menjadi 20MB -->
                <?php if (isset($errors['gambar'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['gambar'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3" id="gambarPreviewContainer" style="display: none;">
                <label class="form-label">Pratinjau Gambar</label>
                <div class="border rounded p-2 text-center">
                    <img id="gambarPreview" src="#" alt="Pratinjau Gambar" class="img-fluid" style="max-height: 200px; object-fit: contain;">
                </div>
            </div>

            <div class="mb-3">
                <label for="judul" class="form-label">Judul (Opsional)</label>
                <input
                    type="text"
                    class="form-control <?= (isset($errors['judul'])) ? 'is-invalid' : '' ?>"
                    name="judul"
                    id="judul"
                    value="<?= old('judul') ?>"
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
                    placeholder="Masukkan deskripsi profil lulusan"><?= old('deskripsi') ?></textarea>
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
                    Simpan Profil Lulusan
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
        const previewContainer = document.getElementById('gambarPreviewContainer');
        const previewImage = document.getElementById('gambarPreview');

        if (file) {
            if (file.type.startsWith('image/')) {
                previewImage.src = URL.createObjectURL(file);
                previewContainer.style.display = 'block';
            } else {
                previewContainer.style.display = 'none';
                previewImage.src = '#';
            }
        } else {
            previewContainer.style.display = 'none';
            previewImage.src = '#';
        }
    });
</script>
<?= $this->endSection() ?>