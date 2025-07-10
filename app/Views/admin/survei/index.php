<?= $this->extend('layout/admin') ?>

<?= $this->section('navigation') ?>
<div>
    <a
        name=""
        id=""
        class="btn btn-primary btn-sm me-2"
        href="/survei"
        role="button">
        <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="16" height="16" viewBox="0 0 16 16">
            <rect width="16" height="16" fill="none" />
            <path fill="currentColor" fill-rule="evenodd" d="M3 1h11l1 1v5.3a3.2 3.2 0 0 0-1-.3V2H9v10.88L7.88 14H3l-1-1V2zm0 12h5V2H3zm10.379-4.998a2.5 2.5 0 0 0-1.19.348h-.03a2.51 2.51 0 0 0-.799 3.53L9 14.23l.71.71l2.35-2.36c.325.22.7.358 1.09.4a2.5 2.5 0 0 0 1.14-.13a2.5 2.5 0 0 0 1-.63a2.46 2.46 0 0 0 .58-1a2.6 2.6 0 0 0 .07-1.15a2.53 2.53 0 0 0-1.35-1.81a2.5 2.5 0 0 0-1.211-.258m.24 3.992a1.5 1.5 0 0 1-.979-.244a1.55 1.55 0 0 1-.56-.68a1.5 1.5 0 0 1-.08-.86a1.49 1.49 0 0 1 1.18-1.18a1.5 1.5 0 0 1 .86.08c.276.117.512.311.68.56a1.5 1.5 0 0 1-1.1 2.324z" clip-rule="evenodd" />
        </svg>
        Lihat Halaman Survei
    </a>

    <a
        href="/admin/survei/create"
        class="btn btn-success btn-sm">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
        </svg>
        Input Survei
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

        <?php if (empty($surveis)): ?>
            <div class="alert alert-info text-center" role="alert">
                Belum ada data Survei. Silakan tambahkan yang baru.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Link</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($surveis as $survei): ?>
                            <tr>
                                <th scope="row"><?= $no++ ?></th>
                                <td><?= esc($survei['judul']) ?></td>
                                <td><?= character_limiter(esc($survei['deskripsi'] ?? 'Tidak ada deskripsi'), 100, '...') ?></td>
                                <td><a href="<?= esc($survei['link']) ?>" target="_blank" class="text-decoration-none"><i class="bi bi-box-arrow-up-right me-1"></i>Kunjungi Link</a></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="<?= base_url('admin/survei/edit/' . $survei['id']) ?>" class="btn btn-warning text-white btn-sm" title="Edit">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <!-- Tombol Hapus yang memicu modal -->
                                        <button
                                            type="button"
                                            class="btn btn-danger btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteConfirmationModal"
                                            data-id="<?= $survei['id'] ?>"
                                            title="Hapus">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Konfirmasi Penghapusan -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Penghapusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus survei ini? Tindakan ini tidak dapat dibatalkan.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="#" id="confirmDeleteButton" class="btn btn-danger">Hapus</a> <!-- Ini harusnya tag <a> -->
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
        deleteConfirmationModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Tombol yang memicu modal (yaitu tombol "Hapus" di tabel)
            const surveiId = button.getAttribute('data-id'); // Mengambil ID dari atribut data-id
            const confirmDeleteButton = deleteConfirmationModal.querySelector('#confirmDeleteButton');

            // Mengatur href tombol 'Hapus' di modal secara dinamis
            confirmDeleteButton.href = '<?= base_url('admin/survei/delete/') ?>' + surveiId;
        });
    });
</script>
<?= $this->endSection() ?>