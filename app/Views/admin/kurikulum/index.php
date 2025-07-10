<?= $this->extend('layout/admin') ?>

<?= $this->section('navigation') ?>
<div>

    <a
        name=""
        id=""
        class="btn btn-primary btn-sm me-2"
        href="/curriculum"
        role="button">
        <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="16" height="16" viewBox="0 0 16 16">
            <rect width="16" height="16" fill="none" />
            <path fill="currentColor" fill-rule="evenodd" d="M3 1h11l1 1v5.3a3.2 3.2 0 0 0-1-.3V2H9v10.88L7.88 14H3l-1-1V2zm0 12h5V2H3zm10.379-4.998a2.5 2.5 0 0 0-1.19.348h-.03a2.51 2.51 0 0 0-.799 3.53L9 14.23l.71.71l2.35-2.36c.325.22.7.358 1.09.4a2.5 2.5 0 0 0 1.14-.13a2.5 2.5 0 0 0 1-.63a2.46 2.46 0 0 0 .58-1a2.6 2.6 0 0 0 .07-1.15a2.53 2.53 0 0 0-1.35-1.81a2.5 2.5 0 0 0-1.211-.258m.24 3.992a1.5 1.5 0 0 1-.979-.244a1.55 1.55 0 0 1-.56-.68a1.5 1.5 0 0 1-.08-.86a1.49 1.49 0 0 1 1.18-1.18a1.5 1.5 0 0 1 .86.08c.276.117.512.311.68.56a1.5 1.5 0 0 1-1.1 2.324z" clip-rule="evenodd" />
        </svg>
        Lihat Halaman Kurikulum
    </a>

    <a href="<?= base_url('/admin/kurikulum/create') ?>" class="btn btn-success btn-sm">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
        </svg>
        Tambah Kurikulum
    </a>
</div>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
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
                    <table class="table table-striped" id="kurikulumDataTable"> <!-- Ubah ID tabel -->
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Keterangan (ID)</th>
                                <th>Keterangan (EN)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($kurikulum)) : ?>
                                <?php $no = 1; ?>
                                <?php foreach ($kurikulum as $item) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <?php if (!empty($item['gambar'])) : ?>
                                                <img src="<?= base_url('kurikulum/' . $item['gambar']) ?>" alt="Gambar Kurikulum" width="100">
                                            <?php else : ?>
                                                <img src="https://placehold.co/100x75/E0E0E0/6C6C6C?text=No+Image" alt="No Image" width="100">
                                            <?php endif; ?>
                                        </td>
                                        <td><?= esc(character_limiter($item['keterangan'] ?? '', 100)) ?></td>
                                        <td><?= esc(character_limiter($item['keterangan_en'] ?? '', 100)) ?></td>
                                        <td>
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
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data kurikulum.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
                Apakah Anda yakin ingin menghapus item kurikulum ini? Tindakan ini tidak dapat dibatalkan.
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
<!-- Pastikan Anda memuat Simple-DataTables jika menggunakannya -->
<link href="<?= base_url('assets/vendor/datatables/style.css') ?>" rel="stylesheet" type="text/css">
<script src="<?= base_url('assets/vendor/datatables/index.js') ?>"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Simple-DataTables
        const dataTable = new simpleDatatables.DataTable("#kurikulumDataTable", { // Ubah ID tabel
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

        // --- Fungsionalitas Modal Konfirmasi Hapus (untuk kurikulum) ---
        const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
        deleteConfirmationModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Tombol yang memicu modal
            const kurikulumId = button.getAttribute('data-id'); // Ambil ID kurikulum
            const confirmDeleteButton = deleteConfirmationModal.querySelector('#confirmDeleteButton');

            // Atur href tombol 'Hapus' di modal agar mengarah ke rute delete kurikulum
            confirmDeleteButton.href = '<?= base_url('admin/kurikulum/delete/') ?>' + kurikulumId;
        });
        // --- Akhir Fungsionalitas Modal Konfirmasi Hapus ---
    });
</script>
<?= $this->endSection() ?>