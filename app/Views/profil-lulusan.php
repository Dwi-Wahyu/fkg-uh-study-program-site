<?= $this->extend('layout/main') ?>

<?= $this->section('style') ?>
<style>
    .profile-card {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
        height: 300px;
        /* Tinggi tetap untuk card agar seragam */
    }

    .profile-card:hover {
        transform: translateY(-5px);
    }

    .profile-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Pastikan gambar mengisi seluruh area */
        display: block;
    }

    .profile-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        /* Gradient dari hitam ke transparan */
        color: white;
        padding: 15px;
        opacity: 0;
        /* Sembunyikan secara default */
        transition: opacity 0.3s ease-in-out;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        height: 100%;
        /* Pastikan overlay menutupi seluruh card */
    }

    .profile-card:hover .profile-overlay {
        opacity: 1;
        /* Munculkan saat hover */
    }

    .profile-overlay h5 {
        font-size: 1.25rem;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .profile-overlay p {
        font-size: 0.9rem;
        line-height: 1.4;
        margin-bottom: 0;
        /* Batasi deskripsi singkat agar tidak terlalu panjang */
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        -webkit-line-clamp: 3;
        /* Batasi 3 baris */
    }

    .no-profile-data {
        padding: 20px;
        text-align: center;
        color: #6c757d;
    }

    .section-title {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 40px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mb-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="main-news-card p-4">
                <h4 class="section-title text-center">Profil Lulusan</h4>

                <?php if (!empty($profilLulusan)): ?>
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        <?php foreach ($profilLulusan as $profil): ?>
                            <div class="col">
                                <div class="profile-card">
                                    <?php if (!empty($profil['gambar'])): ?>
                                        <img src="<?= base_url('profil-lulusan/' . $profil['gambar']) ?>" alt="<?= esc($profil['judul'] ?? 'Gambar Profil Lulusan') ?>">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/400x300?text=No+Image" alt="No Image">
                                    <?php endif; ?>
                                    <div class="profile-overlay">
                                        <h5><?= esc($profil['judul'] ?? 'Tanpa Judul') ?></h5>
                                        <p><?= esc(character_limiter($profil['deskripsi'] ?? 'Tidak ada deskripsi singkat tersedia.', 100)) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-profile-data">
                        <p>Belum ada data profil lulusan yang tersedia.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>