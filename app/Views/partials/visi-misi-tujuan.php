<section id="visi-misi-tujuan" class="container mt-10">
    <h1 class="section-title text-center fade-in-from-top is-hidden">Visi Misi dan Tujuan</h1>

    <?php if (isset($visiMisiTujuan) && $visiMisiTujuan): ?>
        <div class="row g-4 justify-content-center">
            <div class="col-12 col-md-4">
                <div class="card h-100 shadow border-0 rounded-lg fade-in-from-left is-hidden">
                    <div class="card-body">
                        <img src="/visi.svg" alt="">

                        <h3 class="card-title mt-2 mb-3">Visi</h3>
                        <p class="card-text text-muted text-justify">
                            <?= esc($visiMisiTujuan['visi']) ?>
                        </p>

                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card h-100 shadow border-0 rounded-lg fade-in-from-top is-hidden">
                    <div class="card-body">
                        <img src="/misi.svg" alt="">

                        <h3 class="card-title mt-2 mb-3">Misi</h3>
                        <p class="card-text text-muted text-justify">
                            <?= esc($visiMisiTujuan['misi']) ?>
                        </p>

                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card h-100 shadow border-0 rounded-lg fade-in-from-right is-hidden">
                    <div class="card-body">
                        <img src="/tujuan.svg" alt="">

                        <h3 class="card-title mt-2 mb-3">Tujuan</h3>
                        <p class="card-text text-muted text-justify">
                            <?= esc($visiMisiTujuan['tujuan']) ?>
                        </p>

                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p class="text-center text-muted">Data Visi, Misi, dan Tujuan tidak tersedia.</p>
    <?php endif; ?>
</section>

<?= $this->section('style') ?>
<style>
    /* Base fade-in styles for all animated elements */
    .fade-in-from-top,
    .fade-in-from-left,
    .fade-in-from-right {
        opacity: 0;
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        /* Consistent transition duration */
    }

    /* Initial hidden states (where they start) */
    .fade-in-from-top.is-hidden {
        transform: translateY(-30px);
        /* Start slightly above */
    }

    .fade-in-from-left.is-hidden {
        transform: translateX(-50px);
        /* Start from the left */
    }

    .fade-in-from-right.is-hidden {
        transform: translateX(50px);
        /* Start from the right */
    }

    /* Visible states (where they end up) */
    .fade-in-from-top.is-visible,
    .fade-in-from-left.is-visible,
    .fade-in-from-right.is-visible {
        opacity: 1;
        transform: translate(0, 0);
        /* End at their original position */
    }

    /* Optional: Staggered animation delays for a smoother reveal */
    /* Adjust these values as needed for the desired effect */
    .section-title.fade-in-from-top {
        transition-delay: 0.1s;
        /* Title appears first */
    }

    .card.fade-in-from-left {
        transition-delay: 0.3s;
        /* Visi card after title */
    }

    .card.fade-in-from-top {
        /* This targets the Misi card */
        transition-delay: 0.3s;
        /* Misi card after Visi */
    }

    .card.fade-in-from-right {
        transition-delay: 0.3s;
        /* Tujuan card after Misi */
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all elements that need fade-in animation based on their specific animation classes
        const animatedElements = document.querySelectorAll(
            '#visi-misi-tujuan .fade-in-from-top, ' +
            '#visi-misi-tujuan .fade-in-from-left, ' +
            '#visi-misi-tujuan .fade-in-from-right'
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
                    entry.target.classList.remove('is-hidden'); // Ensure hidden class is removed
                    observer.unobserve(entry.target); // Stop observing once it's visible
                }
            });
        }, observerOptions);

        animatedElements.forEach(element => {
            elementObserver.observe(element);
        });
    });
</script>
<?= $this->endSection() ?>