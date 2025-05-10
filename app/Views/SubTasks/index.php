<?= view('layout/header', ['styles' => [
    'header.css',
    'subTaskCard.css',
    'taskCard.css',
]]) ?>
<h2>Task Detail</h2>

<main>
    <section>
        <h3>Subtareas</h3>
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
    </section>
    <section>
        <h2>Subtask List</h2>
        <?php if (empty($subTasks)): ?>
            <p>No hay subtareas disponibles.</p>
        <?php else: ?>
            <?php foreach ($subTasks as $subtask): ?>
                 <?= view('layout/SubTaskCard', [
                    'responsible' => $responsible['nickname'],
                    'id' => $subtask['id'],
                    'description' => $subtask['description'],
                    'priority' => $subtask['priority'],
                    'state' => $subtask['state'],
                    'reminderDate' => $subtask['reminderDate'],
                    'comment' => $subtask['comment'],
                ]) ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>


<?= view('layout/footer') ?>