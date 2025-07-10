<?= $this->extend('layout/main') ?>

<?= $this->section('style') ?>
<style>
    /* Warna dasar */
    :root {
        --primary-bg: #348CE5;
        /* Biru */
        --primary-text: #FFFFFF;
        /* Putih */
    }

    /* Gaya card default */
    .survey-card {
        background-color: var(--primary-bg);
        color: var(--primary-text);
        transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
        border: 1px solid var(--primary-bg);
        /* Border sesuai warna background */
        border-radius: 0.5rem;
        /* Rounded corners */
        overflow: hidden;
        /* Pastikan konten tidak keluar dari border-radius */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Sedikit bayangan */
        text-decoration: none;
        /* Hapus underline pada link */
        display: flex;
        /* Untuk centering teks vertikal */
        align-items: center;
        /* Centering vertikal */
        justify-content: center;
        /* Centering horizontal */
        min-height: 120px;
        /* Tinggi minimum untuk card */
        text-align: center;
        /* Teks rata tengah */
        padding: 1rem;
        /* Padding di dalam card */

        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Gaya card saat di-hover */
    .survey-card:hover {
        background-color: var(--primary-text);
        /* Background jadi putih */
        color: var(--primary-bg);
        /* Teks jadi biru */
        border-color: var(--primary-bg);
        /* Border tetap biru */
        transform: translateY(-5px);
        /* Efek sedikit terangkat */
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        /* Bayangan lebih tebal */
    }

    /* Pastikan link di dalam card juga mewarisi warna teks */
    .survey-card a {
        color: inherit;
        /* Mewarisi warna teks dari parent */
        text-decoration: none;
        /* Hapus underline */
    }

    .survey-card a:hover {
        text-decoration: none;
        /* Pastikan tidak ada underline saat hover */
    }

    /* Gaya untuk judul di dalam card */
    .survey-card h5 {
        margin: 0;
        /* Hapus margin default h5 */
        font-weight: bold;
        /* Judul lebih tebal */
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="main-news-card">
                <h4 class="mb-4"><?= esc($title) ?></h4>

                <div class="news-detail-content">
                    <?php if (empty($surveis)): ?>
                        <div class="alert alert-info text-center" role="alert">
                            Belum ada survei yang tersedia saat ini.
                        </div>
                    <?php else: ?>
                        <div class="row row-cols-2 row-cols-md-5 g-4">
                            <?php foreach ($surveis as $survei): ?>
                                <div class="col">
                                    <a href="<?= esc($survei['link']) ?>" target="_blank" class="survey-card d-block">
                                        <h5><?= esc($survei['judul']) ?></h5>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>