<?= $this->extend('layout/admin') ?>

<?= $this->section('navigation') ?>
<a href="<?= base_url('admin/profil-lulusan/create') ?>" class="btn btn-primary btn-sm">
    <i class="bi bi-plus-lg me-1"></i> Tambah Profil Lulusan
</a>
<?= $this->endSection() ?>


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

        <?php if (empty($profilLulusan)): ?>
            <div class="alert alert-info text-center" role="alert">
                Belum ada data Profil Lulusan. Silakan tambahkan yang baru.
            </div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach ($profilLulusan as $profil): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="<?= base_url('uploads/profil_lulusan/' . $profil['gambar']) ?>" class="card-img-top img-fluid rounded-top" alt="Gambar Profil Lulusan" style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= esc($profil['judul'] ?? 'Tanpa Judul') ?></h5>
                                <p class="card-text text-justify flex-grow-1">
                                    <?= character_limiter(strip_tags($profil['deskripsi'] ?? 'Tanpa Deskripsi'), 150, '...') ?>
                                </p>
                            </div>
                            <div class="card-footer d-flex justify-content-end gap-2 bg-white border-top-0">
                                <a href="<?= base_url('admin/profil-lulusan/edit/' . $profil['id']) ?>" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <a href="<?= base_url('admin/profil-lulusan/delete/' . $profil['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus profil lulusan ini?')" title="Hapus">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>