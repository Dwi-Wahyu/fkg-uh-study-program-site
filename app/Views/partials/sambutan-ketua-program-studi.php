<section class="container my-5 py-5">
    <h1 class="section-title text-center">Sambutan Ketua Program Studi</h1>

    <?php if (isset($ketuaProdi) && $ketuaProdi): ?>
        <div class="row">
            <div class="col-md-8 order-2 order-md-1 justify-content-md-between d-flex flex-column text-center text-md-start">
                <p class="lead"><?= esc(character_limiter($ketuaProdi['sambutan'], 1000, ' . . .')) ?></p>

                <h2 class="mb-3"><?= esc($ketuaProdi['nama']) ?></h2>
            </div>


            <!-- Bagian Gambar (Kanan) -->
            <div class="col-md-4 order-1 order-md-2 d-flex justify-content-center mb-4 mb-md-0">
                <img
                    src="<?= base_url('ketua-prodi/' . $ketuaProdi['gambar']) ?>"
                    alt="Foto Ketua Program Studi: <?= esc($ketuaProdi['nama']) ?>"
                    class="img-fluid rounded shadow"
                    style="max-width: 400px; height: auto;"
                    onerror="this.onerror=null;this.src='https://placehold.co/400x400/E0E0E0/6C6C6C?text=No+Image';">
            </div>
        </div>
    <?php else: ?>
        <p class="text-center text-muted">Data Ketua Program Studi tidak tersedia.</p>
    <?php endif; ?>
</section>