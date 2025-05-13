<?= view('layout/header', ['styles' => [
    'header.css',
    'taskCard.css',
    'subTaskCardPreview.css',
]]) ?>

<main class="taskCard-main">
    <?= view('layout/TaskCard') ?>
</main>

<?= view('layout/footer') ?>