<?= view('layout/header', ['styles' => [
    'header.css',
    'tasksScreen.css',
    'taskCardPreview.css'
]]) ?>

<?php
function getColorByPriority($priority)
{
    switch ($priority) {
        case 'baja':
            return '#9FF4CF';
        case 'media':
            return '#A4E3FA';
        case 'alta':
            return '#FFB6B9';
        default:
            return 'white';
    }
}
?>

<main>
    <h2>Task List</h2>
    <a href="<?= site_url('new_task') ?>">Create Task</a>
    <?= view('layout/TaskFilter') ?>

    <section class="taskList--container">

        <?php if (empty($tasks)): ?>
            <p>No hay tareas disponibles.</p>
        <?php else: ?>
            <?php foreach ($tasks as $task): ?>
                <?php $color = getColorByPriority($task['priority'])?>
                <?= view('/layout/TaskCardPreview', [
                    'id' => $task['id'],
                    'nickname' => $userNickname,
                    'subject' => $task['subject'],
                    'description' => $task['description'],
                    'priority' => $task['priority'],
                    'color' => $color,
                ]) ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>

<?= view('layout/footer') ?>