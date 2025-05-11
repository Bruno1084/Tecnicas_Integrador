<?= view('layout/header', ['styles' => [
    'header.css',
    'taskCard.css',
]]) ?>

<body>
    <h2>Completed Tasks</h2>

    <?= view('layout/TaskFilter') ?>

    <section>
        <?php if (empty($completedTasks)): ?>
            <p>No hay tareas completadas disponibles.</p>
        <?php else: ?>
            <?php foreach ($completedTasks as $task): ?>
                <?= view('layout/TaskCard', [
                    'id' => $task['id'],
                    'subject' => $task['subject'],
                    'description' => $task['description'],
                    'priority' => $task['priority'],
                    'state' => $task['state'],
                    'reminderDate' => $task['reminderDate'],
                    'expirationDate' => $task['expirationDate'],
                    'color' => $task['color'],
                ]) ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</body>

<?= view('layout/footer') ?>