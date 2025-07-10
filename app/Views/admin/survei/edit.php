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

        <form action="<?= base_url('admin/survei/update/' . $survei['id']) ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="judul" class="form-label">Judul Survei <span class="text-danger">*</span></label>
                <input
                    type="text"
                    class="form-control <?= (isset($errors['judul'])) ? 'is-invalid' : '' ?>"
                    name="judul"
                    id="judul"
                    value="<?= old('judul', $survei['judul'] ?? '') ?>"
                    placeholder="Masukkan judul survei"
                    required />
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
                    placeholder="Masukkan deskripsi survei"><?= old('deskripsi', $survei['deskripsi'] ?? '') ?></textarea>
                <?php if (isset($errors['deskripsi'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['deskripsi'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="link" class="form-label">Link Survei <span class="text-danger">*</span></label>
                <input
                    type="url"
                    class="form-control <?= (isset($errors['link'])) ? 'is-invalid' : '' ?>"
                    name="link"
                    id="link"
                    value="<?= old('link', $survei['link'] ?? '') ?>"
                    placeholder="Masukkan URL survei (misal: https://forms.gle/abcdef)"
                    required />
                <?php if (isset($errors['link'])): ?>
                    <div class="invalid-feedback">
                        <?= $errors['link'] ?>
                    </div>
                <?php endif; ?>
            </div>


            <div class="d-flex justify-content-end gap-2">
                <a
                    class="btn btn-secondary"
                    href="<?= base_url('admin/survei') ?>"
                    role="button">
                    Kembali
                </a>
                <button
                    type="submit"
                    class="btn btn-primary">
                    Perbarui
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>