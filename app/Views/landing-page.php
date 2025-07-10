<?= $this->extend('layout/landing-page') ?>

<?= $this->section('content') ?>
<?= view('partials/hero') ?>

<?= view('partials/language-toggle') ?>

<?= view('partials/sambutan-ketua-program-studi', ['ketuaProdi' => $ketuaProdi, 'currentLocale' => $currentLocale]) ?>

<?= view('partials/visi-misi-tujuan', ['visiMisiTujuan' => $visiMisiTujuan, 'currentLocale' => $currentLocale]) ?>

<?= view('partials/info') ?>

<?= view('partials/pimpinan-fakultas') ?>

<?= view('partials/kemitraan-sejarah') ?>

<?= view('partials/berita') ?>

<?= view('partials/layanan-mahasiswa') ?>

<?= view('partials/footer') ?>


<?= $this->endSection() ?>