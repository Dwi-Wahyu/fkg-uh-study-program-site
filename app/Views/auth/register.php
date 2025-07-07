<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<h2>Register</h2>

<!-- Flash message sukses -->
<?php if (session()->getFlashdata('success')): ?>
    <p style="color: green;"><?= esc(session()->getFlashdata('success')) ?></p>
<?php endif; ?>

<!-- Error validasi -->
<?php if (isset($validation)): ?>
    <div style="color: red;">
        <?= $validation->listErrors() ?>
    </div>
<?php endif; ?>

<form method="post" action="/register">
    <?= csrf_field() ?>

    <label>Username:</label><br>
    <input type="text" name="username" value="<?= set_value('username') ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= set_value('email') ?>" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Confirm Password:</label><br>
    <input type="password" name="confirm_password" required><br><br>

    <button class="btn btn-primary" type="submit">Register</button>
</form>

<form>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1">
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<p>Sudah punya akun? <a href="/login">Login di sini</a></p>

<?= $this->endSection() ?>