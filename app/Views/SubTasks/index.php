<?= view('layout/header', ['styles' => [
    'header.css',
    'taskCard.css',
    'subTaskCardPreview.css',
]]) ?>

<main class="taskCard-main">
    <section class="taskCard--container">
        <div class="taskCard-task-col taskCard-col1">
            <div class="taskCard-task-header">
                <p><strong>Task Card</strong></p>
            </div>
            <div class="taskCard-task-body">
                <p><strong>Task Description</strong></p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate eveniet ab commodi cumque earum, eos fugiat totam quos illum sequi quam laudantium ut deserunt aliquam delectus harum fugit dolorum corporis.</p>
            </div>

            <!-- SubtasksCard preview list -->
            <div class="taskCard-subtaskList">
                <?php if (empty($subTasks)): ?>
                    <p>No hay subtareas disponibles.</p>
                <?php else: ?>
                    <?php foreach ($subTasks as $subtask): ?>
                        <?= view('layout/SubTaskCardPreview', [
                            'idTask' => $task['id'],
                            'idSubTask' => $subtask['id'],
                            'nickname' => $responsible['nickname'],
                            'priority' => $subtask['priority'],
                            'subject' => $subtask['subject'],
                            'description' => $subtask['description'],
                        ]) ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="taskCard-task-col taskCard-col2">
            <div>
                <p><strong>Color</strong></p>
            </div>
            <div>
                <p><strong>State</strong></p>
                <p>En Proceso</p>
            </div>
            <div>
                <p><strong>Priority</strong></p>
                <p>Alta</p>
            </div>
            <div>
                <p><strong>Expiration Date</strong></p>
                <p>date</p>
            </div>
            <div>
                <p><strong>Reminder Date</strong></p>
                <p>date</p>
            </div>
            <div>
                <button>New Subtask</button>
                <button>Edit Task</button>
            </div>
        </div>
    </section>
</main>

<?= view('layout/footer') ?>