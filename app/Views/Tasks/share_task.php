<?= view('layout/header', ['styles' => [
    'header.css',
    'tasksScreen.css',
    'taskCardPreview.css'
]]) ?>

<main>
    <form action="<?= site_url('/tasks/share_task/' . $task['id']) ?>" method="post">
        <?= csrf_field() ?>
        <label for="email">Correo del colaborador:</label>
        <input type="email" name="email" id="email" required>
        <button type="submit">Share</button>
    </form>

    <?php if (session()->has('message')): ?>
        <p><?= session('message') ?></p>
    <?php endif; ?>

    <?php if (session()->has('error')): ?>
        <p style="color:red;"><?= session('error') ?></p>
    <?php endif; ?>
</main>

<?= view('layout/footer') ?>