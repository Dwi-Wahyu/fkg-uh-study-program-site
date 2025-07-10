<?php
$request = service('request');
$uri = $request->getUri(); // Menggunakan metode getUri() yang benar
$segments = $uri->getSegments(); //
$currentLocale = $request->getLocale(); //

// Buat path URI dasar tanpa segmen locale di awal
$pathWithoutLocaleSegments = [];
// Pastikan Anda mendapatkan supportedLocales dari konfigurasi App Anda
$supportedLocales = config(\Config\App::class)->supportedLocales ?? ['en', 'id']; //

foreach ($segments as $segment) {
    if (!in_array($segment, $supportedLocales)) {
        $pathWithoutLocaleSegments[] = $segment;
    }
}
$uriPathWithoutLocale = implode('/', $pathWithoutLocaleSegments);
?>

<div class="language-toggle-fixed">
    <a href="<?= base_url('id/' . $uriPathWithoutLocale) ?>" class="lang-flag-link <?= ($currentLocale === 'id') ? 'active' : '' ?>" title="Bahasa Indonesia">
        <img src="<?= base_url('flag-id.svg') ?>" alt="Bendera Indonesia">
    </a>
    <a href="<?= base_url('en/' . $uriPathWithoutLocale) ?>" class="lang-flag-link <?= ($currentLocale === 'en') ? 'active' : '' ?>" title="English">
        <img src="<?= base_url('flag-en.svg') ?>" alt="English Flag">
    </a>
</div>

<style>
    /* Gaya untuk container tombol bahasa fixed */
    .language-toggle-fixed {
        position: fixed;
        /* Membuat posisi tombol tetap di layar */
        bottom: 20px;
        /* Jarak dari bawah layar */
        right: 20px;
        /* Jarak dari kanan layar */
        z-index: 1000;
        /* Pastikan tombol selalu di atas konten lain */
        display: flex;
        flex-direction: column;
        /* Mengatur tombol secara vertikal */
        gap: 10px;
        /* Jarak antar tombol bendera */
        background-color: rgba(255, 255, 255, 0.8);
        /* Latar belakang semi-transparan */
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    /* Gaya untuk link bendera */
    .language-toggle-fixed .lang-flag-link {
        display: block;
        /* Memastikan link mengisi ruang yang tersedia */
        width: 50px;
        /* Lebar bendera */
        height: 35px;
        /* Tinggi bendera */
        border: 2px solid transparent;
        /* Border default transparan */
        border-radius: 5px;
        overflow: hidden;
        /* Pastikan gambar bendera tidak keluar dari border-radius */
        transition: all 0.3s ease;
    }

    /* Gaya untuk gambar bendera di dalam link */
    .language-toggle-fixed .lang-flag-link img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Memastikan gambar mengisi area tanpa terdistorsi */
        display: block;
    }

    /* Gaya saat bendera di-hover */
    .language-toggle-fixed .lang-flag-link:hover {
        transform: scale(1.05);
        /* Sedikit membesar saat di-hover */
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.3);
    }

    /* Gaya untuk bendera yang sedang aktif */
    .language-toggle-fixed .lang-flag-link.active {
        /* Warna border untuk bendera aktif */
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
    }
</style>