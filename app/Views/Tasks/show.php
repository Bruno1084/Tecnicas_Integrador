<?= view('layout/header', ['title' => 'Show Task']) ?>
<h2>Detalle de la tarea</h2>

<h3>Subtareas</h3>
<main>
    <h2>Subtask List</h2>
    <section>
        <?php if (empty($subTasks)): ?>
            <p>No hay subtareas disponibles.</p>
        <?php else: ?>
            <?php foreach ($subTasks as $subtask): ?>
                <?= view('layout/SubTaskCard', [
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