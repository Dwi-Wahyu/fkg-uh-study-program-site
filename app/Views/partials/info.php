<section class="container mb-5 py-5">
    <!-- Satu Card Utama untuk semua statistik -->
    <div class="card shadow border-0 rounded-lg">
        <div class="card-body">
            <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center">
                <!-- Info Departemen -->
                <div class="col">
                    <div class="text-center">
                        <img src="<?= base_url('departemen.svg') ?>" alt="Departemen Icon" class="mb-3 mx-auto" style="width: 50px; height: 50px;">
                        <h1 class="display-4 fw-bold text-primary">11</h1>
                        <p class="text-uppercase fw-semibold text-secondary">Departemen</p>
                    </div>
                </div>

                <!-- Info Program Studi -->
                <div class="col">
                    <div class="text-center">
                        <img src="<?= base_url('prodi.svg') ?>" alt="Program Studi Icon" class="mb-3 mx-auto" style="width: 50px; height: 50px;">
                        <h1 class="display-4 fw-bold text-primary">11</h1>
                        <p class="text-uppercase fw-semibold text-secondary">Program Studi</p>
                    </div>
                </div>

                <!-- Info Staff -->
                <div class="col">
                    <div class="text-center">
                        <img src="<?= base_url('staff.svg') ?>" alt="Staff Icon" class="mb-3 mx-auto" style="width: 50px; height: 50px;">
                        <h1 class="display-4 fw-bold text-primary">317</h1>
                        <p class="text-uppercase fw-semibold text-secondary">Staff</p>
                    </div>
                </div>

                <!-- Info Mahasiswa -->
                <div class="col">
                    <div class="text-center">
                        <img src="<?= base_url('mahasiswa.svg') ?>" alt="Mahasiswa Icon" class="mb-3 mx-auto" style="width: 50px; height: 50px;">
                        <h1 class="display-4 fw-bold text-primary">3866</h1>
                        <p class="text-uppercase fw-semibold text-secondary">Mahasiswa</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Jika Anda ingin warna spesifik #348CE5 untuk teks angka */
    .text-custom-blue {
        color: #348CE5 !important;
        /* !important mungkin diperlukan untuk override Bootstrap */
    }
</style>