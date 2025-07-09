<section id="visi-misi-tujuan" class="container mt-10">
    <h1 class="section-title text-center">Visi Misi dan Tujuan</h1>

    <?php if (isset($visiMisiTujuan) && $visiMisiTujuan): ?>
        <div class="row g-4 justify-content-center">
            <!-- Card Visi -->
            <div class="col-12 col-md-4">
                <div class="card h-100 shadow border-0 rounded-lg">
                    <div class="card-body">
                        <img src="/visi.svg" alt="">

                        <h3 class="card-title mt-2 mb-3">Visi</h3>
                        <p class="card-text text-muted text-justify">
                            <?= esc($visiMisiTujuan['visi_id']) ?>
                        </p>

                    </div>
                </div>
            </div>

            <!-- Card Misi -->
            <div class="col-12 col-md-4">
                <div class="card h-100 shadow border-0 rounded-lg">
                    <div class="card-body">
                        <img src="/misi.svg" alt="">

                        <h3 class="card-title mt-2 mb-3">Misi</h3>
                        <p class="card-text text-muted text-justify">
                            <?= esc($visiMisiTujuan['misi_id']) ?>
                        </p>

                    </div>
                </div>
            </div>

            <!-- Card Tujuan -->
            <div class="col-12 col-md-4">
                <div class="card h-100 shadow border-0 rounded-lg">
                    <div class="card-body">
                        <img src="/tujuan.svg" alt="">

                        <h3 class="card-title mt-2 mb-3">Tujuan</h3>
                        <p class="card-text text-muted text-justify">
                            <?= esc($visiMisiTujuan['tujuan_id']) ?>
                        </p>

                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p class="text-center text-muted">Data Visi, Misi, dan Tujuan tidak tersedia.</p>
    <?php endif; ?>
</section>