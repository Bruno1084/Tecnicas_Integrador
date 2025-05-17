<?= view('layout/header', ['styles' => [
    'header.css',
    'tasksScreen.css',
    'taskCardPreview.css'
]]) ?>

<main>
    <h2>Shared Tasks</h2>

    <?= view('layout/TaskFilter') ?>

    <section class="taskList--container">
        <?php if (empty($sharedTasks)): ?>
            <p>No hay tareas disponibles.</p>
        <?php else: ?>
            <?php foreach ($sharedTasks as $task): ?>
                <?= view('/layout/TaskCardPreview', [
                    'id' => $task['id'],
                    'nickname' => $task['authorNickname'],
                    'subject' => $task['subject'],
                    'description' => $task['description'],
                    'priority' => $task['priority'],
                ]) ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>

<?= view('layout/footer') ?>