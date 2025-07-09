<section class="container my-5 py-5 px-md-5">
    <h2 class="section-title text-center">Berita Terbaru</h2>
    <div class="row">
        <?php if (!empty($beritaTerbaru) && count($beritaTerbaru) > 0): ?>
            <div class="col-12 mb-4 news-main-card">
                <?php $mainNews = $beritaTerbaru[0]; ?>
                <div class="card news-card h-100">
                    <div class="news-card-img-container">
                        <?php if (!empty($mainNews['thumbnail'])): ?>
                            <img src="<?= base_url('berita/' . $mainNews['thumbnail']) ?>" class="news-card-img" alt="<?= esc($mainNews['judul']) ?>">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/600x300?text=No+Image" class="news-card-img" alt="No Image">
                        <?php endif; ?>
                    </div>
                    <div class="news-card-body p-4">
                        <h5 class="card-title"><?= esc($mainNews['judul']) ?></h5>
                        <p class="card-text"><?= esc(character_limiter($mainNews['deskripsi_singkat'] ?? $mainNews['detail'] ?? '', 150)) ?></p>
                        <a href="/berita/<?= $mainNews['id'] ?>" class="btn btn-sm btn-outline-primary mt-2">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row news-secondary-cards">
                    <?php for ($i = 1; $i < min(4, count($beritaTerbaru)); $i++): ?>
                        <?php $news = $beritaTerbaru[$i]; ?>
                        <div class="col-md-4 col-12 mb-3">
                            <div class="card news-card h-100">
                                <div class="news-card-img-container">
                                    <?php if (!empty($news['thumbnail'])): ?>
                                        <img src="<?= base_url('berita/' . $news['thumbnail']) ?>" class="news-card-img" alt="<?= esc($news['judul']) ?>">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/400x200?text=No+Image" class="news-card-img" alt="No Image">
                                    <?php endif; ?>
                                </div>
                                <div class="news-card-body p-4">
                                    <h5 class="card-title"><?= esc($news['judul']) ?></h5>
                                    <p class="card-text"><?= esc(character_limiter($news['deskripsi_singkat'] ?? $news['detail'] ?? '', 80)) ?></p>
                                    <a href="/berita/<?= $news['id'] ?>" class="btn btn-sm btn-link p-0 text-decoration-none">Baca Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>

                <div style="display: flex; justify-content: center; margin-top: 20px;">

                    <a
                        name=""
                        id=""
                        class="btn btn-primary"
                        href="/berita"
                        role="button">Selengkapnya
                    </a>
                </div>
            </div>


        <?php else: ?>
            <div class="col-12">
                <p class="text-center text-muted">Belum ada berita terbaru yang tersedia.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
    /* Tambahan CSS untuk menyesuaikan tampilan card kecil agar tidak berbentuk row lagi */
    .news-secondary-cards .news-card {
        flex-direction: column;
        /* Mengembalikan card menjadi vertikal */
        align-items: flex-start;
        /* Mengatur item agar tidak center */
    }

    .news-secondary-cards .news-card-img-container {
        width: 100%;
        /* Mengembalikan lebar gambar ke 100% dari kolomnya */
        min-width: unset;
        /* Hapus min-width */
        height: 150px;
        /* Tinggi gambar di card kecil */
    }

    /* Styling yang diperbarui untuk efek hover */
    .news-card {
        border: none;
        overflow: hidden;
        position: relative;
        cursor: pointer;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Hapus transform dan box-shadow dari news-card:hover */
        /* transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out; */
        transition: box-shadow 0.3s ease-in-out;
        /* Hanya transisi bayangan pada card */
    }

    /* Hanya efek bayangan pada card saat hover, bukan perbesaran card */
    .news-card:hover {
        /* transform: translateY(-5px); */
        /* Hapus ini */
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .news-main-card .news-card-img-container {
        height: 300px;
    }

    .news-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease-in-out;
        /* Transisi untuk animasi zoom pada gambar */
    }

    /* Efek zoom hanya pada gambar saat card di-hover */
    .news-card:hover .news-card-img {
        transform: scale(1.1);
        /* Zoom gambar 10% saat hover */
    }

    .news-card-body {
        /* Padding ini diatur langsung di HTML dengan p-4 */
        /* padding: 15px; */
        background-color: #fff;
    }

    .news-card-body h5 {
        font-size: 1.15rem;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .news-card-body h6 {
        font-size: 1.0rem;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .news-card-body p {
        font-size: 0.9rem;
        color: #6c757d;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Responsive adjustments for mobile */
    @media (max-width: 767.98px) {
        .news-secondary-cards .news-card {
            margin-bottom: 15px;
        }
    }
</style>