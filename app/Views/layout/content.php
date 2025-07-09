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
</head>

<body style="background: #f3f5f4;">
    <div class="custom-navbar">
        <?= view('partials/topbar') ?>
    </div>

    <?= $this->renderSection('content') ?>

    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>