<section class="container my-5 py-5">
    <div class="d-flex flex-column flex-md-row gap-4">
        <div class="flex-md-grow-0 w-md-70" style="flex-basis: 70%;">
            <h1 class="section-title-2">Kemitraan</h1>
            <img src="<?= base_url('kemitraan.png') ?>" class="img-fluid" alt="Kemitraan">
        </div>
        <div class="flex-md-grow-0 w-md-30" style="flex-basis: 30%;">
            <h1 class="section-title-2">Sejarah</h1>

            <div class="text-justify">
                <?= character_limiter($sejarah['content'] ?? '', 700, ' . . .') ?>
            </div>


            <a
                name=""
                id=""
                class="btn btn-primary mt-4"
                href="/sejarah"
                role="button">Selengkapnya</a>

        </div>
    </div>
</section>