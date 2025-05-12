<?= view('layout/header', ['styles' => [
    'header.css',
    'tasksScreen.css',
    'taskCardPreview.css'
]]) ?>

<main>
    <h2>Task List</h2>
    <a href="<?= site_url('new_task') ?>">Create Task</a>
    <a href="<?= site_url('completed_tasks') ?>">Completed Tasks</a>
    <?= view('layout/TaskFilter') ?>

    <section class="taskList--container">

        <?php if (empty($tasks)): ?>
            <p>No hay tareas disponibles.</p>
        <?php else: ?>
            <?php foreach ($tasks as $task): ?>
                <?= view('/layout/TaskCardPreview', [
                    'id'=> $task['id'],
                    'nickname' => $userNickname,
                    'subject' => $task['subject'],
                    'description' => $task['description'],
                    'priority' => $task['priority'],
                    'color' => $task['color'],
                ]) ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>

<?= view('layout/footer') ?>