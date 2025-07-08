<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="card">

    <div class="card-body">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="/admin/media-berita/store" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="fileUpload" class="form-label">Pilih File</label>
                <input
                    type="file"
                    class="form-control"
                    name="media_file"
                    id="fileUpload"
                    aria-describedby="fileHelpId"
                    accept="image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" {{-- Menambahkan atribut accept --}} />
                <div id="fileHelpId" class="form-text text-muted">Pilih file gambar, PDF, atau dokumen Word.</div>
            </div>

            <div class="mb-3" id="imagePreviewContainer" style="display: none;">
                <label class="form-label">Pratinjau Gambar</label>
                <div class="border rounded p-2 text-center">
                    <img id="imagePreview" src="#" alt="Pratinjau Gambar" class="img-fluid" style="max-height: 200px; object-fit: contain;">
                </div>
            </div>

            <div class="mb-3">
                <label for="altText" class="form-label">Teks Alternatif (Alt Text)</label>
                <input
                    type="text"
                    class="form-control"
                    name="alt_text"
                    id="altText"
                    placeholder="Masukkan deskripsi singkat untuk aksesibilitas"
                    maxlength="255" {{-- Batasi panjang karakter --}} />
                <div id="altTextHelp" class="form-text text-muted">Teks ini penting untuk aksesibilitas dan SEO.</div>
            </div>

            <hr>

            <div class="d-flex justify-content-end gap-2">
                <a
                    class="btn btn-secondary"
                    href="/admin/media-berita"
                    role="button">
                    Kembali
                </a>

                <button
                    type="submit"
                    class="btn btn-primary">
                    Unggah
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
    document.getElementById('fileUpload').addEventListener('change', function(event) {
        const [file] = event.target.files;
        const previewContainer = document.getElementById('imagePreviewContainer');
        const previewImage = document.getElementById('imagePreview');

        console.log('Selected file:', file);

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