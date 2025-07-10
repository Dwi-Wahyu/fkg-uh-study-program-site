<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn btn-outline" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
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

                <?= form_open_multipart(base_url('admin/kurikulum/store')) ?>
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar <span class="text-danger">*</span></label>
                    <input
                        class="form-control <?= ($validation->hasError('gambar')) ? 'is-invalid' : '' ?>"
                        type="file"
                        id="gambar"
                        name="gambar"
                        accept="image/*"
                        required />
                    <div id="gambarHelpId" class="form-text text-muted">Pilih gambar (maksimal 20MB).</div>
                    <?php if ($validation->hasError('gambar')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('gambar') ?>
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
                    <label for="keterangan" class="form-label">Keterangan (ID)</label>
                    <textarea
                        class="form-control <?= ($validation->hasError('keterangan')) ? 'is-invalid' : '' ?>"
                        name="keterangan"
                        id="keterangan"
                        rows="5"
                        placeholder="Masukkan keterangan kurikulum dalam Bahasa Indonesia"><?= old('keterangan') ?></textarea>
                    <?php if ($validation->hasError('keterangan')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('keterangan') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="keterangan_en" class="form-label">Keterangan (EN)</label>
                    <textarea
                        class="form-control <?= ($validation->hasError('keterangan_en')) ? 'is-invalid' : '' ?>"
                        name="keterangan_en"
                        id="keterangan_en"
                        rows="5"
                        placeholder="Enter curriculum description in English"><?= old('keterangan_en') ?></textarea>
                    <?php if ($validation->hasError('keterangan_en')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('keterangan_en') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <hr>

                <div class="d-flex justify-content-end gap-2">
                    <a
                        class="btn btn-secondary"
                        href="<?= base_url('admin/kurikulum') ?>"
                        role="button">
                        Kembali
                    </a>
                    <button
                        type="submit"
                        class="btn btn-primary">
                        Simpan Kurikulum
                    </button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
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
                // Jika file bukan gambar, sembunyikan pratinjau dan reset src
                previewContainer.style.display = 'none';
                previewImage.src = '#';
            }
        } else {
            // Jika tidak ada file yang dipilih, sembunyikan pratinjau
            previewContainer.style.display = 'none';
            previewImage.src = '#';
        }
    });
</script>
<?= $this->endSection() ?>