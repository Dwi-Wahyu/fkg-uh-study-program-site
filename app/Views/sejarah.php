<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="main-news-card">
                <h4>Sejarah</h4>

                <div class="news-detail-content">
                    <?= $sejarah['content'] ?? '' ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>