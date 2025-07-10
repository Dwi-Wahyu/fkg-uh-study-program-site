<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="main-news-card">
                <h4 class="mb-4"><?= esc($title) ?></h4>

                <div class="news-detail-content">
                    <?= $sejarah_content ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>