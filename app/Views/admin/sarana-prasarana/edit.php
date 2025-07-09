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

        <form method="post" action="/admin/sarana-prasarana/update/<?= $sarpras['id'] ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Sarana/Prasarana</label>
                <input
                    type="text"
                    class="form-control <?= (isset($errors['nama'])) ? 'is-invalid' : '' ?>"
                    name="nama"
                    id="nama"
                    placeholder="Masukkan nama sarana atau prasarana"
                    value="<?= old('nama', $sarpras['nama'] ?? '') ?>" />
                <?php if (isset($errors['nama'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['nama'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Sarana/Prasarana</label>
                <textarea
                    class="form-control <?= (isset($errors['deskripsi'])) ? 'is-invalid' : '' ?>"
                    name="deskripsi"
                    id="deskripsi"
                    rows="5"
                    placeholder="Masukkan deskripsi lengkap sarana atau prasarana"><?= old('deskripsi', $sarpras['deskripsi'] ?? '') ?></textarea>
                <?php if (isset($errors['deskripsi'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['deskripsi'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="gambar_thumbnail" class="form-label">Unggah Gambar Thumbnail (Biarkan kosong jika tidak mengubah)</label>
                <input
                    type="file"
                    class="form-control <?= (isset($errors['gambar_thumbnail'])) ? 'is-invalid' : '' ?>"
                    name="gambar_thumbnail"
                    id="gambar_thumbnail"
                    aria-describedby="gambarThumbnailHelpId"
                    accept="image/*" />
                <div id="gambarThumbnailHelpId" class="form-text text-muted">Pilih gambar baru sebagai thumbnail (JPG, JPEG, PNG, GIF, WEBP).</div>
                <?php if (isset($errors['gambar_thumbnail'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['gambar_thumbnail'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3" id="thumbnailPreviewContainer" style="display: <?= !empty($sarpras['gambar_thumbnail']) ? 'block' : 'none' ?>;">
                <label class="form-label">Pratinjau Gambar Thumbnail Saat Ini</label>
                <div class="border rounded p-2 text-center">
                    <img id="thumbnailPreview"
                        src="<?= !empty($sarpras['gambar_thumbnail']) ? base_url('sarana-prasarana/' . $sarpras['gambar_thumbnail']) : '#' ?>"
                        alt="Pratinjau Thumbnail"
                        class="img-fluid"
                        style="max-height: 200px; object-fit: contain;">
                </div>

            </div>

            <div class="mb-3">
                <label for="file_video" class="form-label">Unggah Video (Biarkan kosong jika tidak mengubah)</label>
                <input
                    type="file"
                    class="form-control <?= (isset($errors['file_video'])) ? 'is-invalid' : '' ?>"
                    name="file_video"
                    id="file_video"
                    aria-describedby="fileVideoHelpId"
                    accept="video/mp4,video/webm,video/ogg" />
                <div id="fileVideoHelpId" class="form-text text-muted">Pilih file video baru (MP4, WebM, Ogg). Ukuran maksimal 100MB.</div>
                <?php if (isset($errors['file_video'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['file_video'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3" id="videoPreviewContainer" style="display: <?= !empty($sarpras['file_video']) ? 'block' : 'none' ?>;">
                <label class="form-label">Video Saat Ini</label>
                <div class="border rounded p-2 text-center">
                    <?php if (!empty($sarpras['file_video'])): ?>
                        <video id="videoPreview" controls class="img-fluid" style="max-height: 200px;">
                            <source src="<?= base_url('sarana-prasarana/' . $sarpras['file_video']) ?>" type="<?= mime_content_type(ROOTPATH . 'public/sarana-prasarana/' . $sarpras['file_video']) ?? 'video/mp4' ?>">
                            Maaf, browser Anda tidak mendukung tag video.
                        </video>

                    <?php else: ?>
                        <p class="text-muted">Tidak ada video saat ini.</p>
                    <?php endif; ?>
                </div>
            </div>

            <hr>

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
                    Perbarui Sarana/Prasarana
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
        const removeThumbnailCheckbox = document.getElementById('removeThumbnailCheckbox');

        if (file) {
            if (file.type.startsWith('image/')) {
                previewImage.src = URL.createObjectURL(file);
                previewContainer.style.display = 'block';
                if (removeThumbnailCheckbox) removeThumbnailCheckbox.checked = false; // Hapus centang hapus jika ada file baru
            } else {
                // Jika bukan gambar, sembunyikan pratinjau dan reset src
                previewContainer.style.display = 'none';
                previewImage.src = '#';
            }
        } else {
            // Jika tidak ada file baru dipilih, kembali ke gambar lama atau sembunyikan
            const currentImageUrl = "<?= !empty($sarpras['gambar_thumbnail']) ? base_url('sarana-prasarana/' . $sarpras['gambar_thumbnail']) : '#' ?>";
            if (currentImageUrl !== '#') {
                previewImage.src = currentImageUrl;
                previewContainer.style.display = 'block';
            } else {
                previewContainer.style.display = 'none';
                previewImage.src = '#';
            }
        }
    });

    const removeThumbnailCheckbox = document.getElementById('removeThumbnailCheckbox');
    if (removeThumbnailCheckbox) {
        removeThumbnailCheckbox.addEventListener('change', function() {
            const previewContainer = document.getElementById('thumbnailPreviewContainer');
            const previewImage = document.getElementById('thumbnailPreview');
            if (this.checked) {
                previewImage.src = '#'; // Kosongkan pratinjau
                previewContainer.style.display = 'none'; // Sembunyikan pratinjau
                document.getElementById('gambar_thumbnail').value = ''; // Hapus file dari input
            } else {
                // Tampilkan gambar lama lagi jika checkbox tidak dicentang dan ada gambar lama
                const currentImageUrl = "<?= !empty($sarpras['gambar_thumbnail']) ? base_url('sarana-prasarana/' . $sarpras['gambar_thumbnail']) : '#' ?>";
                if (currentImageUrl !== '#') {
                    previewImage.src = currentImageUrl;
                    previewContainer.style.display = 'block';
                }
            }
        });
    }

    // JavaScript untuk pratinjau video baru
    document.getElementById('file_video').addEventListener('change', function(event) {
        const [file] = event.target.files;
        const videoPreviewContainer = document.getElementById('videoPreviewContainer');
        const videoPreview = document.getElementById('videoPreview');
        const removeVideoCheckbox = document.getElementById('removeVideoCheckbox');

        if (file) {
            if (file.type.startsWith('video/')) {
                // Hapus elemen video lama jika ada dan buat yang baru
                if (videoPreview) videoPreview.remove(); // Hapus video tag lama

                const newVideoElement = document.createElement('video');
                newVideoElement.id = 'videoPreview';
                newVideoElement.controls = true;
                newVideoElement.className = 'img-fluid'; // Gunakan kelas Bootstrap
                newVideoElement.style.maxHeight = '200px';

                const sourceElement = document.createElement('source');
                sourceElement.src = URL.createObjectURL(file);
                sourceElement.type = file.type;

                newVideoElement.appendChild(sourceElement);
                newVideoElement.innerHTML += 'Maaf, browser Anda tidak mendukung tag video.'; // Fallback text

                // Masukkan video baru ke dalam container (sebelum checkbox jika ada)
                const pTag = videoPreviewContainer.querySelector('p.text-muted'); // Jika ada p 'Tidak ada video'
                if (pTag) pTag.remove();

                if (removeVideoCheckbox) {
                    videoPreviewContainer.insertBefore(newVideoElement, removeVideoCheckbox.parentNode); // Insert before checkbox parent
                } else {
                    videoPreviewContainer.querySelector('.border.rounded.p-2.text-center').appendChild(newVideoElement);
                }

                videoPreviewContainer.style.display = 'block';
                if (removeVideoCheckbox) removeVideoCheckbox.checked = false; // Hapus centang hapus jika ada file baru

            } else {
                // Jika bukan video, sembunyikan pratinjau
                videoPreviewContainer.style.display = 'none';
            }
        } else {
            // Jika tidak ada file baru dipilih, kembali ke video lama atau sembunyikan
            const currentVideoUrl = "<?= !empty($sarpras['file_video']) ? base_url('sarana-prasarana/' . $sarpras['file_video']) : '#' ?>";
            if (currentVideoUrl !== '#') {
                videoPreviewContainer.style.display = 'block';
                // Mengembalikan video lama jika ada
                if (!document.getElementById('videoPreview')) { // Buat ulang jika tag video hilang
                    const existingVideo = document.createElement('video');
                    existingVideo.id = 'videoPreview';
                    existingVideo.controls = true;
                    existingVideo.className = 'img-fluid';
                    existingVideo.style.maxHeight = '200px';
                    const sourceElement = document.createElement('source');
                    sourceElement.src = currentVideoUrl;
                    sourceElement.type = "<?= !empty($sarpras['file_video']) ? (mime_content_type(ROOTPATH . 'public/sarana-prasarana/' . $sarpras['file_video']) ?? 'video/mp4') : 'video/mp4' ?>";
                    existingVideo.appendChild(sourceElement);
                    existingVideo.innerHTML += 'Maaf, browser Anda tidak mendukung tag video.';

                    const pTag = videoPreviewContainer.querySelector('p.text-muted');
                    if (pTag) pTag.remove();

                    const checkboxDiv = videoPreviewContainer.querySelector('.form-check');
                    if (checkboxDiv) {
                        videoPreviewContainer.querySelector('.border.rounded.p-2.text-center').insertBefore(existingVideo, checkboxDiv);
                    } else {
                        videoPreviewContainer.querySelector('.border.rounded.p-2.text-center').appendChild(existingVideo);
                    }
                }
            } else {
                videoPreviewContainer.style.display = 'none';
            }
        }
    });

    // Handle checkbox hapus video
    const removeVideoCheckbox = document.getElementById('removeVideoCheckbox');
    if (removeVideoCheckbox) {
        removeVideoCheckbox.addEventListener('change', function() {
            const videoPreviewContainer = document.getElementById('videoPreviewContainer');
            const videoPreview = document.getElementById('videoPreview');
            if (this.checked) {
                if (videoPreview) videoPreview.remove(); // Hapus elemen video dari DOM
                videoPreviewContainer.style.display = 'none'; // Sembunyikan container
                document.getElementById('file_video').value = ''; // Hapus file dari input
            } else {
                // Tampilkan video lama lagi jika checkbox tidak dicentang dan ada video lama
                const currentVideoUrl = "<?= !empty($sarpras['file_video']) ? base_url('sarana-prasarana/' . $sarpras['file_video']) : '#' ?>";
                if (currentVideoUrl !== '#') {
                    videoPreviewContainer.style.display = 'block';
                    // Jika tag video belum ada, buat lagi
                    if (!document.getElementById('videoPreview')) {
                        const existingVideo = document.createElement('video');
                        existingVideo.id = 'videoPreview';
                        existingVideo.controls = true;
                        existingVideo.className = 'img-fluid';
                        existingVideo.style.maxHeight = '200px';
                        const sourceElement = document.createElement('source');
                        sourceElement.src = currentVideoUrl;
                        sourceElement.type = "<?= !empty($sarpras['file_video']) ? (mime_content_type(ROOTPATH . 'public/sarana-prasarana/' . $sarpras['file_video']) ?? 'video/mp4') : 'video/mp4' ?>";
                        existingVideo.appendChild(sourceElement);
                        existingVideo.innerHTML += 'Maaf, browser Anda tidak mendukung tag video.';
                        videoPreviewContainer.querySelector('.border.rounded.p-2.text-center').insertBefore(existingVideo, this.parentNode);
                    }
                }
            }
        });
    }

    // Helper untuk mime_content_type di JavaScript (fallback jika PHP tidak bisa)
    // Sebaiknya ini dihandle di backend atau pastikan file mime.types di server Anda sudah benar
    // Ini hanya placeholder jika ingin ada fallback di JS
    function getMimeTypeFromFileExtension(filename) {
        const ext = filename.split('.').pop().toLowerCase();
        switch (ext) {
            case 'mp4':
                return 'video/mp4';
            case 'webm':
                return 'video/webm';
            case 'ogg':
                return 'video/ogg';
            case 'jpg':
            case 'jpeg':
                return 'image/jpeg';
            case 'png':
                return 'image/png';
            case 'gif':
                return 'image/gif';
            default:
                return 'application/octet-stream'; // Tipe default jika tidak dikenali
        }
    }
</script>
<?= $this->endSection() ?>