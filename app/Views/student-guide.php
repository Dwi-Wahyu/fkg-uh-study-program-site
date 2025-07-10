<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="main-news-card">
                <h4>Student Guide</h4>
                <hr>
                <div class="pdf-container" style="position: relative; width: 100%; padding-bottom: 75%; height: 0; overflow: hidden;">
                    <iframe
                        src="<?= base_url('student-guide.pdf') ?>"
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"
                        frameborder="0"
                        allowfullscreen>
                        <p>Browser Anda tidak mendukung embedding PDF. Anda bisa <a href="<?= base_url('student-guide.pdf') ?>">mengunduh file PDF di sini</a>.</p>
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>