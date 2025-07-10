<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #348CE5;
            /* Warna biru utama dari sidebar */
            --light-grey: #f0f2f5;
            --dark-overlay: rgba(0, 0, 0, 0.6);
            /* Sedikit lebih gelap untuk kontras teks */
            --card-bg: rgba(255, 255, 255, 0.95);
            /* Sedikit transparan untuk efek blur */
        }

        body {
            background-image: url('<?= base_url('background.jpg') ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            position: relative;
            font-family: 'Figtree', sans-serif;
            /* Menggunakan font Figtree */
            color: #333;
            /* Warna teks umum */
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--dark-overlay);
            /* Overlay hitam 60% */
            backdrop-filter: blur(3px);
            /* Efek blur pada background */
            z-index: 1;
        }

        .logo-univ {
            position: absolute;
            top: 30px;
            /* Sedikit lebih jauh dari atas */
            left: 30px;
            /* Sedikit lebih jauh dari kiri */
            max-width: 220px;
            /* Sedikit lebih besar */
            height: auto;
            z-index: 10;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
            /* Sedikit bayangan pada logo */
        }

        .card {
            width: 420px;
            /* Sedikit lebih lebar */
            z-index: 10;
            border: none;
            /* Hilangkan border default Bootstrap */
            border-radius: 15px;
            /* Sudut lebih membulat */
            overflow: hidden;
            /* Penting agar border-radius bekerja pada inner elements */
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            /* Bayangan lebih dalam */
            background-color: var(--card-bg);
            /* Warna background card semi-transparan */
            backdrop-filter: blur(5px);
            /* Efek blur pada card itu sendiri */
        }

        .card-header {
            text-align: center;
            padding: 30px 20px 20px;
            /* Padding lebih banyak di atas */
            background-color: transparent;
            /* Transparan agar terlihat backdrop-filter */
            border-bottom: none;
            /* Hilangkan border bawah */
        }

        .card-header h3 {
            font-weight: 700;
            /* Lebih tebal */
            color: var(--primary-blue);
            /* Warna judul sesuai tema */
            margin-bottom: 8px;
            /* Spasi antar judul dan subjudul */
        }

        .card-header p {
            color: #555;
            /* Warna teks subjudul lebih gelap */
            font-size: 0.95rem;
        }

        .card-body {
            padding: 25px 30px 35px;
            /* Padding lebih proporsional */
            background-color: transparent;
            /* Transparan */
        }

        .alert {
            margin-bottom: 20px;
            /* Spasi lebih besar untuk alert */
            border-radius: 8px;
            /* Sudut alert membulat */
            font-size: 0.9rem;
        }

        .form-label {
            font-weight: 500;
            /* Sedikit lebih tebal dari normal */
            color: #444;
            margin-bottom: 5px;
            /* Spasi lebih kecil antara label dan input */
        }

        .form-control {
            border-radius: 8px;
            /* Sudut input membulat */
            padding: 10px 15px;
            border: 1px solid #ced4da;
            transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.25rem rgba(45, 124, 204, 0.25);
            /* Shadow fokus warna biru */
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            /* Padding lebih besar untuk tombol */
            margin-top: 25px;
            /* Spasi lebih besar di atas tombol */
            border-radius: 8px;
            /* Sudut tombol membulat */
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
            font-weight: 600;
            transition: background-color 0.3s ease, border-color 0.3s ease, transform 0.2s ease;
        }

        .btn-primary:hover {
            /* Warna sedikit lebih gelap saat hover */
            transform: translateY(-2px);
            /* Sedikit efek naik saat hover */
        }

        .btn-primary:active {
            transform: translateY(0);
            /* Kembali ke posisi normal saat diklik */
        }

        .text-muted {
            margin-top: 25px;
            /* Spasi lebih besar di atas teks muted */
            text-align: center;
            color: #888 !important;
            /* Warna yang lebih netral */
            font-size: 0.85rem;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .card {
                width: 90%;
                margin: 0 15px;
            }

            .logo-univ {
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                max-width: 180px;
            }

            body {
                padding-top: 100px;
                /* Beri ruang untuk logo di atas */
            }
        }
    </style>
</head>

<body>
    <img src="<?= base_url('logo/landing-header.png') ?>" alt="Logo Universitas" class="logo-univ">
    <div class="card shadow-lg">
        <div class="card-header">
            <h3>Login Admin</h3>
            <p class="mb-0">PPDGS Bedah Mulut dan Maksilofasial</p>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0 ps-3"> <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="/login" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required autocomplete="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>