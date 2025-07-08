<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    $uri = service('uri');
    $segments = $uri->getSegments();
    $page_title = 'Admin Panel'; // Default title

    // Jika ada segmen URI, gunakan segmen terakhir sebagai judul
    if (!empty($segments)) {
        $last_segment = end($segments); // Ambil segmen terakhir
        $cleaned_last_segment = str_replace('-', ' ', $last_segment); // Ganti hyphen dengan spasi
        $page_title = ucwords($cleaned_last_segment); // Kapitalisasi setiap kata
    }
    ?>
    <title><?= esc($title ?? $page_title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/breadcrumb.css') ?>">
</head>

<body>

    <div class="sidebar">
        <div class="logo">
            <img src="/logo/landing-header.png" alt="">
        </div>
        <?php
        $uri = service('uri');
        $segment2 = $uri->getSegment(2);
        ?>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="/admin/dashboard" class="nav-link <?= $segment2 === 'dashboard' ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    <div class="corner-right-top">

                    </div>
                    <div class="corner-right-bottom">

                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/ketua-program-studi" class="nav-link <?= $segment2 === 'ketua-program-studi' ? 'active' : '' ?>">
                    <i class="bi bi-person-bounding-box me-2"></i> Ketua Program Studi
                    <div class="corner-right-top">

                    </div>
                    <div class="corner-right-bottom">

                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/visi-misi-tujuan" class="nav-link <?= $segment2 === 'visi-misi-tujuan' ? 'active' : '' ?>">
                    <i class="bi bi-bullseye me-2"></i> Visi Misi dan Tujuan
                    <div class="corner-right-top">

                    </div>
                    <div class="corner-right-bottom">

                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/sarana-prasarana" class="nav-link <?= $segment2 === 'sarana-prasarana' ? 'active' : '' ?>">
                    <i class="bi bi-building-gear me-2"></i> Sarana dan Prasarana
                    <div class="corner-right-top">

                    </div>
                    <div class="corner-right-bottom">

                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/berita" class="nav-link <?= $segment2 === 'berita' ? 'active' : '' ?>">
                    <i class="bi bi-newspaper me-2"></i> Berita
                    <div class="corner-right-top">

                    </div>
                    <div class="corner-right-bottom">

                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/media-berita" class="nav-link <?= $segment2 === 'media-berita' ? 'active' : '' ?>">
                    <i class="bi bi-camera-video me-2"></i> Media Berita
                    <div class="corner-right-top">

                    </div>
                    <div class="corner-right-bottom">

                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/student-activity" class="nav-link <?= $segment2 === 'student-activity' ? 'active' : '' ?>">
                    <i class="bi bi-people me-2"></i> Student Activity
                    <div class="corner-right-top">

                    </div>
                    <div class="corner-right-bottom">

                    </div>
                </a>
            </li>

            <li class="nav-item">
                <a href="/logout" class="nav-link">
                    <i class="bi bi-box-arrow-left me-2"></i></i> Logout
                </a>
            </li>
        </ul>
    </div>

    <div class="content">
        <?php
        // Logika breadcrumb
        $path = '';

        // Ambil segmen URI pertama dan kedua untuk pengecekan
        $first_segment = $uri->getSegment(1);
        $second_segment = $uri->getSegment(2);

        // Kondisi untuk tidak merender breadcrumb
        // Jika rute adalah /admin atau /admin/dashboard
        if (!($first_segment === 'admin' && (empty($second_segment) || $second_segment === 'dashboard'))) :
        ?>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb-custom">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
                    <?php
                    foreach ($segments as $index => $segment) {
                        $cleaned_segment = str_replace('-', ' ', $segment);
                        $display_segment = ucwords($cleaned_segment);
                        $path .= '/' . $segment;
                        $is_active = ($index === count($segments) - 1);
                    ?>
                        <li class="breadcrumb-item <?= $is_active ? 'active' : '' ?>" <?= $is_active ? 'aria-current="page"' : '' ?>>
                            <?php if (!$is_active) : ?>
                                <a href="<?= base_url($path) ?>"><?= esc($display_segment) ?></a>
                            <?php else : ?>
                                <?= esc($display_segment) ?>
                            <?php endif; ?>
                        </li>
                    <?php
                    }
                    ?>
                </ol>
            </nav>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-3 w-full">
            <h3 class="page-header"><?= esc($title ?? $page_title) ?></h3>

            <?= $this->renderSection('navigation') ?>
        </div>

        <?= $this->renderSection('content') ?>
    </div>

    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <?= $this->renderSection('javascript') ?>

</body>

</html>