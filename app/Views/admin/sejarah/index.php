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

        <form method="post" action="/admin/sejarah/update">
            <?= csrf_field() ?>

            <!-- Bagian Konten Sejarah (Indonesia) -->
            <div class="mb-3">
                <label for="content" class="form-label">Konten Sejarah (Indonesia)</label>
                <textarea
                    class="form-control editor <?= (isset($errors['content'])) ? 'is-invalid' : '' ?>"
                    name="content"
                    id="content"
                    rows="10"
                    placeholder="Masukkan konten sejarah dalam Bahasa Indonesia"><?= old('content', $dataContent['content'] ?? '') ?></textarea>
                <?php if (isset($errors['content'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['content'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Bagian Konten Sejarah (English) -->
            <div class="mb-3">
                <label for="content_en" class="form-label">Konten Sejarah (English)</label>
                <textarea
                    class="form-control editor <?= (isset($errors['content_en'])) ? 'is-invalid' : '' ?>"
                    name="content_en"
                    id="content_en"
                    rows="10"
                    placeholder="Enter history content in English"><?= old('content_en', $dataContent['content_en'] ?? '') ?></textarea>
                <?php if (isset($errors['content_en'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['content_en'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <hr>

            <div class="d-flex justify-content-end gap-2">
                <button
                    type="submit"
                    class="btn btn-primary">
                    Perbarui Konten Sejarah
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

    // --- Fungsionalitas Terjemahan Otomatis ---
    document.querySelectorAll('.translate-button').forEach(button => {
        button.addEventListener('click', async function() {
            const sourceFieldId = this.dataset.source;
            const targetFieldId = this.dataset.target;
            const targetLang = this.dataset.lang;

            const sourceInput = document.getElementById(sourceFieldId);
            const targetInput = document.getElementById(targetFieldId);

            if (!sourceInput || !targetInput) {
                console.error(`Elemen dengan ID ${sourceFieldId} atau ${targetFieldId} tidak ditemukan.`);
                return;
            }

            // Jika TinyMCE sudah aktif pada sourceInput, ambil konten dari editor TinyMCE
            let sourceText;
            if (tinymce.get(sourceFieldId)) {
                sourceText = tinymce.get(sourceFieldId).getContent({
                    format: 'text'
                }); // Ambil teks dari TinyMCE
            } else {
                sourceText = sourceInput.value;
            }

            const originalButtonText = this.innerHTML;

            if (sourceText.trim() === '') {
                alert('Teks sumber tidak boleh kosong untuk terjemahan.');
                return;
            }

            this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menerjemahkan...';
            this.disabled = true;

            try {
                // Panggil endpoint API terjemahan Anda di CodeIgniter
                const response = await fetch('<?= base_url('api/translate') ?>', { // Gunakan base_url
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
                    // Jika TinyMCE sudah aktif pada targetInput, set konten ke editor TinyMCE
                    if (tinymce.get(targetFieldId)) {
                        tinymce.get(targetFieldId).setContent(data.translated_text);
                    } else {
                        targetInput.value = data.translated_text;
                    }
                    this.innerHTML = '<i class="bi bi-check-lg"></i> Berhasil!';
                    this.classList.add('btn-success');
                } else {
                    console.error('Error terjemahan:', data.error || 'Terjadi kesalahan tidak diketahui.');
                    // Mengganti alert dengan modal kustom atau pesan di UI
                    const errorMessage = 'Gagal menerjemahkan: ' + (data.error || 'Silakan coba lagi.');
                    // Contoh sederhana: tampilkan di console, Anda bisa membuat modal sendiri
                    console.error(errorMessage);
                    this.innerHTML = '<i class="bi bi-x-lg"></i> Gagal!';
                    this.classList.add('btn-danger');
                }
            } catch (error) {
                console.error('Error saat memanggil API terjemahan:', error);
                // Mengganti alert dengan modal kustom atau pesan di UI
                const errorMessage = 'Terjadi kesalahan saat menghubungi server terjemahan.';
                console.error(errorMessage);
                this.innerHTML = '<i class="bi bi-x-lg"></i> Gagal!';
                this.classList.add('btn-danger');
            } finally {
                setTimeout(() => {
                    this.innerHTML = originalButtonText;
                    this.classList.remove('btn-success', 'btn-danger');
                    this.disabled = false;
                }, 2000);
            }
        });
    });
    // --- Akhir Fungsionalitas Terjemahan Otomatis ---
</script>
<?= $this->endSection() ?>