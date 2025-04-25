<?= view('layout/header', ['title' => 'Inicio']) ?>

<main>
    <h2>Task List</h2>


    <section>
        <?php if (empty($tasks)): ?>
            <p>No hay tareas disponibles.</p>
        <?php else: ?>
            <?php foreach ($tasks as $task): ?>
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

</main>

<?= view('layout/footer') ?>