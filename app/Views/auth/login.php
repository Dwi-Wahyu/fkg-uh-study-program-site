<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<h2>Login</h2>

<?php if (!empty($error)) : ?>
    <p style="color: red;"><?= esc($error) ?></p>
<?php endif; ?>

<form method="post" action="/login">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>

    <a href="/register">Register</a>
</form>


<?= $this->endSection() ?>