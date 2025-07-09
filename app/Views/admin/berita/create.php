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

        <form action="/admin/berita/store" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="judul" class="form-label">Judul Berita <span class="text-danger">*</span></label>
                <input
                    type="text"
                    class="form-control <?= (isset($errors['judul'])) ? 'is-invalid' : '' ?>"
                    name="judul"
                    id="judul"
                    value="<?= old('judul') ?>"
                    placeholder="Masukkan judul berita"
                    required />
                <?php if (isset($errors['judul'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['judul'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="gambar" class="form-label">Thumbnail</label>
                <input
                    class="form-control <?= (isset($errors['gambar'])) ? 'is-invalid' : '' ?>"
                    type="file"
                    id="gambar"
                    name="gambar"
                    accept="image/*" />
                <div id="gambarHelpId" class="form-text text-muted">Pilih gambar thumbnail (maksimal 2MB). Opsional.</div>
                <?php if (isset($errors['gambar'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['gambar'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3" id="thumbnailPreviewContainer" style="display: none;">
                <label class="form-label">Pratinjau Gambar Thumbnail</label>
                <div class="border rounded p-2 text-center">
                    <img id="thumbnailPreview" src="#" alt="Pratinjau Thumbnail" class="img-fluid" style="max-height: 200px; object-fit: contain;">
                </div>
            </div>

            <div class="mb-3">
                <label for="deskripsi_singkat" class="form-label">Deskripsi Singkat</label>
                <textarea
                    class="form-control <?= (isset($errors['deskripsi_singkat'])) ? 'is-invalid' : '' ?>"
                    name="deskripsi_singkat"
                    id="deskripsi_singkat"
                    rows="3"
                    placeholder="Masukkan deskripsi singkat berita (opsional)"><?= old('deskripsi_singkat') ?></textarea>
                <?php if (isset($errors['deskripsi_singkat'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['deskripsi_singkat'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="vignette mb-3">
                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                    <label for="detail" class="mb-1">Detail Berita:</label>
                    <textarea class="editor" name="detail" id="detail"><?= old('detail') ?></textarea>
                    <?php if (isset($errors['detail'])): ?>
                        <div class="invalid-feedback d-block"> {{-- d-block agar pesan validasi muncul --}}
                            <?= $errors['detail'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-end gap-2">
                <a
                    class="btn btn-secondary"
                    href="/admin/berita"
                    role="button">
                    Kembali
                </a>

                <button
                    type="submit"
                    class="btn btn-primary">
                    Simpan Berita
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
    tinymce.init({
        selector: 'textarea.editor', // Selector untuk textarea Anda
        plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        content_css: '<?= base_url('assets/css/tinymce-content.css') ?>', // Opsional: CSS kustom untuk konten editor
        height: 400,
    });

    // JavaScript untuk pratinjau gambar thumbnail
    document.getElementById('gambar').addEventListener('change', function(event) {
        const [file] = event.target.files;
        const previewContainer = document.getElementById('thumbnailPreviewContainer');
        const previewImage = document.getElementById('thumbnailPreview');

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