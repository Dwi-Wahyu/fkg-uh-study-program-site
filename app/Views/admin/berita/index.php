<?= $this->extend('layout/admin') ?>

<?= $this->section('navigation') ?>
<a
    name=""
    id=""
    class="btn btn-primary"
    href="/admin/berita/create"
    role="button">
    <i class="bi bi-plus"></i>
    Tambah Berita
</a>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check2-circle me-2"></i><?= session()->getFlashdata('success') ?>
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

        <div class="table-responsive">
            <table id="beritaDataTable" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Thumbnail</th>
                        <th>Deskripsi Singkat</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($berita)): ?>
                        <?php foreach ($berita as $item): ?>
                            <tr>
                                <td><?= esc($item['judul']) ?></td>
                                <td class="text-center">
                                    <?php if (!empty($item['thumbnail'])): ?>
                                        <img src="<?= base_url('berita/' . $item['thumbnail']) ?>" alt="<?= esc($item['judul']) ?>" style="max-width: 80px; max-height: 80px; object-fit: contain;">
                                    <?php else: ?>
                                        <i class="far fa-image fa-2x text-secondary"></i>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc(character_limiter($item['deskripsi_singkat'] ?? '', 100, '')) ?></td>
                                <td><?= date('d M Y H:i', strtotime($item['created_at'])) ?></td>
                                <td>
                                    <a href="/admin/berita/edit/<?= $item['id'] ?>" class="btn text-white btn-warning btn-sm mb-1" title="Edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteConfirmationModal"
                                        data-id="<?= $item['id'] ?>"
                                        title="Hapus">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data berita ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Penghapusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus berita ini? Tindakan ini tidak dapat dibatalkan.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="#" id="confirmDeleteButton" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<link href="<?= base_url('assets/vendor/datatables/style.css') ?>" rel="stylesheet" type="text/css">
<script src="<?= base_url('assets/vendor/datatables/index.js') ?>"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Simple-DataTables
        const dataTable = new simpleDatatables.DataTable("#beritaDataTable", {
            searchable: true,
            perPageSelect: [10, 25, 50, 100],
            sortable: true,
            classes: {
                selector: "form-select form-select-sm",
                input: "form-control form-control-sm"
            },
            labels: {
                placeholder: "Cari...",
                perPage: " data per halaman",
                noRows: "Tidak ada data ditemukan",
                info: "Menampilkan {start} hingga {end} dari {rows} entri",
                search: "Cari:",
                pager: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                }
            }
        });

        // --- Fungsionalitas Modal Konfirmasi Hapus ---
        const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
        deleteConfirmationModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const beritaId = button.getAttribute('data-id');
            const confirmDeleteButton = deleteConfirmationModal.querySelector('#confirmDeleteButton');
            confirmDeleteButton.href = '/admin/berita/delete/' + beritaId;
        });
    });
</script>
<?= $this->endSection() ?>