<?= $this->extend('layout/admin') ?>

<?= $this->section('navigation') ?>
<a
    name=""
    id=""
    class="btn btn-primary"
    href="/admin/sarana-prasarana/create"
    role="button">
    <i class="bi bi-plus"></i>
    Tambah Sarana/Prasarana
</a>
<?= $this->endSection() ?>


<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
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

        <div class="table-responsive">
            <table id="saranaPrasaranaDataTable" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Thumbnail</th>
                        <th>Video</th>
                        <th>Dibuat Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($sarpras)): ?>
                        <?php foreach ($sarpras as $item): ?>
                            <tr>
                                <td><?= esc($item['nama']) ?></td>
                                <td><?= esc(character_limiter($item['deskripsi'], 100)) ?></td>
                                <td class="text-center">
                                    <?php if (!empty($item['gambar_thumbnail'])): ?>
                                        <img src="<?= base_url('sarana-prasarana/' . $item['gambar_thumbnail']) ?>" alt="<?= esc($item['nama']) ?>" style="max-width: 80px; max-height: 80px; object-fit: contain;">
                                    <?php else: ?>
                                        <i class="far fa-image fa-2x text-secondary"></i>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if (!empty($item['file_video'])): ?>
                                        <a href="<?= base_url('sarana-prasarana/' . $item['file_video']) ?>" target="_blank" class="btn btn-sm btn-outline-primary" title="Lihat Video">
                                            <i class="bi bi-play-circle"></i> Video
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Tidak Ada Video</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d M Y H:i', strtotime($item['created_at'])) ?></td>
                                <td>
                                    <a href="/admin/sarana-prasarana/edit/<?= $item['id'] ?>" class="btn btn-warning text-white btn-sm" title="Edit">
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
                            <td colspan="6" class="text-center">Tidak ada data sarana dan prasarana ditemukan.</td>
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
                Apakah Anda yakin ingin menghapus item sarana/prasarana ini? Tindakan ini tidak dapat dibatalkan.
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
        const dataTable = new simpleDatatables.DataTable("#saranaPrasaranaDataTable", {
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

        // --- Fungsionalitas Modal Konfirmasi Hapus (untuk sarana-prasarana) ---
        const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
        deleteConfirmationModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Tombol yang memicu modal
            const sarprasId = button.getAttribute('data-id'); // Ambil ID sarpras
            const confirmDeleteButton = deleteConfirmationModal.querySelector('#confirmDeleteButton');

            // Atur href tombol 'Hapus' di modal agar mengarah ke rute delete sarana-prasarana
            confirmDeleteButton.href = '/admin/sarana-prasarana/delete/' + sarprasId;
        });
        // --- Akhir Fungsionalitas Modal Konfirmasi Hapus ---
    });
</script>
<?= $this->endSection() ?>