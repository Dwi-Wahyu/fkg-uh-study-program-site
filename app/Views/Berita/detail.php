<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="main-news-card">
                <h4><?= esc($berita['judul']) ?></h4>


                <?php if (!empty($berita['thumbnail'])): ?>
                    <img src="<?= base_url('berita/' . $berita['thumbnail']) ?>" class="img-fluid rounded mb-4 main-news-card-thumbnail" alt="<?= esc($berita['judul']) ?>">
                <?php else: ?>
                    <img src="https://via.placeholder.com/800x400?text=No+Image" class="img-fluid rounded mb-4 main-news-card-thumbnail" alt="No Image">
                <?php endif; ?>

                <?php if (!empty($berita['deskripsi_singkat'])): ?>
                    <p class="lead mb-4"><?= esc($berita['deskripsi_singkat']) ?></p>
                <?php endif; ?>

                <div class="news-detail-content mb-5">
                    <?= $berita['detail'] ?? '' ?>
                </div>

                <a href="/" class="btn btn-primary">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <h3 class="text-center mb-4">Berita Lainnya</h3>
    <div class="row justify-content-center">
        <?php if (!empty($rekomendasiBerita)): ?>
            <?php foreach ($rekomendasiBerita as $news): ?>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card recommendation-card h-100">
                        <div class="recommendation-card-img-container">
                            <?php if (!empty($news['thumbnail'])): ?>
                                <img src="<?= base_url('berita/' . $news['thumbnail']) ?>" class="recommendation-card-img" alt="<?= esc($news['judul']) ?>">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/400x200?text=No+Image" class="recommendation-card-img" alt="No Image">
                            <?php endif; ?>
                        </div>
                        <div class="recommendation-card-body">
                            <h5 class="card-title"><?= esc($news['judul']) ?></h5>
                            <p class="card-text"><?= esc(character_limiter($news['deskripsi_singkat'] ?? $news['detail'] ?? '', 80)) ?></p>
                            <a href="/berita/<?= $news['id'] ?>" class="btn btn-sm btn-outline-primary mt-2">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="text-muted">Tidak ada berita rekomendasi lainnya.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>