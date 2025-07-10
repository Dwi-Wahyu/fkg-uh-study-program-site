<section class="container my-5 py-5">
    <div class="d-flex flex-column flex-md-row gap-4">
        <div class="flex-md-grow-0 w-md-70 fade-in-from-left is-hidden" style="flex-basis: 70%;">
            <h1 class="section-title-2">Kemitraan</h1>
            <img src="<?= base_url('kemitraan.png') ?>" class="img-fluid" alt="Kemitraan">
        </div>
        <div class="flex-md-grow-0 w-md-30 fade-in-from-right is-hidden" style="flex-basis: 30%;">
            <h1 class="section-title-2">Sejarah</h1>

            <div class="text-justify">
                <?= character_limiter($sejarah ?? '', 700, ' . . .') ?>
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

<?= $this->section('style') ?>
<style>
    /* Base fade-in styles (reused from previous sections) */
    .fade-in-from-top,
    /* Keep if used elsewhere */
    .fade-in-from-left,
    .fade-in-from-right {
        opacity: 0;
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }

    /* Initial hidden states */
    .fade-in-from-top.is-hidden {
        /* Keep if used elsewhere */
        transform: translateY(-30px);
    }

    .fade-in-from-left.is-hidden {
        transform: translateX(-50px);
        /* Start from the left */
    }

    .fade-in-from-right.is-hidden {
        transform: translateX(50px);
        /* Start from the right */
    }

    /* Visible states */
    .fade-in-from-top.is-visible,
    /* Keep if used elsewhere */
    .fade-in-from-left.is-visible,
    .fade-in-from-right.is-visible {
        opacity: 1;
        transform: translate(0, 0);
    }

    /* Optional: Staggered animation delays for this section */
    .flex-md-grow-0.w-md-70.fade-in-from-left {
        /* Kemitraan div */
        transition-delay: 0.3s;
    }

    .flex-md-grow-0.w-md-30.fade-in-from-right {
        /* Sejarah div */
        transition-delay: 0.3s;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select the specific animated elements within this section
        const animatedElements = document.querySelectorAll(
            'section.container.my-5.py-5 .fade-in-from-left, ' +
            'section.container.my-5.py-5 .fade-in-from-right'
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