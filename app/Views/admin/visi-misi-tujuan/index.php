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
                <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="post" action="/admin/visi-misi-tujuan/update">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="visi_id" class="form-label">Visi (Indonesia)</label>
                <textarea
                    class="form-control <?= (isset($errors['visi_id'])) ? 'is-invalid' : '' ?>"
                    name="visi_id"
                    id="visi_id"
                    rows="5"
                    placeholder="Masukkan konten Visi dalam Bahasa Indonesia"><?= old('visi_id', $dataContent['visi_id'] ?? '') ?></textarea>
                <?php if (isset($errors['visi_id'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['visi_id'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="visi_en" class="form-label">Visi (English)</label>
                <div class="input-group">
                    <textarea
                        class="form-control <?= (isset($errors['visi_en'])) ? 'is-invalid' : '' ?>"
                        name="visi_en"
                        id="visi_en"
                        rows="5"
                        placeholder="Enter Vision content in English"><?= old('visi_en', $dataContent['visi_en'] ?? '') ?></textarea>
                    <button class="btn btn-outline-secondary translate-button" type="button" data-target="visi_en" data-source="visi_id" data-lang="en">Terjemahkan Otomatis</button>
                </div>
                <?php if (isset($errors['visi_en'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['visi_en'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <hr>

            <div class="mb-3">
                <label for="misi_id" class="form-label">Misi (Indonesia)</label>
                <textarea
                    class="form-control <?= (isset($errors['misi_id'])) ? 'is-invalid' : '' ?>"
                    name="misi_id"
                    id="misi_id"
                    rows="5"
                    placeholder="Masukkan konten Misi dalam Bahasa Indonesia"><?= old('misi_id', $dataContent['misi_id'] ?? '') ?></textarea>
                <?php if (isset($errors['misi_id'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['misi_id'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="misi_en" class="form-label">Misi (English)</label>
                <div class="input-group">
                    <textarea
                        class="form-control <?= (isset($errors['misi_en'])) ? 'is-invalid' : '' ?>"
                        name="misi_en"
                        id="misi_en"
                        rows="5"
                        placeholder="Enter Mission content in English"><?= old('misi_en', $dataContent['misi_en'] ?? '') ?></textarea>
                    <button class="btn btn-outline-secondary translate-button" type="button" data-target="misi_en" data-source="misi_id" data-lang="en">Terjemahkan Otomatis</button>
                </div>
                <?php if (isset($errors['misi_en'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['misi_en'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <hr>

            <div class="mb-3">
                <label for="tujuan_id" class="form-label">Tujuan (Indonesia)</label>
                <textarea
                    class="form-control <?= (isset($errors['tujuan_id'])) ? 'is-invalid' : '' ?>"
                    name="tujuan_id"
                    id="tujuan_id"
                    rows="5"
                    placeholder="Masukkan konten Tujuan dalam Bahasa Indonesia"><?= old('tujuan_id', $dataContent['tujuan_id'] ?? '') ?></textarea>
                <?php if (isset($errors['tujuan_id'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['tujuan_id'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="tujuan_en" class="form-label">Tujuan (English)</label>
                <div class="input-group">
                    <textarea
                        class="form-control <?= (isset($errors['tujuan_en'])) ? 'is-invalid' : '' ?>"
                        name="tujuan_en"
                        id="tujuan_en"
                        rows="5"
                        placeholder="Enter Goal content in English"><?= old('tujuan_en', $dataContent['tujuan_en'] ?? '') ?></textarea>
                    <button class="btn btn-outline-secondary translate-button" type="button" data-target="tujuan_en" data-source="tujuan_id" data-lang="en">Terjemahkan Otomatis</button>
                </div>
                <?php if (isset($errors['tujuan_en'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['tujuan_en'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <hr>

            <div class="d-flex justify-content-end gap-2">
                <button
                    type="submit"
                    class="btn btn-primary">
                    Perbarui Konten
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
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

            const sourceText = sourceInput.value;
            const originalButtonText = this.innerHTML;

            if (sourceText.trim() === '') {
                alert('Teks sumber tidak boleh kosong untuk terjemahan.');
                return;
            }

            this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menerjemahkan...';
            this.disabled = true;

            try {
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
                }, 2000);
            }
        });
    });
    // --- Akhir Fungsionalitas Terjemahan Otomatis ---
</script>
<?= $this->endSection() ?>