<section class="container my-5 py-5">
    <h1 class="section-title text-center fade-in-from-top is-hidden">Pimpinan Fakultas</h1>

    <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center">
        <div class="col">
            <div class="card h-100 shadow border-0 rounded-lg text-center fade-in-from-top is-hidden">
                <div class="card-body d-flex flex-column align-items-center">
                    <img
                        src="<?= base_url('pimpinan/dekan.png') ?>"
                        alt="Foto Dekan Irfan Sugianto"
                        class="img-fluid mb-3"
                        style="max-width: 350px; max-height: 350px; object-fit: contain; border-radius: 8px;"
                        onerror="this.onerror=null;this.src='https://placehold.co/200x200/E0E0E0/6C6C6C?text=Foto+Dekan';">
                    <h3 class="card-title h5 fw-semibold mb-1">Irfan Sugianto, drg., M.Med., Ph.D</h3>
                    <p class="card-text text-muted">Dekan</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 shadow border-0 rounded-lg text-center fade-in-from-top is-hidden">
                <div class="card-body d-flex flex-column align-items-center">
                    <img
                        src="<?= base_url('pimpinan/wd1.png') ?>"
                        alt="Foto Wakil Dekan 1 Acing Habibie Mude"
                        class="img-fluid mb-3"
                        style="max-width: 350px; max-height: 350px; object-fit: contain; border-radius: 8px;"
                        onerror="this.onerror=null;this.src='https://placehold.co/200x200/E0E0E0/6C6C6C?text=Foto+WD1';">
                    <h3 class="card-title h5 fw-semibold mb-1">Acing Habibie Mude, drg., Ph.D., Sp.Pros., Subsp.OGST(K)</h3>
                    <p class="card-text text-muted">Wakil Dekan Bidang Akademik dan Kemahasiswaan</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 shadow border-0 rounded-lg text-center fade-in-from-top is-hidden">
                <div class="card-body d-flex flex-column align-items-center">
                    <img
                        src="<?= base_url('pimpinan/wd2.png') ?>"
                        alt="Foto Wakil Dekan 2 Dr. Juni Jekti Nugroho"
                        class="img-fluid mb-3"
                        style="max-width: 350px; max-height: 350px; object-fit: contain; border-radius: 8px;"
                        onerror="this.onerror=null;this.src='https://placehold.co/200x200/E0E0E0/6C6C6C?text=Foto+WD2';">
                    <h3 class="card-title h5 fw-semibold mb-1">Dr. Juni Jekti Nugroho, drg., Sp.KG., Subsp., KE (K)</h3>
                    <p class="card-text text-muted">Wakil Dekan Bidang Perencanaan, Sumber Daya, dan Alumni</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 shadow border-0 rounded-lg text-center fade-in-from-top is-hidden">
                <div class="card-body d-flex flex-column align-items-center">
                    <img
                        src="<?= base_url('pimpinan/wd3.png') ?>"
                        alt="Foto Wakil Dekan 3 Erni Marlina"
                        class="img-fluid mb-3"
                        style="max-width: 350px; max-height: 350px; object-fit: contain; border-radius: 8px;"
                        onerror="this.onerror=null;this.src='https://placehold.co/200x200/E0E0E0/6C6C6C?text=Foto+WD3';">
                    <h3 class="card-title h5 fw-semibold mb-1">Erni Marlina,drg., Ph.D., Sp.PM, Subsp.Inf(K)</h3>
                    <p class="card-text text-muted">Wakil Dekan Bidang Kemitraan, Riset, dan Inovasi</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->section('style') ?>
<style>
    /* Base fade-in styles (reused from previous sections) */
    .fade-in-from-top,
    .fade-in-from-left,
    /* Keep these if you use them elsewhere */
    .fade-in-from-right {
        /* Keep these if you use them elsewhere */
        opacity: 0;
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }

    /* Initial hidden state for fade-in-from-top */
    .fade-in-from-top.is-hidden {
        transform: translateY(-30px);
    }

    /* Visible state for all fade-in animations */
    .fade-in-from-top.is-visible,
    .fade-in-from-left.is-visible,
    .fade-in-from-right.is-visible {
        opacity: 1;
        transform: translate(0, 0);
    }

    /* Staggered animation delays for cards */
    /* Adjust these values to control the sequence and speed of appearance */
    .section-title.fade-in-from-top {
        transition-delay: 0.1s;
        /* Title appears first */
    }

    /* Target each card specifically if you want different delays for each */
    .col:nth-child(1) .card.fade-in-from-top {
        transition-delay: 0.3s;
    }

    .col:nth-child(2) .card.fade-in-from-top {
        transition-delay: 0.3s;
    }

    .col:nth-child(3) .card.fade-in-from-top {
        transition-delay: 0.3s;
    }

    .col:nth-child(4) .card.fade-in-from-top {
        transition-delay: 0.3s;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all elements that need fade-in animation within this section
        // We are targeting the title and all card elements.
        const animatedElements = document.querySelectorAll(
            '#pimpinan-fakultas .fade-in-from-top, ' + /* If you add an ID to the section */
            '.section-title.fade-in-from-top, ' +
            '.card.fade-in-from-top'
        );

        const observerOptions = {
            root: null, // relative to the viewport
            rootMargin: '0px',
            threshold: 0.1 // Trigger when 10% of the element is visible
        };

        const elementObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    entry.target.classList.remove('is-hidden');
                    observer.unobserve(entry.target); // Stop observing once visible
                }
            });
        }, observerOptions);

        animatedElements.forEach(element => {
            elementObserver.observe(element);
        });
    });
</script>
<?= $this->endSection() ?>