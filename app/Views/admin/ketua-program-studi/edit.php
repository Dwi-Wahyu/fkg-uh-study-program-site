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

        <form method="post" action="/admin/ketua-program-studi/update" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Ketua Program Studi</label>
                <input
                    type="text"
                    class="form-control <?= (isset($errors['nama'])) ? 'is-invalid' : '' ?>"
                    name="nama"
                    id="nama"
                    placeholder="Masukkan nama Ketua Program Studi"
                    value="<?= old('nama', $ketuaProdi['nama'] ?? '') ?>" />
                <?php if (isset($errors['nama'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['nama'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="sambutan" class="form-label">Sambutan (Indonesia)</label>
                <textarea
                    class="form-control <?= (isset($errors['sambutan'])) ? 'is-invalid' : '' ?>"
                    name="sambutan"
                    id="sambutan"
                    rows="5"
                    placeholder="Masukkan teks sambutan"><?= old('sambutan', $ketuaProdi['sambutan'] ?? '') ?></textarea>
                <?php if (isset($errors['sambutan'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['sambutan'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="sambutan_en" class="form-label">Sambutan (English)</label>
                <div class="input-group">
                    <textarea
                        class="form-control <?= (isset($errors['sambutan_en'])) ? 'is-invalid' : '' ?>"
                        name="sambutan_en"
                        id="sambutan_en"
                        rows="5"
                        placeholder="Enter greeting text (English)"><?= old('sambutan_en', $ketuaProdi['sambutan_en'] ?? '') ?></textarea>
                    <button class="btn btn-outline-secondary translate-button" type="button" data-target="sambutan_en" data-source="sambutan" data-lang="en">Terjemahkan Otomatis</button>
                </div>
                <?php if (isset($errors['sambutan_en'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['sambutan_en'] ?>
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
                <div id="gambarHelpId" class="form-text text-muted">Pilih gambar Ketua Program Studi (JPG, JPEG, PNG, GIF, WEBP).</div>
                <?php if (isset($errors['gambar'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['gambar'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3" id="imagePreviewContainer" style="display: <?= !empty($ketuaProdi['gambar']) ? 'block' : 'none' ?>;">
                <label class="form-label">Pratinjau Gambar Saat Ini</label>
                <div class="border rounded p-2 text-center">
                    <img id="imagePreview"
                        src="<?= !empty($ketuaProdi['gambar']) ? base_url('ketua-prodi/' . $ketuaProdi['gambar']) : '#' ?>"
                        alt="Pratinjau Gambar"
                        class="img-fluid"
                        style="max-height: 200px; object-fit: contain;">
                </div>

            </div>


            <div class="d-flex justify-content-end gap-2">
                <button
                    type="submit"
                    class="btn btn-primary">
                    Perbarui Data
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
                const removeCheckbox = document.getElementById('removeGambarCheckbox');
                if (removeCheckbox) removeCheckbox.checked = false;
            } else {
                previewContainer.style.display = 'none';
                previewImage.src = '#';
            }
        } else {
            const currentImageUrl = "<?= !empty($ketuaProdi['gambar']) ? base_url('ketua-prodi/' . $ketuaProdi['gambar']) : '#' ?>";
            if (currentImageUrl !== '#') {
                previewImage.src = currentImageUrl;
                previewContainer.style.display = 'block';
            } else {
                previewContainer.style.display = 'none';
                previewImage.src = '#';
            }
        }
    });

    const removeGambarCheckbox = document.getElementById('removeGambarCheckbox');
    if (removeGambarCheckbox) {
        removeGambarCheckbox.addEventListener('change', function() {
            const previewContainer = document.getElementById('imagePreviewContainer');
            const previewImage = document.getElementById('imagePreview');
            if (this.checked) {
                previewImage.src = '#';
                previewContainer.style.display = 'none';
                document.getElementById('gambar').value = '';
            } else {
                const currentImageUrl = "<?= !empty($ketuaProdi['gambar']) ? base_url('ketua-prodi/' . $ketuaProdi['gambar']) : '#' ?>";
                if (currentImageUrl !== '#') {
                    previewImage.src = currentImageUrl;
                    previewContainer.style.display = 'block';
                }
            }
        });
    }

    // --- Fungsionalitas Terjemahan Otomatis (Hanya untuk Sambutan) ---
    document.querySelectorAll('.translate-button').forEach(button => {
        button.addEventListener('click', async function() {
            const sourceFieldId = this.dataset.source; // ID input/textarea sumber (misal 'sambutan')
            const targetFieldId = this.dataset.target; // ID input/textarea target (misal 'sambutan_en')
            const targetLang = this.dataset.lang; // Bahasa target (misal 'en')

            const sourceInput = document.getElementById(sourceFieldId);
            const targetInput = document.getElementById(targetFieldId);

            if (!sourceInput || !targetInput) {
                console.error(`Elemen dengan ID ${sourceFieldId} atau ${targetFieldId} tidak ditemukan.`);
                return;
            }

            const sourceText = sourceInput.value;
            const originalButtonText = this.innerHTML;

            if (sourceText.trim() === '') {
                alert('Teks sumber tidak boleh kosong untuk terjemahan.');
                return;
            }

            this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menerjemahkan...';
            this.disabled = true;

            try {
                // Panggil endpoint API terjemahan Anda di CodeIgniter
                const response = await fetch('/api/translate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="csrf_test_name"]').value
                    },
                    body: JSON.stringify({
                        text: sourceText,
                        target_lang: targetLang
                    })
                });

                const data = await response.json();

                if (response.ok && data.translated_text) {
                    targetInput.value = data.translated_text;
                    this.innerHTML = '<i class="bi bi-check-lg"></i> Berhasil!';
                    this.classList.add('btn-success');
                } else {
                    console.error('Error terjemahan:', data.error || 'Terjadi kesalahan tidak diketahui.');
                    alert('Gagal menerjemahkan: ' + (data.error || 'Silakan coba lagi.'));
                    this.innerHTML = '<i class="bi bi-x-lg"></i> Gagal!';
                    this.classList.add('btn-danger');
                }
            } catch (error) {
                console.error('Error saat memanggil API terjemahan:', error);
                alert('Terjadi kesalahan saat menghubungi server terjemahan.');
                this.innerHTML = '<i class="bi bi-x-lg"></i> Gagal!';
                this.classList.add('btn-danger');
            } finally {
                setTimeout(() => {
                    this.innerHTML = originalButtonText;
                    this.classList.remove('btn-success', 'btn-danger');
                    this.disabled = false;
                }, 2000); // Reset tombol setelah 2 detik
            }
        });
    });
    // --- Akhir Fungsionalitas Terjemahan Otomatis ---
</script>
<?= $this->endSection() ?>