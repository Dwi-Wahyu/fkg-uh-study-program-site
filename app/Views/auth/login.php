<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            /* Pastikan ini di dalam blok <style> di file .php agar base_url() dieksekusi */
            background-image: url('<?= base_url('background.jpg') ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Overlay hitam 50% */
        }

        .logo-univ {
            position: absolute;
            top: 20px;
            left: 20px;
            max-width: 200px;
            /* Sesuaikan ukuran logo */
            z-index: 10;
            /* Agar logo di atas overlay */
        }

        .card {
            width: 400px;
            /* Lebar card login */
            z-index: 10;
            /* Agar card di atas overlay */
        }

        .card-header {
            text-align: center;
            padding: 20px;
            background-color: #ffffff;
            /* Warna latar belakang header card */
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }

        .card-header h3 {
            margin-bottom: 5px;
        }

        .card-header p {
            color: #6c757d;
            /* Warna teks subjudul */
        }

        .card-body {
            padding: 20px;
            background-color: #ffffff;
        }

        .alert {
            margin-bottom: 15px;
        }

        .form-label {
            margin-top: 10px;
        }

        .btn-primary {
            width: 100%;
        }

        .text-muted {
            margin-top: 15px;
            text-align: center;
            color: #6c757d;
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
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
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
                    <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>