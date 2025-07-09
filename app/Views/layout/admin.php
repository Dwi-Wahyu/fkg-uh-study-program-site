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
                <a href="/admin/profil-lulusan" class="nav-link <?= $segment2 === 'profil-lulusan' ? 'active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32">
                        <rect width="32" height="32" fill="none" />
                        <path fill="currentColor" d="m16 7.78l-.313.095l-12.5 4.188L.345 13L2 13.53v8.75c-.597.347-1 .98-1 1.72a2 2 0 1 0 4 0c0-.74-.403-1.373-1-1.72v-8.06l2 .655V20c0 .82.5 1.5 1.094 1.97c.594.467 1.332.797 2.218 1.093c1.774.59 4.112.937 6.688.937s4.914-.346 6.688-.938c.886-.295 1.624-.625 2.218-1.093C25.5 21.5 26 20.82 26 20v-5.125l2.813-.938L31.655 13l-2.843-.938l-12.5-4.187zm0 2.095L25.375 13L16 16.125L6.625 13zm-8 5.688l7.688 2.562l.312.094l.313-.095L24 15.562V20c0 .01.004.126-.313.375c-.316.25-.883.565-1.625.813C20.58 21.681 18.395 22 16 22s-4.58-.318-6.063-.813c-.74-.247-1.308-.563-1.624-.812C7.995 20.125 8 20.01 8 20z" />
                    </svg>

                    Profil Lulusan
                    <div class="corner-right-top">

                    </div>
                    <div class="corner-right-bottom">

                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/sejarah" class="nav-link <?= $segment2 === 'sejarah' ? 'active' : '' ?>">
                    <i class="bi bi-clock-history me-2"></i> Sejarah
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