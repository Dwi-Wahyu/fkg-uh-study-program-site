<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-body">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5>Error</h5>
                <ul>

                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="post" action="/admin/sarana-prasarana/store" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Sarana/Prasarana</label>
                <input
                    type="text"
                    class="form-control <?= (isset($errors['nama'])) ? 'is-invalid' : '' ?>"
                    name="nama"
                    id="nama"
                    placeholder="Masukkan nama sarana atau prasarana"
                    value="<?= old('nama') ?>" />
                <?php if (isset($errors['nama'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['nama'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Sarana/Prasarana (Opsional)</label>
                <textarea
                    class="form-control <?= (isset($errors['deskripsi'])) ? 'is-invalid' : '' ?>"
                    name="deskripsi"
                    id="deskripsi"
                    rows="5"
                    placeholder="Masukkan deskripsi lengkap sarana atau prasarana"><?= old('deskripsi') ?></textarea>
                <?php if (isset($errors['deskripsi'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['deskripsi'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="gambar_thumbnail" class="form-label">Unggah Gambar Thumbnail <span class="text-danger">*</span></label>
                <input
                    type="file"
                    class="form-control <?= (isset($errors['gambar_thumbnail'])) ? 'is-invalid' : '' ?>"
                    name="gambar_thumbnail"
                    id="gambar_thumbnail"
                    aria-describedby="gambarThumbnailHelpId"
                    accept="image/*" />
                <div id="gambarThumbnailHelpId" class="form-text text-muted">Pilih gambar sebagai thumbnail (JPG, JPEG, PNG, GIF, WEBP). Wajib diisi.</div>
                <?php if (isset($errors['gambar_thumbnail'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['gambar_thumbnail'] ?>
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
                <label for="file_video" class="form-label">Unggah Video (Opsional)</label>
                <input
                    type="file"
                    class="form-control <?= (isset($errors['file_video'])) ? 'is-invalid' : '' ?>"
                    name="file_video"
                    id="file_video"
                    aria-describedby="fileVideoHelpId"
                    accept="video/mp4,video/webm,video/ogg" />
                <div id="fileVideoHelpId" class="form-text text-muted">Pilih file video (MP4, WebM, Ogg). Ukuran maksimal 20MB. Opsional.</div>
                <?php if (isset($errors['file_video'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['file_video'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a
                    class="btn btn-secondary"
                    href="/admin/sarana-prasarana"
                    role="button">
                    Kembali
                </a>

                <button
                    type="submit"
                    class="btn btn-primary">
                    Simpan Sarana/Prasarana
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
    // JavaScript untuk pratinjau gambar thumbnail
    document.getElementById('gambar_thumbnail').addEventListener('change', function(event) {
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