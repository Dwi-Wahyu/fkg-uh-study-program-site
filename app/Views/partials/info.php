<section class="container mb-5 py-5 animated-counter-section">
    <div class="card shadow border-0 rounded-lg">
        <div class="card-body">
            <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center">
                <div class="col">
                    <div class="text-center">
                        <img src="<?= base_url('departemen.svg') ?>" alt="Departemen Icon" class="mb-3 mx-auto" style="width: 50px; height: 50px;">
                        <h1 class="display-4 fw-bold text-primary counter" data-target="11">0</h1>
                        <p class="text-uppercase fw-semibold text-secondary">Departemen</p>
                    </div>
                </div>

                <div class="col">
                    <div class="text-center">
                        <img src="<?= base_url('prodi.svg') ?>" alt="Program Studi Icon" class="mb-3 mx-auto" style="width: 50px; height: 50px;">
                        <h1 class="display-4 fw-bold text-primary counter" data-target="11">0</h1>
                        <p class="text-uppercase fw-semibold text-secondary">Program Studi</p>
                    </div>
                </div>

                <div class="col">
                    <div class="text-center">
                        <img src="<?= base_url('staff.svg') ?>" alt="Staff Icon" class="mb-3 mx-auto" style="width: 50px; height: 50px;">
                        <h1 class="display-4 fw-bold text-primary counter" data-target="317">0</h1>
                        <p class="text-uppercase fw-semibold text-secondary">Staff</p>
                    </div>
                </div>

                <div class="col">
                    <div class="text-center">
                        <img src="<?= base_url('mahasiswa.svg') ?>" alt="Mahasiswa Icon" class="mb-3 mx-auto" style="width: 50px; height: 50px;">
                        <h1 class="display-4 fw-bold text-primary counter" data-target="3866">0</h1>
                        <p class="text-uppercase fw-semibold text-secondary">Mahasiswa</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->section('style') ?>
<style>
    /* Jika Anda ingin warna spesifik #348CE5 untuk teks angka */
    .text-custom-blue {
        color: #348CE5 !important;
        /* !important mungkin diperlukan untuk override Bootstrap */
    }

    /* Opsional: gaya untuk memastikan angka tidak terlihat 'lompat' sebelum animasi dimulai */
    .counter {
        opacity: 1;
        /* Pastikan angka terlihat, animasi hanya pada nilainya */
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const counterSection = document.querySelector('.animated-counter-section');
        const counters = document.querySelectorAll('.counter');
        let animationTriggered = false; // Flag to ensure animation runs only once

        const animateCounter = (counterElement) => {
            const target = +counterElement.dataset.target;
            const duration = 2000; // 2 seconds
            let start = null;

            const step = (timestamp) => {
                if (!start) start = timestamp;
                const progress = timestamp - start;
                const current = Math.min(Math.floor(progress / duration * target), target);
                counterElement.textContent = current;
                if (progress < duration) {
                    requestAnimationFrame(step);
                } else {
                    counterElement.textContent = target; // Ensure final target value is set
                }
            };
            requestAnimationFrame(step);
        };

        const observerOptions = {
            root: null, // relative to the viewport
            rootMargin: '0px',
            threshold: 0.5 // Trigger when 50% of the section is visible
        };

        const sectionObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !animationTriggered) {
                    counters.forEach(counter => {
                        animateCounter(counter);
                    });
                    animationTriggered = true; // Set flag to true after triggering
                    observer.unobserve(entry.target); // Stop observing once animation is done
                }
            });
        }, observerOptions);

        if (counterSection) {
            sectionObserver.observe(counterSection);
        }
    });
</script>
<?= $this->endSection() ?>