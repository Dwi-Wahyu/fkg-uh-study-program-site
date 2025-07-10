<?= $this->extend('layout/admin') ?>

<?= $this->section('navigation') ?>
<div>

    <a
        name=""
        id=""
        class="btn btn-primary btn-sm me-2"
        href="/profil-lulusan"
        role="button">
        <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="16" height="16" viewBox="0 0 16 16">
            <rect width="16" height="16" fill="none" />
            <path fill="currentColor" fill-rule="evenodd" d="M3 1h11l1 1v5.3a3.2 3.2 0 0 0-1-.3V2H9v10.88L7.88 14H3l-1-1V2zm0 12h5V2H3zm10.379-4.998a2.5 2.5 0 0 0-1.19.348h-.03a2.51 2.51 0 0 0-.799 3.53L9 14.23l.71.71l2.35-2.36c.325.22.7.358 1.09.4a2.5 2.5 0 0 0 1.14-.13a2.5 2.5 0 0 0 1-.63a2.46 2.46 0 0 0 .58-1a2.6 2.6 0 0 0 .07-1.15a2.53 2.53 0 0 0-1.35-1.81a2.5 2.5 0 0 0-1.211-.258m.24 3.992a1.5 1.5 0 0 1-.979-.244a1.55 1.55 0 0 1-.56-.68a1.5 1.5 0 0 1-.08-.86a1.49 1.49 0 0 1 1.18-1.18a1.5 1.5 0 0 1 .86.08c.276.117.512.311.68.56a1.5 1.5 0 0 1-1.1 2.324z" clip-rule="evenodd" />
        </svg>
        Lihat Halaman Profil Lulusan
    </a>
    <a href="<?= base_url('admin/profil-lulusan/create') ?>" class="btn btn-success btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Infografis
    </a>
</div>
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
                            <img src="<?= base_url('profil-lulusan/' . $profil['gambar']) ?>" class="card-img-top img-fluid rounded-top" alt="Gambar Profil Lulusan" style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= esc($profil['judul'] ?? 'Tanpa Judul') ?></h5>
                                <p class="card-text text-justify flex-grow-1">
                                    <?= character_limiter(strip_tags($profil['deskripsi'] ?? 'Tanpa Deskripsi'), 150, '...') ?>
                                </p>
                            </div>
                            <div class="card-footer d-flex justify-content-end gap-2 bg-white border-top-0">

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