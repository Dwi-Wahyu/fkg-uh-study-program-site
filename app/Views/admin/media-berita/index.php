<?= $this->extend('layout/admin') ?>

<?= $this->section('navigation') ?>
<a
    name=""
    id=""
    class="btn btn-primary"
    href="/admin/media-berita/create"
    role="button">
    <i class="bi bi-plus"></i>
    Tambah Media
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
            <table id="mediaDataTable" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Preview</th>
                        <th>Nama File</th>
                        <th>Tipe File</th>
                        <th>Ukuran (KB)</th>
                        <th>Tanggal Unggah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($media)): ?>
                        <?php foreach ($media as $item): ?>
                            <tr>
                                <td class="text-center">
                                    <?php
                                    $fileExtension = pathinfo($item['file_name'], PATHINFO_EXTENSION);
                                    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                                    ?>
                                    <?php if (in_array(strtolower($fileExtension), $imageExtensions)): ?>
                                        <img src="<?= base_url('media/' . $item['file_name']) ?>" alt="<?= esc($item['alt_text']) ?>" style="max-width: 80px; max-height: 80px; object-fit: contain;">
                                    <?php else: ?>
                                        <?php if (strtolower($fileExtension) == 'pdf'): ?>
                                            <i class="far fa-file-pdf fa-2x text-danger"></i>
                                        <?php elseif (in_array(strtolower($fileExtension), ['doc', 'docx'])): ?>
                                            <i class="far fa-file-word fa-2x text-primary"></i>
                                        <?php else: ?>
                                            <i class="far fa-file fa-2x text-secondary"></i>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($item['file_name']) ?></td>
                                <td><?= esc($item['file_type']) ?></td>
                                <td><?= round($item['file_size'] / 1024, 2) ?></td>
                                <td><?= date('d M Y H:i', strtotime($item['created_at'])) ?></td>
                                <td>
                                    <?php $fileUrl = base_url('media/' . $item['file_name']); ?>
                                    <button
                                        type="button"
                                        class="btn btn-info btn-sm copy-path-btn"
                                        data-image-url="<?= $fileUrl ?>"
                                        title="Salin Path File">
                                        <i class="text-white bi bi-clipboard2"></i>
                                    </button>

                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteConfirmationModal"
                                        data-id="<?= $item['id'] ?>"
                                        title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data media ditemukan.</td>
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
                Apakah Anda yakin ingin menghapus item media ini? Tindakan ini tidak dapat dibatalkan.
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
        const dataTable = new simpleDatatables.DataTable("#mediaDataTable", {
            searchable: true,
            perPageSelect: [10, 25, 50, 100],
            sortable: true,
            classes: {
                selector: "form-select form-select-sm", // Untuk .datatable-selector (dropdown "Show X entries")
                input: "form-control form-control-sm" // Untuk .datatable-input (kolom pencarian)
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

        // --- Fungsionalitas Copy Path Gambar ---
        document.querySelectorAll('.copy-path-btn').forEach(button => {
            button.addEventListener('click', function() {
                const fileUrl = this.dataset.imageUrl; // Ambil URL dari data attribute

                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(fileUrl)
                        .then(() => {
                            const originalHtml = this.innerHTML;
                            const originalClass = this.className;
                            this.innerHTML = '<i class="bi bi-clipboard2-check"></i>';
                            this.className = 'btn btn-success btn-sm mb-1';
                            setTimeout(() => {
                                this.innerHTML = originalHtml;
                                this.className = originalClass;
                            }, 2000);
                        })
                        .catch(err => {
                            console.error('Gagal menyalin:', err);
                            alert('Gagal menyalin path. Silakan coba lagi atau salin manual: ' + fileUrl);
                        });
                } else {
                    const textArea = document.createElement("textarea");
                    textArea.value = fileUrl;
                    textArea.style.position = "fixed";
                    textArea.style.left = "-999999px";
                    textArea.style.top = "-999999px";
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    try {
                        const successful = document.execCommand('copy');
                        if (successful) {
                            const originalHtml = this.innerHTML;
                            const originalClass = this.className;
                            this.innerHTML = '<i class="bi bi-clipboard2-check"></i>';
                            this.className = 'btn btn-success btn-sm mb-1';
                            setTimeout(() => {
                                this.innerHTML = originalHtml;
                                this.className = originalClass;
                            }, 2000);
                        } else {
                            alert('Gagal menyalin path. Browser Anda tidak mendukung penyalinan otomatis. Silakan salin manual: ' + fileUrl);
                        }
                    } catch (err) {
                        console.error('Fallback: Gagal menyalin teks', err);
                        alert('Gagal menyalin path. Browser Anda tidak mendukung penyalinan otomatis. Silakan salin manual: ' + fileUrl);
                    }
                    document.body.removeChild(textArea);
                }
            });
        });


        const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
        deleteConfirmationModal.addEventListener('show.bs.modal', function(event) {
            // Tombol yang memicu modal
            const button = event.relatedTarget;
            // Ambil ID dari atribut data-id
            const mediaId = button.getAttribute('data-id');
            // Dapatkan tombol 'Hapus' di dalam modal
            const confirmDeleteButton = deleteConfirmationModal.querySelector('#confirmDeleteButton');

            // Atur href tombol 'Hapus' di modal
            confirmDeleteButton.href = '/admin/media-berita/delete/' + mediaId;
        });
    });
</script>
<?= $this->endSection() ?>