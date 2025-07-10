<section class="container my-5 py-5 fade-in-section">
    <h1 class="section-title text-center fade-in-from-top is-hidden">Sambutan Ketua Program Studi</h1>

    <?php if (isset($ketuaProdi) && $ketuaProdi): ?>
        <div class="row">
            <div class="col-md-8 order-2 order-md-1 justify-content-md-between d-flex flex-column fade-in-from-left text-center text-md-start is-hidden">
                <p class="lead"><?= esc(character_limiter($ketuaProdi['sambutan'], 1000, ' . . .')) ?></p>

                <h2 class="mb-3"><?= esc($ketuaProdi['nama']) ?></h2>
            </div>


            <div class="col-md-4 order-1 order-md-2 d-flex justify-content-center mb-4 mb-md-0 fade-in-from-right is-hidden">
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

<?= $this->section('style') ?>
<style>
    /* Base fade-in styles */
    .fade-in-from-top,
    .fade-in-from-left,
    .fade-in-from-right {
        opacity: 0;
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        /* Increased transition duration for smoother effect */
    }

    /* Initial hidden states */
    .fade-in-from-top.is-hidden {
        transform: translateY(-30px);
        /* Adjust as needed for desired initial position */
    }

    .fade-in-from-left.is-hidden {
        transform: translateX(-50px);
        /* Slide from left */
    }

    .fade-in-from-right.is-hidden {
        transform: translateX(50px);
        /* Slide from right */
    }

    /* Visible states */
    .fade-in-from-top.is-visible,
    .fade-in-from-left.is-visible,
    .fade-in-from-right.is-visible {
        opacity: 1;
        transform: translate(0, 0);
        /* Reset transform to original position */
    }

    /* Optional: Add a slight delay for staggered animation if desired */
    /* .fade-in-from-top { transition-delay: 0s; } */
    /* .fade-in-from-left { transition-delay: 0.2s; } */
    /* .fade-in-from-right { transition-delay: 0.4s; } */
</style>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all elements that need fade-in animation
        const animatedElements = document.querySelectorAll('.fade-in-from-top, .fade-in-from-left, .fade-in-from-right');

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