<?= $this->extend('layout/main') ?>

<?= $this->section('style') ?>
<style>
    .sarpras-card {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
        height: 300px;
        /* Tinggi tetap untuk ukuran card yang seragam */
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        /* Memposisikan konten di bagian bawah */
    }

    .sarpras-card:hover {
        transform: translateY(-5px);
    }

    .sarpras-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Memastikan gambar menutupi seluruh area */
        display: block;
        position: absolute;
        /* Memposisikan gambar di belakang overlay */
        top: 0;
        left: 0;
        z-index: 1;
    }

    .sarpras-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        /* Gradient dari hitam ke transparan */
        color: white;
        padding: 15px;
        opacity: 0;
        /* Sembunyikan secara default */
        transition: opacity 0.3s ease-in-out;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        height: 100%;
        /* Memastikan overlay menutupi seluruh area card */
        z-index: 2;
        /* Memastikan overlay berada di atas gambar */
    }

    .sarpras-card:hover .sarpras-overlay {
        opacity: 1;
        /* Munculkan saat hover */
    }

    .sarpras-overlay h5 {
        font-size: 1.25rem;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .sarpras-overlay p {
        font-size: 0.9rem;
        line-height: 1.4;
        margin-bottom: 10px;
        /* Spasi di atas tombol/tautan video */
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        -webkit-line-clamp: 3;
        /* Batasi deskripsi hingga 3 baris */
    }

    .sarpras-overlay .btn-link {
        color: white;
        text-decoration: underline;
        padding: 0;
        align-self: flex-start;
        /* Sejajarkan tautan ke kiri */
    }

    .sarpras-overlay .btn-link:hover {
        color: #ddd;
    }

    .no-sarpras-data {
        padding: 20px;
        text-align: center;
        color: #6c757d;
    }

    .section-title {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 40px;
        text-align: center;
        /* Posisikan judul di tengah */
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="main-news-card p-4">
                <h4 class="section-title text-center">Resident Activity</h4>

                <?php if (!empty($activities)): ?>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        <?php foreach ($activities as $item): ?>
                            <div class="col">
                                <div class="sarpras-card">
                                    <?php if (!empty($item['gambar'])): ?>
                                        <img src="<?= base_url('resident-activity/' . $item['gambar']) ?>" alt="<?= esc($item['judul']) ?>">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/400x300?text=No+Thumbnail" alt="No Thumbnail">
                                    <?php endif; ?>
                                    <div class="sarpras-overlay">
                                        <h5><?= esc($item['judul']) ?></h5>
                                        <p><?= esc(character_limiter($item['deskripsi'] ?? 'Tidak ada deskripsi tersedia.', 120)) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-sarpras-data">
                        <p>Belum ada data resident activity yang tersedia.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>