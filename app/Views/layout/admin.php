<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Admin Panel') ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: "Open Sans", sans-serif;
            background-color: #f0f2f5;
            /* Light background for the main content area */
        }

        .sidebar {
            background-color: #348CE5;
            /* Primary color */
            width: 250px;
            height: calc(100vh - 40px);
            /* Adjust height for floating effect */
            position: fixed;
            top: 20px;
            /* Top padding for floating */
            left: 20px;
            /* Left padding for floating */
            padding-top: 60px;
            color: white;
            border-radius: 15px;
            /* Rounded corners for the sidebar */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            /* Subtle shadow for floating effect */
            overflow-y: auto;
            /* Enable scrolling if content exceeds height */
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 10px 15px;
            /* Add some internal padding to nav links */
            margin: 5px 0;
            /* Add margin between nav links */
            border-radius: 8px;
            /* Slightly rounded corners for nav items */
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .sidebar .nav-link.active {
            background-color: #2d7ccc;
            /* A slightly darker shade of primary for active state */
            color: #fff;
            font-weight: bold;
        }

        .content {
            margin-left: 265px;
            /* Adjust margin to account for floating sidebar and its padding */
            padding: 2rem;
        }

        .sidebar .logo {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 60px;
            /* Keep this height as set previously */
            background-color: #2d7ccc;
            /* Darker shade of primary for the logo area */
            display: flex;
            align-items: center;
            /* Vertically center the content (including the image) */
            justify-content: center;
            /* Horizontally center the content (including the image) */
            font-weight: bold;
            border-top-left-radius: 15px;
            /* Match sidebar rounded corners */
            border-top-right-radius: 15px;
            /* Match sidebar rounded corners */
        }

        .sidebar .logo img {
            max-height: 100%;
            /* Ensures the image doesn't exceed the height of its container */
            max-width: 90%;
            /* Limits the width to prevent it from touching the edges, adjust as needed */
            object-fit: contain;
            /* Ensures the entire image is visible within its bounds, maintaining aspect ratio */
            padding: 5px;
            /* Add a little padding around the logo if desired, adjust as needed */
        }

        /* Adjustments for the nav list within the sidebar to give internal padding */
        .sidebar .nav {
            padding: 10px;
            /* Padding inside the nav container */
        }
    </style>
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
        <ul class="nav flex-column px-3">
            <li class="nav-item">
                <a href="/admin/dashboard" class="nav-link <?= $segment2 === 'dashboard' ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/berita" class="nav-link <?= $segment2 === 'berita' ? 'active' : '' ?>">
                    <i class="bi bi-newspaper me-2"></i> Berita
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/media-berita" class="nav-link <?= $segment2 === 'media-berita' ? 'active' : '' ?>">
                    <i class="bi bi-camera-video me-2"></i> Media Berita
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/student-activity" class="nav-link <?= $segment2 === 'student-activity' ? 'active' : '' ?>">
                    <i class="bi bi-people me-2"></i> Student Activity
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/gallery" class="nav-link <?= $segment2 === 'gallery' ? 'active' : '' ?>">
                    <i class="bi bi-images me-2"></i> Gallery
                </a>
            </li>
        </ul>
    </div>

    <div class="content">
        <?= $this->renderSection('content') ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>