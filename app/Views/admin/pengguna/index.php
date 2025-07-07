<h1>Data Users</h1>
<a href="/users/create">+ Tambah User</a>
<table>
    <?php foreach ($users as $u): ?>
        <tr>
            <td><?= esc($u['username']) ?></td>
            <td><a href="/users/edit/<?= $u['id'] ?>">Edit</a></td>
            <td><a href="/users/delete/<?= $u['id'] ?>">Delete</a></td>
        </tr>
    <?php endforeach ?>
</table>