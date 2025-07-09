<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Halaman' ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('assets/css/landing-page/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/landing-page/hero.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/topbar.css') ?>">

    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>">

    <style>
        .detail-hero-section {
            position: relative;
            overflow: hidden;
            height: 400px;
            /* Tinggi hero section */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            padding: 20px;
        }

        .detail-hero-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('<?= base_url('background.jpg') ?>');
            /* Gambar latar belakang */
            background-size: cover;
            background-position: center;
            z-index: 1;
            transform: scale(1.0);
            /* Base scale */
            transition: transform 0.5s ease-in-out;
            /* Transisi untuk zoom out */
        }

        /* Efek transisi overlay dari warna background ke top transparent */
        .detail-hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
            /* Gradient overlay: dari warna background (#f3f5f4) ke transparan */
            background: linear-gradient(to top, #f3f5f4 0%, transparent 100%);
        }

        /* Teks judul berita di atas overlay */
        .detail-hero-content {
            position: relative;
            z-index: 3;
            max-width: 800px;
        }

        .detail-hero-content h1 {
            font-size: 2.8rem;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        /* Card utama detail berita */
        .main-news-card {
            margin-top: -280px;
            /* Naikkan card agar tumpang tindih dengan hero section */
            position: relative;
            z-index: 5;
            /* Pastikan card di atas hero section */
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            background-color: #fff;
            padding: 30px;
        }

        .main-news-card-thumbnail {
            max-height: 400px;
            object-fit: cover;
            width: 100%;
            border-radius: 8px;
        }

        .news-detail-content img {
            max-width: 100%;
            height: auto;
            display: block;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .news-detail-content p {
            line-height: 1.8;
            margin-bottom: 1rem;
        }

        .news-detail-content h1,
        .news-detail-content h2,
        .news-detail-content h3 {
            margin-top: 1.5rem;
            margin-bottom: 1rem;
        }

        .news-detail-content ul,
        .news-detail-content ol {
            margin-left: 20px;
            margin-bottom: 1rem;
        }

        /* CSS untuk Rekomendasi Berita (Mirip card berita terbaru di homepage) */
        .recommendation-card {
            border: none;
            overflow: hidden;
            position: relative;
            cursor: pointer;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease-in-out;
        }

        .recommendation-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .recommendation-card-img-container {
            width: 100%;
            height: 180px;
            /* Tinggi gambar rekomendasi */
            overflow: hidden;
            position: relative;
        }

        .recommendation-card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease-in-out;
        }

        .recommendation-card:hover .recommendation-card-img {
            transform: scale(1.1);
            /* Zoom gambar saat hover */
        }

        .recommendation-card-body {
            padding: 15px;
            background-color: #fff;
        }

        .recommendation-card-body h5 {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 8px;
            /* Tambahan untuk line-clamp pada judul rekomendasi */
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .recommendation-card-body p {
            font-size: 0.85rem;
            color: #6c757d;
            line-height: 1.4;
            display: -webkit-box;
            /* Batasi deskripsi singkat hingga 3 baris */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>

<body style="background: #f3f5f4;">
    <div class="custom-navbar">
        <?= view('partials/topbar') ?>
    </div>

    <div class="detail-hero-section">
        <div class="detail-hero-background"></div>
        <div class="detail-hero-overlay"></div>
    </div>


    <?= $this->renderSection('content') ?>

    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>