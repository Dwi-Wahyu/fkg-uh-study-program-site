<?= $this->extend('layout/main') ?>

<?= $this->section('style') ?>
<style>
    .kurikulum-card {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        height: 300px;
        cursor: pointer;
    }

    .kurikulum-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .kurikulum-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease-in-out;
    }

    .kurikulum-card:hover img {
        transform: scale(1.05);
    }

    .kurikulum-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        color: white;
        padding: 15px;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        height: 100%;
    }

    .kurikulum-card:hover .kurikulum-overlay {
        opacity: 1;
    }

    .kurikulum-overlay h5 {
        font-size: 1.25rem;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .kurikulum-overlay p {
        font-size: 0.9rem;
        line-height: 1.4;
        margin-bottom: 0;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        -webkit-line-clamp: 3;
    }

    .no-kurikulum-data {
        padding: 20px;
        text-align: center;
        color: #6c757d;
    }

    .section-title {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 40px;
    }

    .modal-fullscreen .modal-dialog {
        width: 100vw;
        height: 100vh;
        margin: 0;
        max-width: none;
    }

    .modal-fullscreen .modal-content {
        height: 100%;
        border-radius: 0;
        background-color: rgba(0, 0, 0, 0.9);
        /* Latar belakang gelap untuk gambar */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-fullscreen .modal-body {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .modal-fullscreen .modal-body img {
        max-width: 95%;
        max-height: 95%;
        object-fit: contain;
    }

    .modal-fullscreen .btn-close-modal-custom {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 1050;
        background: none;
        border: none;
        font-size: 2rem;
        color: white;
        opacity: 0.7;
        transition: opacity 0.3s ease;
    }

    .modal-fullscreen .btn-close-modal-custom:hover {
        opacity: 1;
        color: white;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mb-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="main-news-card p-4">
                <h4 class="section-title text-center"><?= esc($title) ?></h4>

                <?php if (!empty($kurikulum)): ?>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        <?php foreach ($kurikulum as $item): ?>
                            <div class="col">
                                <div class="kurikulum-card" data-bs-toggle="modal" data-bs-target="#imageModal" data-image-src="<?= base_url('kurikulum/' . $item['gambar']) ?>" data-image-alt="<?= esc($item['keterangan'] ?? 'Gambar Kurikulum') ?>">
                                    <?php if (!empty($item['gambar'])): ?>
                                        <img src="<?= base_url('kurikulum/' . $item['gambar']) ?>" alt="<?= esc($item['keterangan'] ?? 'Gambar Kurikulum') ?>">
                                    <?php else: ?>
                                        <img src="https://placehold.co/400x300/E0E0E0/6C6C6C?text=No+Image" alt="No Image">
                                    <?php endif; ?>
                                    <div class="kurikulum-overlay">
                                        <h5><?= esc($item['keterangan'] ?? 'Tanpa Keterangan') ?></h5>
                                        <p><?= esc(character_limiter($item['keterangan'] ?? 'Tidak ada keterangan singkat tersedia.', 100)) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-kurikulum-data">
                        <p>Belum ada data kurikulum yang tersedia.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Fullscreen untuk Gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <button type="button" class="btn-close-modal-custom" data-bs-dismiss="modal" aria-label="Close">
                &times;
            </button>
            <div class="modal-body">
                <img src="" class="img-fluid" id="fullImage" alt="Full Image">
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsionalitas untuk menampilkan gambar fullscreen di modal
        const imageModal = document.getElementById('imageModal');
        imageModal.addEventListener('show.bs.modal', function(event) {
            // Tombol yang memicu modal
            const button = event.relatedTarget;
            // Ambil src gambar dari atribut data-image-src
            const imageSrc = button.getAttribute('data-image-src');
            // Ambil alt text dari atribut data-image-alt
            const imageAlt = button.getAttribute('data-image-alt');

            // Set src dan alt pada gambar di dalam modal
            const fullImage = imageModal.querySelector('#fullImage');
            fullImage.src = imageSrc;
            fullImage.alt = imageAlt;
        });
    });
</script>
<?= $this->endSection() ?>