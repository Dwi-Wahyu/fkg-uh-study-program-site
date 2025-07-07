<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<h2>Tambah Berita</h2>

<form action="/admin/berita/store" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label for="judul" class="form-label">Judul Berita</label>
        <input type="text" class="form-control" id="judul" name="judul" required>
    </div>

    <div class="mb-3">
        <label for="konten" class="form-label">Konten</label>
        <textarea class="form-control" id="konten" name="konten" rows="5" required></textarea>
    </div>

    <div class="mb-3">
        <label for="gambar" class="form-label">Gambar Berita</label>
        <input class="form-control" type="file" id="gambar" name="gambar" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

<?= $this->endSection() ?>