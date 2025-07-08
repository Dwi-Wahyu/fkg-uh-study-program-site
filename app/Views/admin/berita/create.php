<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<form action="/admin/berita/store" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label for="judul" class="form-label">Judul Berita</label>
                <input type="text" class="form-control" id="judul" name="judul" required>
            </div>

            <div class="mb-3">
                <label for="gambar" class="form-label">Thumbnail</label>
                <input class="form-control" type="file" id="gambar" name="gambar" accept="image/*">
            </div>

            <div class="vignette mb-3">
                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                    <label for="detail" class="mb-1">Detail Berita * :</label>
                    <textarea class="editor" name="detail" id="detail"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>

    <script src="<?= base_url('assets/vendor/tinymce/tinymce.min.js') ?>"></script>

    <script src="<?= base_url('assets/vendor/tinymce/init.js') ?>"></script>


</form>

<?= $this->endSection() ?>